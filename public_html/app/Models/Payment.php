<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }

    public static function getSinglePaymentPayId($payment_id){
        return self::where('payment_id', $payment_id)->first();
    }

    public static function getPaymentUrl($pay_link_id){
        return self::where('pay_link_id', $pay_link_id)->first();
    }
}
