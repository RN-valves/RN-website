<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'about_us';
    protected $fillable = ['name','vision','mission','values','milestone','youtube_link','desc1','desc2','desc3','catalogue'];
}
