<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function products(){
        return $this->hasMany(Product::class, 'subcategory_id');
    }

    public function content(){
        return $this->belongsTo(Content::class, 'content_id');
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public static function getSubcategories($category_id){
        return self::where('category_id','=',$category_id)
            ->where('subcategories.status', '=', 'Active')
            ->where('subcategories.is_visible_website', '=', 1)
            ->get();
    }

    public static function getSingleSubCategory($url_key){
        return self::where('url_key','=',$url_key)
            ->where('subcategories.status', '=', 'Active')
            ->where('subcategories.is_visible_website', '=', 1)
            ->first();
    }

    public static function getSubCategoryProducts($subcategory_id){
        return Product::select('products.*')
            ->where('products.subcategory_id', '=', $subcategory_id)
            ->where('products.status', '=', 'Active')
            ->where('products.is_visible_website', '=', 1)
            ->whereNull('deleted_at')
            ->orderByDesc('id')
            ->get();
    }

    public function getRouteKeyName(){
        return 'url_key';
    }

    public static function getActiveBulletPoints(){
        return BPoint::where('model_type','=','Subcategory')
            ->where('b_points.model_id','=',$this->id)
            ->where('b_points.status','=','Active')
            ->first();
    }

    public function bullet_points(){
        return $this->morphMany(BPoint::class, 'model');
    }
}
