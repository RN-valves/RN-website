<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Illuminate\Support\Facades\DB;

use App\Models\{
    Product,
    Color,
    ProductAttribute,
    ProductImage,
    Subcategory
};
use App\Traits\DefaultTrait;
use App\Support\ProductImportProgress;

class ProductImport implements
    ToCollection,
    WithHeadingRow,
    WithChunkReading,
    WithBatchInserts,
    SkipsOnError
{
    use DefaultTrait;
    use Importable, SkipsErrors, SkipsFailures;

    /** @var \Illuminate\Support\Collection|null */
    protected $subcategoriesByName;

    /** @var \Illuminate\Support\Collection|null */
    protected $colorsByName;

    protected int $processedRows = 0;

    /** @var array */
    protected array $skippedRows = [];

    public function getSkippedRows(): array
    {
        return $this->skippedRows;
    }

    public function __construct(
        protected ?string $progressToken = null,
        protected int $totalRows = 0,
    ) {
    }

    protected function normalizeImageUrl(?string $url): string
    {
        return normalizeProductImageUrl($url);
    }

    /**
     * Safely parse price/numeric values from Excel rows:
     * - Strips currency symbols (₹, $), commas (1,250.00 -> 1250.00), and spaces.
     * - Checks case-insensitive & space-insensitive header keys (e.g. IN MRP, in_mrp, mrp).
     * - Preserves existing DB fallback value if column is missing or empty.
     */
    protected function parseNumber($row, array $keys, float $fallback = 0.0): float
    {
        $row = is_array($row) ? $row : ($row instanceof \Illuminate\Support\Collection ? $row->toArray() : (array) $row);
        foreach ($keys as $key) {
            $val = $row[$key] ?? null;

            if ($val === null) {
                $target = strtolower(str_replace([' ', '-'], '_', $key));
                foreach ($row as $rKey => $rVal) {
                    $normKey = strtolower(str_replace([' ', '-'], '_', trim((string) $rKey)));
                    if ($normKey === $target) {
                        $val = $rVal;
                        break;
                    }
                }
            }

            if ($val !== null && trim((string) $val) !== '') {
                $cleaned = preg_replace('/[^\d\.]/', '', str_replace(',', '', (string) $val));
                if ($cleaned !== '' && is_numeric($cleaned)) {
                    return round((float) $cleaned, 2);
                }
            }
        }

        return $fallback;
    }

    protected function bumpProgress(int $count): void
    {
        if (!$this->progressToken) {
            return;
        }

        $this->processedRows += $count;

        ProductImportProgress::write([
            'status' => 'running',
            'processed' => $this->processedRows,
            'total' => $this->totalRows,
            'message' => 'Importing products…',
        ], $this->progressToken);
    }

    /**
     * Prefetch lookups once and reuse per chunk to keep ~7000-row Excel uploads
     * under nginx gateway timeouts.
     */
    protected function bootLookups(): void
    {
        if ($this->subcategoriesByName === null) {
            $this->subcategoriesByName = Subcategory::query()
                ->get(['id', 'name', 'category_id'])
                ->keyBy(fn ($row) => strtolower(trim((string) $row->name)));
        }

        if ($this->colorsByName === null) {
            $this->colorsByName = Color::query()
                ->get(['id', 'name', 'icon'])
                ->keyBy(fn ($row) => strtolower(trim((string) $row->name)));
        }
    }

    /**
     * @param  Collection  $rows
     * @return void
     */
    public function collection(Collection $rows)
    {
        $this->bootLookups();

        $skuCodes = $rows
            ->map(fn ($row) => trim((string) ($row['sku_code'] ?? '')))
            ->filter()
            ->unique()
            ->values()
            ->all();

        $productsBySku = Product::whereIn('sku_code', $skuCodes)
            ->get()
            ->keyBy('sku_code');

        $productIds = $productsBySku->pluck('id')->all();
        $attributesByProductId = $productIds
            ? ProductAttribute::whereIn('product_id', $productIds)->get()->keyBy('product_id')
            : collect();

        $galleryImagesByProductId = $productIds
            ? ProductImage::whereIn('product_id', $productIds)->get(['id', 'product_id', 'image'])->groupBy('product_id')
            : collect();

        DB::transaction(function () use ($rows, $productsBySku, $attributesByProductId, $galleryImagesByProductId) {
            $rowNum = 1;
            foreach ($rows as $row) {
                $rowNum++;
                $row = is_array($row) ? $row : ($row instanceof \Illuminate\Support\Collection ? $row->toArray() : (array) $row);
                $skuCode = trim((string) ($row['sku_code'] ?? ''));
                $productName = trim((string) ($row['name'] ?? 'N/A'));

                if ($skuCode === '') {
                    $this->skippedRows[] = [
                        'row' => $rowNum,
                        'sku_code' => 'N/A',
                        'name' => $productName,
                        'reason' => 'SKU code is missing or empty'
                    ];
                    continue;
                }

                $rawSubcategory = trim((string) ($row['subcategory'] ?? ''));
                $subcategoryName = strtolower($rawSubcategory);
                $subcategory = $this->subcategoriesByName->get($subcategoryName);
                if (!$subcategory) {
                    $this->skippedRows[] = [
                        'row' => $rowNum,
                        'sku_code' => $skuCode,
                        'name' => $productName,
                        'reason' => $rawSubcategory === ''
                            ? 'Subcategory is missing'
                            : "Subcategory '{$rawSubcategory}' not found in database"
                    ];
                    continue;
                }

                $product = $productsBySku->get($skuCode);
                $isNew = empty($product);

                $colorName = strtolower(trim((string) ($row['color_name'] ?? '')));
                $color = $this->colorsByName->get($colorName);

                $uuid = $isNew ? str()->uuid()->toString() : $product->uuid;
                $resolvedColorName = $color->name ?? ($row['color_name'] ?? null);
                $productName = $row['name'] ?? '';

                $productData = [
                    'sku_code' => $skuCode,
                    'in_mrp' => $this->parseNumber($row, ['in_mrp', 'in mrp', 'mrp'], $isNew ? 0.0 : (float) ($product->in_mrp ?? 0)),
                    'in_selling' => $this->parseNumber($row, ['in_selling', 'in selling', 'selling', 'selling_price'], $isNew ? 0.0 : (float) ($product->in_selling ?? 0)),
                    'in_v1_mrp' => $this->parseNumber($row, ['in_v1_mrp', 'in v1 mrp'], $isNew ? 0.0 : (float) ($product->in_v1_mrp ?? 0)),
                    'oth_mrp' => $this->parseNumber($row, ['oth_mrp', 'oth mrp'], $isNew ? 0.0 : (float) ($product->oth_mrp ?? 0)),
                    'oth_selling' => $this->parseNumber($row, ['oth_selling', 'oth selling'], $isNew ? 0.0 : (float) ($product->oth_selling ?? 0)),
                    'oth_v1_mrp' => $this->parseNumber($row, ['oth_v1_mrp', 'oth v1 mrp'], $isNew ? 0.0 : (float) ($product->oth_v1_mrp ?? 0)),
                    'color_group_id' => $row['color_group_id'] ?? ($isNew ? str()->uuid()->toString() : $product->color_group_id),
                    'packaging_group_id' => $row['packaging_group_id'] ?? ($isNew ? str()->uuid()->toString() : $product->packaging_group_id),
                    'product_combo_id' => $row['product_combo_id'] ?? ($isNew ? str()->uuid()->toString() : $product->product_combo_id),
                    'product_size_id' => $row['product_size_id'] ?? ($isNew ? str()->uuid()->toString() : $product->product_size_id),
                    'uuid' => $uuid,
                    'url_key' => $isNew ? str($productName)->append('-'.$skuCode)->slug()->toString() : ($productName !== '' ? str($productName)->append('-'.$skuCode)->slug()->toString() : $product->url_key),
                    'category_id' => $subcategory->category_id,
                    'subcategory_id' => $subcategory->id,
                    'brand' => array_key_exists('brand', $row) ? $row['brand'] : ($isNew ? null : $product->brand),
                    'content_id' => array_key_exists('content_id', $row) ? $row['content_id'] : ($isNew ? null : $product->content_id),
                    'material' => array_key_exists('material', $row) ? $row['material'] : ($isNew ? null : $product->material),
                    'color_name' => $resolvedColorName,
                    'packaging_name' => $row['packaging_name'] ?? ($isNew ? str()->uuid()->toString() : $product->packaging_name),
                    'color_icon' => $color->icon ?? ($isNew ? null : $product->color_icon),
                    'name' => $productName ?: ($isNew ? '' : $product->name),
                    'article' => array_key_exists('article', $row) ? $row['article'] : ($isNew ? null : $product->article),
                    'size' => array_key_exists('size', $row) ? $row['size'] : ($isNew ? null : $product->size),
                    'hsn' => array_key_exists('hsn', $row) ? $row['hsn'] : ($isNew ? null : $product->hsn),
                    'image' => array_key_exists('image', $row) ? $row['image'] : ($isNew ? null : $product->image),
                    'title' => array_key_exists('title', $row) ? $row['title'] : ($isNew ? null : $product->title),
                    'keywords' => array_key_exists('keywords', $row) ? $row['keywords'] : ($isNew ? null : $product->keywords),
                    'description' => array_key_exists('description', $row) ? $row['description'] : ($isNew ? null : $product->description),
                    'search_keywords' => array_key_exists('search_keywords', $row) ? $row['search_keywords'] : ($isNew ? null : $product->search_keywords),
                    'is_full_turn' => (int) ($row['is_full_turn'] ?? ($isNew ? 0 : $product->is_full_turn)),
                    'full_turn_code' => $row['full_turn_code'] ?? ($isNew ? '0' : $product->full_turn_code),
                    'sale_type' => $row['sale_type'] ?? ($isNew ? 'BASS' : $product->sale_type),
                ];

                // Empty/blank is_visible_website = hidden (0); only 1 keeps product visible
                $visibleWeb = isset($row['is_visible_website']) ? trim((string) $row['is_visible_website']) : '';
                $productData['is_visible_website'] = ($visibleWeb !== '') ? (int) $visibleWeb : 0;
                $productData['is_visible_api'] = (isset($row['is_visible_api']) && $row['is_visible_api'] !== '')
                    ? (int) $row['is_visible_api']
                    : ($isNew ? 0 : (int) $product->is_visible_api);
                $productData['new_arrival'] = (isset($row['new_arrival']) && $row['new_arrival'] !== '')
                    ? (int) $row['new_arrival']
                    : ($isNew ? 0 : (int) $product->new_arrival);
                $productData['is_featured'] = (isset($row['is_featured']) && $row['is_featured'] !== '')
                    ? (int) $row['is_featured']
                    : ($isNew ? 0 : (int) $product->is_featured);
                $productData['status'] = (isset($row['status']) && $row['status'] !== '')
                    ? $row['status']
                    : ($isNew ? 'Active' : $product->status);

                if ($isNew) {
                    $product = Product::create($productData);
                    $productsBySku->put($skuCode, $product);
                } else {
                    $product->fill($productData);
                    if ($product->isDirty()) {
                        $product->save();
                    }
                }

                // Main product image must not also sit in the gallery (causes double display
                // in big image + thumbnails after Update Template re-import).
                $mainImageNormalized = $this->normalizeImageUrl($productData['image'] ?? '');
                if ($mainImageNormalized !== '') {
                    $galleryRows = $galleryImagesByProductId->get($product->id, collect());
                    $remaining = collect();
                    $deleteIds = [];

                    foreach ($galleryRows as $galleryImage) {
                        if ($this->normalizeImageUrl($galleryImage->image) === $mainImageNormalized) {
                            $deleteIds[] = $galleryImage->id;
                        } else {
                            $remaining->push($galleryImage);
                        }
                    }

                    if ($deleteIds !== []) {
                        ProductImage::whereIn('id', $deleteIds)->delete();
                    }

                    $galleryImagesByProductId->put($product->id, $remaining);
                }

                $existingAttr = $attributesByProductId->get($product->id);
                $attributeData = [
                    'product_id' => $product->id,
                    'sku_code' => $skuCode,
                    'ctn_pcs' => array_key_exists('ctn_pcs', $row) ? $row['ctn_pcs'] : ($existingAttr->ctn_pcs ?? null),
                    'mid_ctn_pcs' => array_key_exists('mid_ctn_pcs', $row) ? $row['mid_ctn_pcs'] : ($existingAttr->mid_ctn_pcs ?? null),
                    'inner_pcs' => array_key_exists('inner_pcs', $row) ? $row['inner_pcs'] : ($existingAttr->inner_pcs ?? null),
                    'stock_pcs' => array_key_exists('stock_pcs', $row) ? $row['stock_pcs'] : ($existingAttr->stock_pcs ?? null),
                    'only_product_wt_gm' => array_key_exists('only_product_wt_gm', $row) ? $row['only_product_wt_gm'] : ($existingAttr->only_product_wt_gm ?? null),
                    'product_length' => array_key_exists('product_length', $row) ? $row['product_length'] : ($existingAttr->product_length ?? null),
                    'product_breadth' => array_key_exists('product_breadth', $row) ? $row['product_breadth'] : ($existingAttr->product_breadth ?? null),
                    'product_height' => array_key_exists('product_height', $row) ? $row['product_height'] : ($existingAttr->product_height ?? null),
                    'product_lbh_weight_gm' => array_key_exists('product_lbh_weight_gm', $row) ? $row['product_lbh_weight_gm'] : ($existingAttr->product_lbh_weight_gm ?? null),
                    'mid_ctn_lbh_weight_kg' => array_key_exists('mid_ctn_lbh_weight_kg', $row) ? $row['mid_ctn_lbh_weight_kg'] : ($existingAttr->mid_ctn_lbh_weight_kg ?? null),
                    'master_ctn_lbh_weight_kg' => array_key_exists('master_ctn_lbh_weight_kg', $row) ? $row['master_ctn_lbh_weight_kg'] : ($existingAttr->master_ctn_lbh_weight_kg ?? null),
                    'residential_warranty' => array_key_exists('residential_warranty', $row) ? $row['residential_warranty'] : ($existingAttr->residential_warranty ?? null),
                    'commercial_warranty' => array_key_exists('commercial_warranty', $row) ? $row['commercial_warranty'] : ($existingAttr->commercial_warranty ?? null),
                    'amazon_link' => array_key_exists('amazon_link', $row) ? $row['amazon_link'] : ($existingAttr->amazon_link ?? null),
                    'flipkart_link' => array_key_exists('flipkart_link', $row) ? $row['flipkart_link'] : ($existingAttr->flipkart_link ?? null),
                    'short_description' => array_key_exists('short_description', $row) ? $row['short_description'] : ($existingAttr->short_description ?? null),
                    'video_url' => array_key_exists('video_url', $row) ? $row['video_url'] : ($existingAttr->video_url ?? null),
                ];

                $attribute = $attributesByProductId->get($product->id);
                if ($attribute) {
                    $attribute->fill($attributeData);
                    if ($attribute->isDirty()) {
                        $attribute->save();
                    }
                } else {
                    $attribute = ProductAttribute::create($attributeData);
                    $attributesByProductId->put($product->id, $attribute);
                }
            }
        });

        $this->bumpProgress($rows->count());
    }

    public function chunkSize(): int
    {
        return 250;
    }

    public function batchSize(): int
    {
        return 250;
    }

    /**
     * Read-only pre-check: validates uploaded Excel file without modifying DB.
     * Returns stats for preview: total, updates, new creations, and skipped rows with reasons.
     */
    public function validateAndAnalyze(string $filePath): array
    {
        $this->bootLookups();

        try {
            $sheets = (new \Rap2hpoutre\FastExcel\FastExcel())->import($filePath);
        } catch (\Throwable $e) {
            return [
                'total_rows' => 0,
                'update_rows' => 0,
                'new_rows' => 0,
                'skipped_rows' => [
                    ['row' => 1, 'sku_code' => 'N/A', 'name' => 'N/A', 'reason' => 'Failed to parse Excel file: '.$e->getMessage()]
                ],
            ];
        }

        $totalRows = 0;
        $updateRows = 0;
        $newRows = 0;
        $skippedRows = [];

        $skuCodes = collect($sheets)
            ->pluck('sku_code')
            ->map(fn ($s) => trim((string) $s))
            ->filter()
            ->unique()
            ->values()
            ->all();

        $existingProducts = Product::whereIn('sku_code', $skuCodes)->get()->keyBy('sku_code');

        $totalRows = 0;
        $updateRows = 0;
        $modifiedRows = 0;
        $unchangedRows = 0;
        $newRows = 0;
        $skippedRows = [];

        $rowIndex = 1; // 1-indexed (row 1 is header row)
        foreach ($sheets as $row) {
            $rowIndex++;
            $totalRows++;
            $rowArr = is_array($row) ? $row : ($row instanceof \Illuminate\Support\Collection ? $row->toArray() : (array) $row);

            $skuCode = trim((string) ($rowArr['sku_code'] ?? ''));
            $productName = trim((string) ($rowArr['name'] ?? 'N/A'));
            $rawSubcategory = trim((string) ($rowArr['subcategory'] ?? ''));

            if ($skuCode === '') {
                $skippedRows[] = [
                    'row' => $rowIndex,
                    'sku_code' => 'N/A',
                    'name' => $productName,
                    'reason' => 'SKU code is missing or empty',
                ];
                continue;
            }

            $subcategory = $this->subcategoriesByName->get(strtolower($rawSubcategory));
            if (!$subcategory) {
                $skippedRows[] = [
                    'row' => $rowIndex,
                    'sku_code' => $skuCode,
                    'name' => $productName,
                    'reason' => $rawSubcategory === ''
                        ? 'Subcategory is missing'
                        : "Subcategory '{$rawSubcategory}' not found in database",
                ];
                continue;
            }

            $product = $existingProducts->get($skuCode);
            if ($product) {
                $updateRows++;
                $isChanged = false;

                $inMrp = $this->parseNumber($rowArr, ['in_mrp', 'in mrp', 'mrp'], (float) $product->in_mrp);
                $inSelling = $this->parseNumber($rowArr, ['in_selling', 'in selling', 'selling', 'selling_price'], (float) $product->in_selling);
                $othMrp = $this->parseNumber($rowArr, ['oth_mrp', 'oth mrp'], (float) $product->oth_mrp);
                $othSelling = $this->parseNumber($rowArr, ['oth_selling', 'oth selling'], (float) $product->oth_selling);

                if (
                    abs($inMrp - (float) $product->in_mrp) > 0.001 ||
                    abs($inSelling - (float) $product->in_selling) > 0.001 ||
                    abs($othMrp - (float) $product->oth_mrp) > 0.001 ||
                    abs($othSelling - (float) $product->oth_selling) > 0.001
                ) {
                    $isChanged = true;
                }

                if ($isChanged) {
                    $modifiedRows++;
                } else {
                    $unchangedRows++;
                }
            } else {
                $newRows++;
            }
        }

        return [
            'total_rows' => $totalRows,
            'update_rows' => $updateRows,
            'modified_rows' => $modifiedRows,
            'unchanged_rows' => $unchangedRows,
            'new_rows' => $newRows,
            'skipped_rows' => $skippedRows,
        ];
    }
}
