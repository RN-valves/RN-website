<?php
namespace App\Imports;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;


use App\Models\{
    Product,
    Color,
    Size,
    Category,
    Faq,
    ProductAttribute,
    ProductImage,
    Subcategory
};
use App\Traits\DefaultTrait;

class ProductQuantityImport implements 
    ToCollection,
    WithHeadingRow,
    WithChunkReading,
    WithBatchInserts,
    SkipsOnError
{
use DefaultTrait;
use Importable, SkipsErrors;

    /**
    * @param Collection $rows
    */
    
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (empty($row['sku_code'])) {
                continue;
            }

            $product = Product::where('sku_code', $row['sku_code'])->first();
            
            if ($product) {
                // Update Price if 'price' column exists
                if (isset($row['price'])) {
                    $product->update([
                        'in_mrp'    => $row['price'],
                        'in_v1_mrp' => (int) $row['price'] * 2,
                    ]);
                }

                // Update Stock in ProductAttribute if 'stock_pcs' column exists
                if (isset($row['stock_pcs'])) {
                    ProductAttribute::updateOrCreate(
                        ['product_id' => $product->id],
                        ['stock_pcs'  => $row['stock_pcs']]
                    );
                }
            }
        }
    }

    public function chunkSize(): int
    {
        return 6500;
    }

    public function batchSize(): int
    {
        return 6500;
    }


}
