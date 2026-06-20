<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogLog extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function blog(){
        return $this->belongsTo(Blog::class, 'blog_id');
    }

    public function auth(){
        return $this->belongsTo(User::class, 'auth_id');
    }
}
