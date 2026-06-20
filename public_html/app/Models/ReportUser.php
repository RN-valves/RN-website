<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportUser extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function users(){
        return $this->hasMany(User::class,'user_id');
    }

    public function reporting_user(){
        return $this->belongsTo(User::class, 'reporting_id');
    }
}
