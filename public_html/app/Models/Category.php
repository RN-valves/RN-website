<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function products(){
        return $this->hasMany(Product::class, 'category_id');
    }

    public function content(){
        return $this->belongsTo(Content::class, 'content_id');
    }

    public function subcategories(){
        return $this->hasMany(Subcategory::class, 'category_id');
    }

    /*// Each category may have one parent
    public function parent() {
        return $this->belongsTo(self::class, 'parent_id');
    }

    // Each category may have multiple children
    public function children() {
        return $this->hasMany(self::class, 'parent_id');
    }*/

    public static function getSingleCategory($url_key){
        return self::where('url_key','=',$url_key)
            ->where('categories.status', '=', 'Active')
            ->where('categories.is_visible_website', '=', 1)
            ->first();
    }

    public static function getCatSubcategories($category_id){
        return Subcategory::where('category_id','=',$category_id)
            ->where('subcategories.status', '=', 'Active')
            ->where('subcategories.is_visible_website', '=', 1)
            ->orderBy('created_at','desc')
            ->get();
    }

    public function getRouteKeyName(){
        return 'url_key';
    }

    public static function getActiveBulletPoints(){
        return BPoint::where('model_type','=','Category')
            ->where('b_points.model_id','=',$this->id)
            ->where('b_points.status','=','Active')
            ->first();
    }

    public function bullet_points(){
        return $this->morphMany(BPoint::class, 'model');
    }
}
