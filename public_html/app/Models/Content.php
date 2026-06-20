<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function categories(){
        return $this->hasMany(Category::class, 'content_id');
    }

    public function products(){
        return $this->hasMany(Product::class, 'content_id');
    }

    public function getRouteKeyName(){
        return 'uuid';
    }
}
