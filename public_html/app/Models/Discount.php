<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function getSingle($id){
        return self::find($id);
    }

    public static function getRecord(){
        return self::select('discounts.*')
            ->where('discounts.deleted_at', '=', 0)
            ->orderBy('discounts.id', 'desc')
            ->get();
    }

    public static function checkDiscount($discount_code){
        return self::select('discounts.*')
            ->where('discounts.start_value', '<', \Cart::priceTotal(2, '.', ''))
            ->where('discounts.end_value', '>', \Cart::priceTotal(2, '.', ''))
            ->where('discounts.name', '=', $discount_code)
            ->where('discounts.status', '=', 'Active')
            ->whereNull('discounts.deleted_at')
            ->whereDate('discounts.expired_at', '>=', now())
            ->first();
    }
    
    public static function getActiveDiscountList(){
        return self::where('discounts.status', '=', 'Active')
            ->whereNull('discounts.deleted_at')
            // ->whereDate('discounts.expired_at', '>=', now())
            ->get();
    }

    public static function getActiveSlabDiscountCode(){
        return self::where('discounts.start_value', '<', \Cart::priceTotal(2, '.', ''))
            ->where('discounts.end_value', '>', \Cart::priceTotal(2, '.', ''))
            ->where('discounts.status', '=', 'Active')
            ->whereDate('discounts.expired_at', '>=', now())
            ->whereNull('discounts.deleted_at')
            ->first();
    }

    protected $casts = [
        'expired_at' => 'immutable_datetime',
    ];
}
