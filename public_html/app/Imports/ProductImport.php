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
    Subcategory
};
use App\Traits\DefaultTrait;

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

        DB::transaction(function () use ($rows, $productsBySku, $attributesByProductId) {
            foreach ($rows as $row) {
                $skuCode = trim((string) ($row['sku_code'] ?? ''));
                if ($skuCode === '') {
                    continue;
                }

                $subcategoryName = strtolower(trim((string) ($row['subcategory'] ?? '')));
                $subcategory = $this->subcategoriesByName->get($subcategoryName);
                if (!$subcategory) {
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
                    'in_mrp' => isset($row['in_mrp']) ? round((float) $row['in_mrp'], 2) : 0.0,
                    'in_selling' => isset($row['in_selling']) ? round((float) $row['in_selling'], 2) : 0.0,
                    'in_v1_mrp' => isset($row['in_v1_mrp']) ? round((float) $row['in_v1_mrp'], 2) : 0.0,
                    'oth_mrp' => isset($row['oth_mrp']) ? round((float) $row['oth_mrp'], 2) : 0.0,
                    'oth_selling' => isset($row['oth_selling']) ? round((float) $row['oth_selling'], 2) : 0.0,
                    'oth_v1_mrp' => isset($row['oth_v1_mrp']) ? round((float) $row['oth_v1_mrp'], 2) : 0.0,
                    'color_group_id' => $row['color_group_id'] ?? str()->uuid()->toString(),
                    'packaging_group_id' => $row['packaging_group_id'] ?? str()->uuid()->toString(),
                    'product_combo_id' => $row['product_combo_id'] ?? str()->uuid()->toString(),
                    'product_size_id' => $row['product_size_id'] ?? str()->uuid()->toString(),
                    'uuid' => $uuid,
                    'url_key' => str($productName)->append('-'.$skuCode)->slug()->toString(),
                    'category_id' => $subcategory->category_id,
                    'subcategory_id' => $subcategory->id,
                    'brand' => $row['brand'],
                    'content_id' => $row['content_id'],
                    'material' => $row['material'],
                    'color_name' => $resolvedColorName,
                    'packaging_name' => $row['packaging_name'] ?? str()->uuid()->toString(),
                    'color_icon' => $color->icon ?? null,
                    'name' => $productName,
                    'article' => $row['article'],
                    'size' => $row['size'],
                    'hsn' => $row['hsn'],
                    'image' => $row['image'],
                    'title' => $row['title'],
                    'keywords' => $row['keywords'],
                    'description' => $row['description'],
                    'search_keywords' => $row['search_keywords'],
                    'is_full_turn' => (int) ($row['is_full_turn'] ?? 0),
                    'full_turn_code' => $row['full_turn_code'] ?? '0',
                    'sale_type' => $row['sale_type'] ?? 'BASS',
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
                    $product->fill($productData)->save();
                }

                $attributeData = [
                    'product_id' => $product->id,
                    'sku_code' => $skuCode,
                    'ctn_pcs' => $row['ctn_pcs'],
                    'mid_ctn_pcs' => $row['mid_ctn_pcs'],
                    'inner_pcs' => $row['inner_pcs'],
                    'stock_pcs' => $row['stock_pcs'],
                    'only_product_wt_gm' => $row['only_product_wt_gm'],
                    'product_length' => $row['product_length'],
                    'product_breadth' => $row['product_breadth'],
                    'product_height' => $row['product_height'],
                    'product_lbh_weight_gm' => $row['product_lbh_weight_gm'],
                    'mid_ctn_lbh_weight_kg' => $row['mid_ctn_lbh_weight_kg'],
                    'master_ctn_lbh_weight_kg' => $row['master_ctn_lbh_weight_kg'],
                    'residential_warranty' => $row['residential_warranty'],
                    'commercial_warranty' => $row['commercial_warranty'],
                    'amazon_link' => $row['amazon_link'] ?? null,
                    'flipkart_link' => $row['flipkart_link'] ?? null,
                    'short_description' => $row['short_description'] ?? null,
                    'video_url' => $row['video_url'] ?? null,
                ];

                $attribute = $attributesByProductId->get($product->id);
                if ($attribute) {
                    $attribute->fill($attributeData)->save();
                } else {
                    $attribute = ProductAttribute::create($attributeData);
                    $attributesByProductId->put($product->id, $attribute);
                }
            }
        });
    }

    public function chunkSize(): int
    {
        return 250;
    }

    public function batchSize(): int
    {
        return 250;
    }
}
