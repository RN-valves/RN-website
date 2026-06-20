<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLog extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }

    public static function orderLogStatuses($order_id){
        return self::where('order_id',$order_id)->groupBy('change_value')->orderBy('id','asc')->pluck('change_value');
    }

    public static function getOrderLogStatus($order_id, $status){
        return self::where(['order_id' => $order_id, 'change_value'=>$status])->first();
    }
}
