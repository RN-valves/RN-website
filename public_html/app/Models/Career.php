<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function creator(){
        return $this->hasMany(User::class, 'created_id');
    }

    public static function getCareers(){
        return self::where('status','=','Active')
            ->whereDate('careers.published_at','<=',now())
            ->orderByDesc('id')->get();
    }

    public static function getSingleCareer($uuid){
        return self::whereUuid($uuid)->first();
    }

    protected $casts = [
        'published_at' => 'immutable_datetime',
    ];

    public function getRouteKeyName(){
        return "uuid";
    }
}
