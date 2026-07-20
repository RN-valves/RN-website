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

    protected function normalizeImageUrl(?string $url): string
    {
        return normalizeProductImageUrl($url);
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    
    public function collection(Collection $rows)
    {
        // Prefetch products for this chunk to avoid N+1 lookups (keeps large Excel uploads fast)
        $skuCodes = $rows
            ->map(fn ($row) => trim((string) ($row['sku_code'] ?? '')))
            ->filter()
            ->unique()
            ->values()
            ->all();

        $productsBySku = Product::whereIn('sku_code', $skuCodes)
            ->get()
            ->keyBy('sku_code');

        $existingImages = ProductImage::whereIn('sku_code', $skuCodes)
            ->get()
            ->groupBy('sku_code');

        foreach ($rows as $row) {
            $skuCode = trim((string) ($row['sku_code'] ?? ''));
            $image = trim((string) ($row['image'] ?? ''));
            if ($skuCode === '' || $image === '') {
                continue;
            }

            $product = $productsBySku->get($skuCode);
            if (empty($product)) {
                continue;
            }

            $normalizedImage = $this->normalizeImageUrl($image);
            $mainImage = $this->normalizeImageUrl($product->image ?? '');

            // Main product image is already shown on the product page — do not add it to gallery again.
            if ($normalizedImage !== '' && $normalizedImage === $mainImage) {
                continue;
            }

            $skuExisting = $existingImages->get($skuCode, collect());
            $alreadyExists = $skuExisting->contains(
                fn ($existing) => $this->normalizeImageUrl($existing->image) === $normalizedImage
            );
            if ($alreadyExists) {
                continue;
            }

            $created = ProductImage::create([
                'image' => $image,
                'sku_code' => $skuCode,
                'product_id' => $product->id,
                'created_by' => optional(auth()->user())->name ?? 'system',
            ]);

            $existingImages->put(
                $skuCode,
                $skuExisting->push($created)
            );
        }
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
