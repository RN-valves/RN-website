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
    ProductBullet,
    Category,
    Product
};
use App\Traits\DefaultTrait;

class ProductBulletImport implements 
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
            if($row['product_bullet_id'] != ""){
                $productArr = explode(',', $row['product_bullet_id']);
                $product->bullets()->sync($productArr);
            }

            // $category = Category::where('name',$row['category'])->first();
            // $bullet = ProductBullet::where('name',$row['name'])->first();
            // if($bullet){
            //     $bullet->category_id = $category->id;
            //     $bullet->save();
            // } 
            // ProductBullet::updateOrCreate(
            //     [
            //         'name' => $row['name'],
            //     ],
            //     [
            //         'name' => $row['name'],
            //     ]
            // );

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
    //         'product_bullet_id' => ['required'],
    //         'sku_code' => ['required','exists:products,sku_code'],

    //         '*.product_bullet_id' => ['required'],
    //         '*.sku_code' => ['required','exists:products,sku_code'],
    //     ];
    // }
}
