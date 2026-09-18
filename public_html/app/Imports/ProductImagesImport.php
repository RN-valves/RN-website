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
use Illuminate\Support\Facades\Artisan;

use App\Models\{
    ProductImage,
    Product
};
use App\Traits\DefaultTrait;

class ProductImagesImport implements 
    ToCollection,
    WithHeadingRow,
    WithChunkReading,
    WithBatchInserts,
    SkipsOnError
{
    use DefaultTrait;
    use Importable, SkipsErrors;

    public int $created = 0;
    public int $updated = 0;
    public int $skipped = 0;
    public int $mainSynced = 0;

    protected function normalizeImageUrl(?string $url): string
    {
        return normalizeProductImageUrl($url);
    }

    protected function truthy($value): bool
    {
        if (is_bool($value)) {
            return $value;
        }

        $value = strtolower(trim((string) $value));

        return in_array($value, ['1', 'yes', 'y', 'true', 'main'], true);
    }

    protected function getRowSkuCode($row): string
    {
        return trim((string) (
            $row['sku_code']
            ?? $row['sku']
            ?? $row['product_code']
            ?? $row['article']
            ?? $row['product_sku']
            ?? ''
        ));
    }

    protected function getRowImageUrl($row): string
    {
        return trim((string) (
            $row['image']
            ?? $row['image_url']
            ?? $row['url']
            ?? $row['img']
            ?? $row['product_image']
            ?? ''
        ));
    }

    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        $skuCodes = $rows
            ->map(fn ($row) => $this->getRowSkuCode($row))
            ->filter()
            ->unique()
            ->values()
            ->all();

        $ids = $rows
            ->map(fn ($row) => (int) ($row['id'] ?? 0))
            ->filter(fn ($id) => $id > 0)
            ->unique()
            ->values()
            ->all();

        // Query Products by sku_code OR article to ensure product_id is found
        $products = Product::whereIn('sku_code', $skuCodes)
            ->orWhereIn('article', $skuCodes)
            ->get();

        $productsByKey = collect();
        foreach ($products as $p) {
            if (!empty($p->sku_code)) {
                $productsByKey->put(strtolower(trim($p->sku_code)), $p);
            }
            if (!empty($p->article)) {
                $productsByKey->put(strtolower(trim($p->article)), $p);
            }
        }

        $existingById = $ids
            ? ProductImage::whereIn('id', $ids)->get()->keyBy('id')
            : collect();

        $existingImages = ProductImage::whereIn('sku_code', $skuCodes)
            ->get()
            ->groupBy(fn($img) => strtolower(trim($img->sku_code)));

        foreach ($rows as $row) {
            $rowId    = (int) ($row['id'] ?? 0);
            $skuCode  = $this->getRowSkuCode($row);
            $image    = $this->getRowImageUrl($row);
            $forceMain = $this->truthy($row['is_main'] ?? $row['update_main'] ?? false);

            if ($skuCode === '' || $image === '') {
                $this->skipped++;
                continue;
            }

            $product   = $productsByKey->get(strtolower($skuCode));
            $productId = $product ? $product->id : null;

            // If product_id is required by database constraint, skip if SKU code doesn't exist in products table
            if (empty($productId)) {
                $this->skipped++;
                continue;
            }

            $normalizedImage = $this->normalizeImageUrl($image);
            $mainImage       = $product ? $this->normalizeImageUrl($product->image ?? '') : '';

            // Update Template rows (includes id column)
            if ($rowId > 0) {
                $existing = $existingById->get($rowId);
                if (!$existing) {
                    $existing = ProductImage::find($rowId);
                }

                if ($existing) {
                    $existing->fill([
                        'image'      => $image,
                        'sku_code'   => $skuCode,
                        'product_id' => $productId,
                    ]);

                    if ($existing->isDirty()) {
                        $existing->save();
                        $this->updated++;
                    } else {
                        $this->updated++;
                    }

                    if ($forceMain && $product && $mainImage !== $normalizedImage) {
                        $product->image = $image;
                        $product->save();
                        $this->mainSynced++;
                    }

                    continue;
                }
            }

            // Match existing images by exact sku_code
            $skuKey      = strtolower($skuCode);
            $skuExisting = $existingImages->get($skuKey, collect());

            $alreadyExists = $skuExisting->first(function($existRow) use ($normalizedImage, $image) {
                return $existRow->image === $image 
                    || ($this->normalizeImageUrl($existRow->image) !== '' && $this->normalizeImageUrl($existRow->image) === $normalizedImage);
            });

            if ($alreadyExists) {
                // Update existing record image URL and product_id
                if ($alreadyExists->image !== $image || $alreadyExists->product_id !== $productId) {
                    $alreadyExists->image = $image;
                    $alreadyExists->product_id = $productId;
                    $alreadyExists->save();
                    $this->updated++;
                } else {
                    $this->skipped++;
                }

                if ($forceMain && $product && $mainImage !== $normalizedImage) {
                    $product->image = $image;
                    $product->save();
                    $this->mainSynced++;
                }

                continue;
            }

            // Create new product image record with validated product_id
            $created = ProductImage::create([
                'image'      => $image,
                'sku_code'   => $skuCode,
                'product_id' => $productId,
                'created_by' => optional(auth()->user())->name ?? 'system',
            ]);

            $this->created++;

            if ($forceMain && $product) {
                $product->image = $image;
                $product->save();
                $this->mainSynced++;
            }
        }

        // Clear view and app cache so changes reflect instantly
        try {
            Artisan::call('view:clear');
            Artisan::call('cache:clear');
        } catch (\Exception $e) {
            // Ignore cache clear exceptions in web execution
        }
    }

    public function summaryMessage(): string
    {
        $message = sprintf(
            'Import finished: %d updated, %d created, %d skipped.',
            $this->updated,
            $this->created,
            $this->skipped
        );

        if ($this->mainSynced > 0) {
            $message .= sprintf(' Website main image synced for %d product(s).', $this->mainSynced);
        }

        if ($this->skipped > 0) {
            $message .= sprintf(' (%d row(s) skipped because SKU code was not found in Products catalog or empty).', $this->skipped);
        }

        return $message;
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function batchSize(): int
    {
        return 500;
    }
}
