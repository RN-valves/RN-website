<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function content(){
        return $this->belongsTo(Content::class, 'content_id');
    }

    public function subcategory(){
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function productAttribute(){
        return $this->hasOne(ProductAttribute::class, 'product_id');
    }

    public static function colorGroups($colorGroupId,$productId){
        return Product::where('color_group_id','=',$colorGroupId)
            ->where('products.status', '=', 'Active')
            ->where('products.is_visible_website', '=', 1)
            ->whereNot('id',$productId)
            ->whereNull('deleted_at')
            ->get();
    }
    public static function packagingGroups($packagingGroupId,$productId){
        return Product::where('packaging_group_id','=',$packagingGroupId)
            ->where('products.status', '=', 'Active')
            ->where('products.is_visible_website', '=', 1)
            ->whereNot('id',$productId)
            ->whereNot('packaging_name','')
            ->whereNull('deleted_at')
            ->get();
    }

    public static function comboGroups($comboGroupId,$productId){
        return Product::where('product_combo_id','=',$comboGroupId)
            ->where('products.status', '=', 'Active')
            ->where('products.is_visible_website', '=', 1)
            ->whereNot('id',$productId)
            ->whereNull('deleted_at')
            ->get();
    }

    public static function sizeGroups($sizeGroupId,$productId){
        return Product::where('product_size_id','=',$sizeGroupId)
            ->where('products.status', '=', 'Active')
            ->where('products.is_visible_website', '=', 1)
            ->whereNull('deleted_at')
            ->get();
    }

    public function productImages(){
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function getRouteKeyName(){
        return 'url_key';
    }

    static public function getProducts($subcategory_id = '', $color = '', $size = '', $brand_id = ''){
        $productsList = Product::select('products.*', 'subcategories.name as subcategory_name')
            ->join('subcategories','subcategories.id', 'products.subcategory_id');

        if(!empty($subcategory_id)){
            $productsList = $productsList->where('products.subcategory_id', '=', $subcategory_id);
        }
        if(!empty($color)){
            $productsList = $productsList->where('products.color_name', '=', $color);
        }
        if(!empty($size)){
            $productsList = $productsList->where('products.size', '=', $size);
        }

        if(!empty(request('size_id'))){
            $size_id = rtrim(request('size_id'), ',');
            $size_id_array = explode(',', $size_id);
            $productsList = $productsList->whereIn('size', $size_id_array);
        }

        if(!empty(request('color_id'))){
            $color_id = rtrim(request('color_id'), ',');
            $color_id_array = explode(',', $color_id);
            $productsList = $productsList->whereIn('color_name', $color_id_array);
        }
        if(!empty(request('bullet_id'))){
            $bullet_id = rtrim(request('bullet_id'), '@@@');
            $bullet_id_array = explode('@@@', $bullet_id);
            $productsList = $productsList->whereIn('products.name', $bullet_id_array);
        }

        if(!empty(request('brand_id'))){
            $brand_id = rtrim(request('brand_id'), ',');
            $brand_id_array = explode(',', $brand_id);
            $productsList = $productsList->whereIn('brand_id', $brand_id_array);
        }

        if(!empty(request('subcategory_id'))){
            $subcategory_id = rtrim(request('subcategory_id'), ',');
            $subcategory_id_array = explode(',', $subcategory_id);
            $productsList = $productsList->whereIn('subcategory_id', $subcategory_id_array);
        }

        if(!empty(request('sort_by_id'))){
            if(request('sort_by_id')=="product_new"){
                $productsList = $productsList->where('new_arrival', 1);
            }elseif(request('sort_by_id')=="price_lowest"){
                $productsList = $productsList->orderBy('in_mrp', 'asc');
            }elseif(request('sort_by_id')=="price_highest"){
                $productsList = $productsList->orderBy('in_mrp', 'desc');
            }else{
                $productsList = $productsList;
            }
        }

        if(!empty(request('q'))){
            $productsList = $productsList->where(function ($query) {
                $query->where('products.article', request('q'))
                      ->orWhere('products.name', 'like', '%' . request('q') . '%')
                      ->orWhere('products.sku_code', request('q'))
                      ->orWhere('products.full_turn_code', request('q'));
            })->where('products.status', 'Active');
        }
        if(!empty(request('product_name')) && empty(request('bullet_id'))){
            $productsList = $productsList->where(function ($query) {
                $query->where('products.name', request('product_name'));
            })->where('products.status', 'Active');
        }

        return $productsList->where('products.status', '=', 'Active')
            ->where('products.is_visible_website', '=', 1)
            ->groupBy('products.id')
            ->orderBy('name', 'asc')
            ->whereNull('products.deleted_at')
            ->paginate(21);
    }

    public static function getSingleProduct($url_key){
        return self::where('url_key','=',$url_key)
            ->with('bullets')
            ->where('products.status', '=', 'Active')
            ->where('products.is_visible_website', '=', 1)
            ->whereNull('deleted_at')
            ->first();
    }

    public static function getSingleProId($product_id){
        return self::where('id','=',$product_id)
            ->where('products.status', '=', 'Active')
            ->where('products.is_visible_website', '=', 1)
            ->whereNull('deleted_at')
            ->first();
    }

    public static function getSimilarProducts($product_id, $subcategoryId){
        return Product::select('products.*')
            ->where('products.id', '!=', $product_id)
            ->where('products.subcategory_id', '=', $subcategoryId)
            ->where('products.status', '=', 'Active')
            ->where('products.is_visible_website', '=', 1)
            ->whereNull('products.deleted_at')
            ->inRandomOrder()
            ->limit(12)->get();
    }

    public static function getSimilarSubcategories($categoryId, $subcategoryId){
        return Subcategory::where(['status'=>'Active','is_visible_website'=>1,'category_id'=>$categoryId])->orderBy('name','asc')->get();
    }

    public static function getSubcategoryColors($subcategoryId){
        return Product::where(['subcategory_id'=>$subcategoryId,'status'=>'Active','is_visible_website'=>1])->select('color_name')->orderBy('color_name','asc')->groupBy('color_name')->get();
    }

    public static function getSubcategorySizes($subcategoryId){
        return Product::where(['subcategory_id'=>$subcategoryId,'status'=>'Active','is_visible_website'=>1])->select('size')->groupBy('size')->get();
    }

    public static function getSubcategoryColorProducts($subcategory_id, $color_name){
        return self::select('products.*')
            ->where('products.color_name', '=', $color_name)
            ->where('products.subcategory_id', '=', $subcategory_id)
            ->where('products.status', '=', 'Active')
            ->where('products.is_visible_website', '=', 1)
            ->whereNull('deleted_at')
            ->get();
    }

    public static function getSubcategorySizeProducts($subcategory_id, $size){
        return self::select('products.*')
            ->where('products.size', '=', $size)
            ->where('products.subcategory_id', '=', $subcategory_id)
            ->where('products.status', '=', 'Active')
            ->where('products.is_visible_website', '=', 1)
            ->whereNull('deleted_at')
            ->get();
    }

    public static function getSubcategoryProducts($subcategory_id){
        return self::select('products.*')
            ->where('products.subcategory_id', '=', $subcategory_id)
            ->where('products.status', '=', 'Active')
            ->where('products.is_visible_website', '=', 1)
            ->whereNull('deleted_at')
            ->get();
    }

    public function bullets(){
        return $this->belongsToMany(ProductBullet::class, 'product_bullet_product', 'product_id', 'product_bullet_id');
    }
}
