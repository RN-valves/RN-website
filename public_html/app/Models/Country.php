<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function states(){
        return $this->hasMany(State::class, 'country_id');
    }
    public function cities(){
        return $this->hasMany(City::class, 'country_id');
    }
    public function pincodes(){
        return $this->hasMany(Pincode::class, 'country_id');
    }
}
