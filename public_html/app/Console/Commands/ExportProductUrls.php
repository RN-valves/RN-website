<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\ProductImage;
use App\Models\ProductBullet;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use DB;

class ExportProductUrls extends Command
{
    protected $signature = 'export:product-urls';
    protected $description = 'Export product URLs to a CSV file';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $products = Product::get();
        $productImgs = ProductImage::get();
 
        $categories = Subcategory::where('is_visible_website',1)->whereNotNull('pdf_catalogue')->get();

        $csvData = [];
        foreach ($products as $product) 
        { 
        //     // $response = Http::timeout(10)->head($product->image);
        //     // if ($response->status() !== 200) {
        //     //     $product->image = 'https://rnvalves.media/Catalogue/RNPTMT/dummy-product.png';
        //     //     $product->save();
        //     // }           
            // $proImg = ProductImage::where('sku_code', $product->sku_code)->exists();
            // if($proImg){  
            //     ProductImage::where('sku_code', $product->sku_code)->delete();
                // if($product->category_id >= 11){
                // $url = route('productList.view', [$product->category->url_key, $product->subcategory->url_key, $product]);
                // $csvData[] = [$product->sku_code,$product->color_name,$product->category->name,$product->subcategory->name , $product->name, $url, $product->image,$product->in_mrp,$product->in_v1_mrp,$product->productAttribute->stock_pcs,$product->title,$product->description];    
                // $product->productAttribute->stock_pcs = 1000;
                // $product->productAttribute->save();
                
            // }
            $product->in_v1_mrp = (int)$product->in_mrp*2;
            $product->save();
            // }

        }
        // foreach ($productImgs as $productImg) {
        //     $url = $productImg->image;
            
        //     $csvData[] = [$productImg->product->subcategory->name ?? '',$productImg->product->name ?? '', $productImg->sku_code ?? '', $url ?? ''];
        // }
        // foreach($categories as $cate){
        //     if (!filter_var($cate->pdf_catalogue, FILTER_VALIDATE_URL)) {
         
        //         $csvData[] = [$cate->id, $cate->name, $cate->pdf_catalogue];
        //         continue;
        //     }
        //     $response = Http::timeout(10)->head($cate->pdf_catalogue);
        //         if ($response->status() !== 200) {
        //             $csvData[] = [$cate->id, $cate->name, $cate->pdf_catalogue];
        //         } 
            
        // }
        // foreach ($products as $product){
        //     $csvData[] = [$product->subcategory->name??"",$product->name??'', $product->sku_code??'', $product->image??''];
        // }

        // $csvData = array_merge([['subcategory','product_name', 'sku_code', 'image']], $csvData);
        // $csvData = array_merge([['sku_code','color_name','category','subcategory', 'Name', 'product_url','image','b2b_price','mrp','stock_pcs','title','description']], $csvData);

        // $fileName = now()->format('Y-m-dhis').'productImages.csv';
        // $fileName = now()->format('Y-m-dhis').'product_urls.csv';
        // $filePath = storage_path('app/' . $fileName);

        // $file = fopen($filePath, 'w');
        // foreach ($csvData as $line) {
        //     fputcsv($file, $line);
        // }
        // fclose($file);

        // $this->info('Product URLs have been exported to: ' . $filePath);
        // $this->info('Product Updated');
        $this->info('successfully');
    }
}
