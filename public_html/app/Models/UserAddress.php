<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function city(){
        return $this->belongsTo(City::class,'city_id');
    }
    public function state(){
        return $this->belongsTo(State::class,'state_id');
    }
    public function country(){
        return $this->belongsTo(Country::class,'country_id');
    }

    public static function AddressTypes(){
        return array('Home','Office','Other');
    }
}
