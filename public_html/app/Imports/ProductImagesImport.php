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
    ProductImage,
    Product
};
use App\Traits\DefaultTrait;

class ProductImagesImport implements 
    ToCollection,
    // WithValidation,
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
        foreach ($rows as $row) {
            $product = Product::where(['sku_code'=>$row['sku_code']])->first();
            if(!empty($product)){
                // $response = Http::get($row['image']);
                // if ($response->successful()) {
                    ProductImage::updateOrCreate(
                        [
                            'sku_code' => $row['sku_code'],
                            'image' => $row['image'],
                        ],
                        [
                            'image' => $row['image'],
                            'sku_code' => $row['sku_code'],
                            'product_id' => $product['id'],
                            'created_by' => auth()->user()->name,
                        ],
                    );
                // }
            }
        }
    }

    public function chunkSize(): int
    {
        return 10000;
    }

    public function batchSize(): int
    {
        return 10000;
    }

    // public function rules(): array
    // {
    //     return [
    //         'sku_code' => ['required','exists:products,sku_code'],
    //         'image' => ['required','max:255','string'],

    //         '*.sku_code' => ['required','exists:products,sku_code'],
    //         '*.image' => ['required','max:255','string'],
    //     ];
    // }
}
