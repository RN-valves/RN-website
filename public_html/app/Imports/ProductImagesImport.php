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

        foreach ($rows as $row) {
            $skuCode = trim((string) ($row['sku_code'] ?? ''));
            $image = trim((string) ($row['image'] ?? ''));
            if ($skuCode === '' || $image === '') {
                continue;
            }

            $product = $productsBySku->get($skuCode);
            if (!empty($product)) {
                ProductImage::updateOrCreate(
                    [
                        'sku_code' => $skuCode,
                        'image' => $image,
                    ],
                    [
                        'image' => $image,
                        'sku_code' => $skuCode,
                        'product_id' => $product['id'],
                        'created_by' => optional(auth()->user())->name ?? 'system',
                    ],
                );
            }
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
