<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTransport extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }

    public static function getTransportAttachment($order_transport_id){
        return self::where('id',$order_transport_id)->value('attachment');
    }

    public static function checkOrderTransport($orderId){
        return self::where('order_id',$orderId)->first();
    }
}
