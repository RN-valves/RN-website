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
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Illuminate\Validation\Rule;

use App\Models\{
    Product,
    Color,
    Size,
    ProductAttribute,
    Subcategory
};
use App\Traits\DefaultTrait;

class ProductImport implements 
    ToCollection,
    // WithValidation,
    WithHeadingRow,
    WithChunkReading,
    WithBatchInserts,
    SkipsOnError
{
use DefaultTrait;
use Importable, SkipsErrors,SkipsFailures;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    
    public function collection(Collection $rows)
    {
       //dd($rows);
        foreach ($rows as $row) {
            $subcategory = Subcategory::where(['name'=>$row['subcategory']])->first();
          if($subcategory){
            $product = Product::where(['sku_code'=>$row['sku_code']])->first();
            $color = Color::where(['name'=>$row['color_name']])->first();
            $isNew = empty($product);
            if($isNew){
                $uuid = str()->uuid()->toString();
            }else{
                $uuid = $product->uuid;
            }

            $productData = [
                    'sku_code' => $row['sku_code'],
                    'in_mrp' => isset($row['in_mrp']) ? round((float)$row['in_mrp'], 2) : 0.0,
                    'in_selling' => isset($row['in_selling']) ? round((float)$row['in_selling'], 2) : 0.0,
                    'in_v1_mrp' => isset($row['in_v1_mrp']) ? round((float)$row['in_v1_mrp'], 2) : 0.0,
                    'oth_mrp' => isset($row['oth_mrp']) ? round((float)$row['oth_mrp'], 2) : 0.0,
                    'oth_selling' => isset($row['oth_selling']) ? round((float)$row['oth_selling'], 2) : 0.0,
                    'oth_v1_mrp' => isset($row['oth_v1_mrp']) ? round((float)$row['oth_v1_mrp'], 2) : 0.0,
                    'color_group_id' => $row['color_group_id']??str()->uuid()->toString(),
                    'packaging_group_id' => $row['packaging_group_id']??str()->uuid()->toString(),
                    'product_combo_id' => $row['product_combo_id']??str()->uuid()->toString(),
                    'product_size_id' => $row['product_size_id']??str()->uuid()->toString(),
                    'uuid' => $uuid,
                    'url_key' => '',
                    'category_id' => $subcategory->category_id,
                    'subcategory_id' => $subcategory['id'],
                    'brand' => $row['brand'],
                    'content_id' => $row['content_id'],
                    'material' => $row['material'],
                    'color_name' => $color->name ?? $row['color_name'],
                    'packaging_name' => $row['packaging_name']??str()->uuid()->toString() ,
                    'color_icon' => $color->icon ?? null,
                    'name' => $row['name'],
                    'article' => $row['article'],
                    'size' => $row['size'],
                    'hsn' => $row['hsn'],
                    'image' => $row['image'],
                    'title' => $row['title'],
                    'keywords' => $row['keywords'],
                    'description' => $row['description'],
                    'search_keywords' => $row['search_keywords'],
                    'is_full_turn' => (int)($row['is_full_turn'] ?? 0),
                    'full_turn_code' => $row['full_turn_code'] ?? '0',
                    'sale_type' => $row['sale_type'] ?? 'BASS',
            ];

            // Preserve admin visibility/status on Excel re-import unless column is explicitly set
            $productData['is_visible_website'] = (isset($row['is_visible_website']) && $row['is_visible_website'] !== '')
                ? (int) $row['is_visible_website']
                : ($isNew ? 0 : (int) $product->is_visible_website);
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

            $product = Product::updateOrCreate(
                [
                    'sku_code' => $row['sku_code'],
                ],
                $productData,
            );

            $this->updateProductUrl($product->id);
            ProductAttribute::updateOrCreate(
                [
                    'product_id' => $product->id,
                ],
                [
                    'product_id' => $product->id,
                    'sku_code' => $row['sku_code'],
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
                    'amazon_link' => $row['amazon_link']??null,
                    'flipkart_link' => $row['flipkart_link']??null,
                    'short_description' => $row['short_description']??null,
                    'video_url' => $row['video_url']??null,
                ],
            );
            
            //$this->productStockStatus($product->id);
          }
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 1000;
    }

    // public function rules(): array
    // {
    //     return [
    //         'subcategory' => ['required','exists:subcategories,name'],
    //         'content_id' => ['required','exists:contents,id'],
    //         'brand' => ['required','exists:brands,name'],
    //         'material' => ['required','exists:materials,name'],
    //         'color_name' => ['required','exists:colors,name'],
    //         'name' => ['required','string','max:155'],
    //         'article' => ['required','max:15'],
    //         'sku_code' => ['required','max:15'],
    //         'size' => ['required','exists:sizes,name'],
    //         'hsn' => ['required','max:25'],
    //         'image' => ['required','string'],
    //         'title' => ['required','string','max:100'],
    //         'keywords' => ['required','string','max:155'],
    //         'description' => ['required','string','max:155'],
    //         'search_keywords' => ['required','string','max:255'],
    //         'is_visible_website' => ['required','in:0,1'],
    //         'is_visible_api' => ['required','in:0,1'],
    //         'new_arrival' => ['required','in:0,1'],
    //         'is_featured' => ['required','in:0,1'],
    //         'sale_type' => ['required','string','max:25'],
    //         'in_mrp' => ['required','numeric'],
    //         'in_selling' => ['required','numeric'],
    //         'in_v1_mrp' => ['required','numeric'],
    //         'oth_mrp' => ['required','numeric'],
    //         'oth_selling' => ['required','numeric'],
    //         'oth_v1_mrp' => ['required','numeric'],
    //         'status' => ['required',Rule::in(['Active','InActive','Out-of-Stock'])],

    //         'color_group_id' => ['nullable'],
    //         'product_combo_id' => ['nullable'],
    //         'product_size_id' => ['nullable'],

    //         //product attributes validations
    //         'ctn_pcs' => ['required','numeric'],
    //         'mid_ctn_pcs' => ['required','numeric'],
    //         'inner_pcs' => ['required','numeric'],
    //         'stock_pcs' => ['required','numeric'],
    //         'only_product_wt_gm' => ['required','numeric'],
    //         'product_length' => ['required','numeric'],
    //         'product_breadth' => ['required','numeric'],
    //         'product_height' => ['required','numeric'],
    //         'product_lbh_weight_gm' => ['required','numeric'],
    //         'mid_ctn_lbh_weight_kg' => ['required','numeric'],
    //         'master_ctn_lbh_weight_kg' => ['required','numeric'],
    //         'residential_warranty' => ['required','numeric'],
    //         'commercial_warranty' => ['required','numeric'],
    //         'amazon_link' => ['nullable','string','max:255'],
    //         'flipkart_link' => ['nullable','string','max:255'],
    //         'short_description' => ['nullable','string','max:255'],
    //         'video_url' => ['nullable','string','max:255'],


    //         // Above is alias for as it always validates in batches
    //         '*.subcategory' => ['required','exists:subcategories,name'],
    //         '*.content_id' => ['required','exists:contents,id'],
    //         '*.brand' => ['required','exists:brands,name'],
    //         '*.material' => ['required','exists:materials,name'],
    //         '*.color_name' => ['required','exists:colors,name'],
    //         '*.name' => ['required','string','max:155'],
    //         '*.article' => ['required','max:15'],
    //         '*.sku_code' => ['required','max:15'],
    //         '*.size' => ['required','exists:sizes,name'],
    //         '*.hsn' => ['required','max:25'],
    //         '*.image' => ['required','string'],
    //         '*.title' => ['required','string','max:100'],
    //         '*.keywords' => ['required','string','max:155'],
    //         '*.description' => ['required','string','max:155'],
    //         '*.search_keywords' => ['required','string','max:255'],
    //         '*.is_visible_website' => ['required','in:0,1'],
    //         '*.is_visible_api' => ['required','in:0,1'],
    //         '*.new_arrival' => ['required','in:0,1'],
    //         '*.is_featured' => ['required','in:0,1'],
    //         '*.sale_type' => ['required','string','max:25'],
    //         '*.in_mrp' => ['required','numeric'],
    //         '*.in_selling' => ['required','numeric'],
    //         '*.in_v1_mrp' => ['required','numeric'],
    //         '*.oth_mrp' => ['required','numeric'],
    //         '*.oth_selling' => ['required','numeric'],
    //         '*.oth_v1_mrp' => ['required','numeric'],
    //         '*.status' => ['required',Rule::in(['Active','InActive','Out-of-Stock'])],

    //         '*.color_group_id' => ['nullable'],
    //         '*.product_combo_id' => ['nullable'],
    //         '*.product_size_id' => ['nullable'],

    //         //product attributes validations
    //         '*.ctn_pcs' => ['required','numeric'],
    //         '*.mid_ctn_pcs' => ['required','numeric'],
    //         '*.inner_pcs' => ['required','numeric'],
    //         '*.stock_pcs' => ['required','numeric'],
    //         '*.only_product_wt_gm' => ['required','numeric'],
    //         '*.product_length' => ['required','numeric'],
    //         '*.product_breadth' => ['required','numeric'],
    //         '*.product_height' => ['required','numeric'],
    //         '*.product_lbh_weight_gm' => ['required','numeric'],
    //         '*.mid_ctn_lbh_weight_kg' => ['required','numeric'],
    //         '*.master_ctn_lbh_weight_kg' => ['required','numeric'],
    //         '*.residential_warranty' => ['required','numeric'],
    //         '*.commercial_warranty' => ['required','numeric'],
    //         '*.amazon_link' => ['nullable','string','max:255'],
    //         '*.flipkart_link' => ['nullable','string','max:255'],
    //         '*.short_description' => ['nullable','string','max:255'],
    //         '*.video_url' => ['nullable','string','max:255'],
    //     ];
    // }
}
