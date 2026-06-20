<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cart;

class ShippingCharge extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function getShippingCharge(){
        $total_weight = Cart::weight(2, '.', '');
        if($total_weight<=0){
            $totalAmount = 0;
        }elseif($total_weight>0 && $total_weight<=100){
            $totalAmount = self::value('w_0_100gm');
        }elseif($total_weight>101 && $total_weight<=200){
            $totalAmount = self::value('w_101_200gm');
        }elseif($total_weight>201 && $total_weight<=400){
            $totalAmount = self::value('w_201_400gm');
        }elseif($total_weight>401 && $total_weight<=600){
            $totalAmount = self::value('w_401_600gm');
        }elseif($total_weight>601 && $total_weight<=1000){
            $totalAmount = self::value('w_601_1000gm');
        }elseif($total_weight>1001 && $total_weight<=1500){
            $totalAmount = self::value('w_1001_1500gm');
        }elseif($total_weight>1501 && $total_weight<=2000){
            $totalAmount = self::value('w_1501_2000gm');
        }elseif($total_weight>2001 && $total_weight<=2500){
            $totalAmount = self::value('w_2001_2500gm');
        }elseif($total_weight>2501 && $total_weight<=3000){
            $totalAmount = self::value('w_2501_3000gm');
        }elseif($total_weight>3001 && $total_weight<=4000){
            $totalAmount = self::value('w_3001_4000gm');
        }elseif($total_weight>4001 && $total_weight<=5000){
            $totalAmount = self::value('w_4001_5000gm');
        }elseif($total_weight>5001 && $total_weight<=10000){
            $totalAmount = self::value('w_5001_10000gm');
        }elseif($total_weight>10001 && $total_weight<=20000){
            $totalAmount = self::value('w_10001_20000gm');
        }elseif($total_weight>20001 && $total_weight<=40000){
            $totalAmount = self::value('w_20001_40000gm');
        }else{
            $totalAmount = 0;
        }
        return $totalAmount;
    }
}
