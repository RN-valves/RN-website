<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function country(){
        return $this->belongsTo(Country::class,'country_id');
    }
    public function cities(){
        return $this->hasMany(City::class, 'state_id');
    }
    public function pincodes(){
        return $this->hasMany(Pincode::class, 'state_id');
    }
}
