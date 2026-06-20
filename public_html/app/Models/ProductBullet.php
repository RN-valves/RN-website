<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBullet extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function bullets(){
        return $this->belongsToMany(Product::class, 'product_bullet_product', 'product_id', 'product_bullet_id');
    }
}
