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

    public int $created = 0;
    public int $updated = 0;
    public int $skipped = 0;

    protected function normalizeImageUrl(?string $url): string
    {
        return normalizeProductImageUrl($url);
    }

    /**
     * @param Collection $rows
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

        $ids = $rows
            ->map(fn ($row) => (int) ($row['id'] ?? 0))
            ->filter(fn ($id) => $id > 0)
            ->unique()
            ->values()
            ->all();

        $productsBySku = Product::whereIn('sku_code', $skuCodes)
            ->get()
            ->keyBy('sku_code');

        $existingById = $ids
            ? ProductImage::whereIn('id', $ids)->get()->keyBy('id')
            : collect();

        $existingImages = ProductImage::whereIn('sku_code', $skuCodes)
            ->get()
            ->groupBy('sku_code');

        foreach ($rows as $row) {
            $rowId = (int) ($row['id'] ?? 0);
            $skuCode = trim((string) ($row['sku_code'] ?? ''));
            $image = trim((string) ($row['image'] ?? ''));

            if ($skuCode === '' || $image === '') {
                $this->skipped++;
                continue;
            }

            $product = $productsBySku->get($skuCode);
            if (empty($product)) {
                $this->skipped++;
                continue;
            }

            $normalizedImage = $this->normalizeImageUrl($image);
            $mainImage = $this->normalizeImageUrl($product->image ?? '');

            // Main product image is already shown on the product page — do not add/update it into gallery.
            if ($normalizedImage !== '' && $normalizedImage === $mainImage) {
                $this->skipped++;
                continue;
            }

            // Update Template rows include id — update that gallery image in place.
            if ($rowId > 0) {
                $existing = $existingById->get($rowId);
                if (!$existing) {
                    $this->skipped++;
                    continue;
                }

                $skuExisting = $existingImages->get($skuCode, collect());
                $duplicateOther = $skuExisting->contains(
                    fn ($rowImage) => (int) $rowImage->id !== $rowId
                        && $this->normalizeImageUrl($rowImage->image) === $normalizedImage
                );
                if ($duplicateOther) {
                    $this->skipped++;
                    continue;
                }

                $existing->fill([
                    'image' => $image,
                    'sku_code' => $skuCode,
                    'product_id' => $product->id,
                ]);

                if ($existing->isDirty()) {
                    $existing->save();
                    $this->updated++;

                    // Keep in-memory index in sync for later rows in this chunk
                    $existingById->put($rowId, $existing);
                    $existingImages->put(
                        $skuCode,
                        $skuExisting->map(fn ($rowImage) => (int) $rowImage->id === $rowId ? $existing : $rowImage)
                    );
                } else {
                    $this->skipped++;
                }

                continue;
            }

            // Add New Template (no id) — insert only if this image is not already in the gallery.
            $skuExisting = $existingImages->get($skuCode, collect());
            $alreadyExists = $skuExisting->contains(
                fn ($existing) => $this->normalizeImageUrl($existing->image) === $normalizedImage
            );
            if ($alreadyExists) {
                $this->skipped++;
                continue;
            }

            $created = ProductImage::create([
                'image' => $image,
                'sku_code' => $skuCode,
                'product_id' => $product->id,
                'created_by' => optional(auth()->user())->name ?? 'system',
            ]);

            $this->created++;
            $existingImages->put(
                $skuCode,
                $skuExisting->push($created)
            );
        }
    }

    public function summaryMessage(): string
    {
        return sprintf(
            'Import finished: %d updated, %d created, %d skipped.',
            $this->updated,
            $this->created,
            $this->skipped
        );
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
