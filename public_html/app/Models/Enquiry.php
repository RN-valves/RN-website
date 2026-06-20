<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'published_at' => 'immutable_datetime',
    ];

    public function pincode(){
        return $this->belongsTo(Pincode::class,'pincode_id');
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
    public function salesmen(){
        return $this->belongsTo(User::class, 'salesmen_id');
    }
    public function getRouteKeyName(){
        return 'uuid';
    }
    public function logables(){
        return $this->morphMany(RemarkLog::class, 'logable');
    }
    public static function enquiryTypes(){
        return array('Distributor','Retailer','Dealer', 'Architect', 'Interier Designer', 'Consultant', 'Contractor', 'Plumber', 'Consumer', 'Other');
    }
}
