<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function auth(){
        return $this->belongsTo(User::class, 'auth_id');
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public static function getBlogList($category_id='', $blog_id=''){
        $getBlogList = Blog::select('blogs.*', 'categories.name as category_name')
            ->join('categories','categories.id', 'blogs.category_id');

        if(!empty($category_id)){
            $getBlogList = $getBlogList->where('blogs.category_id', $category_id);
        }

        if(!empty($blog_id)){
            $getBlogList = $getBlogList->where('blogs.id', $blog_id);
        }

        return $getBlogList = $getBlogList->where('blogs.status', '=', 'Active')
            ->orderByDesc('id')
            ->get();
    }

    public static function getSingleBlogUrl($url_key){
        return self::where('url_key','=',$url_key)
            ->where('blogs.status', '=', 'Active')
            ->first();
    }

    public static function getSingleBlog($blog_id){
        return self::where('id','=',$blog_id)
            ->where('blogs.status', '=', 'Active')
            ->first();
    }

    public function blog_logs(){
        return $this->hasMany(BlogLog::class, 'blog_id');
    }

    protected $casts = [
        'published_at' => 'immutable_datetime',
    ];

    public function getRouteKeyName(){
        return 'url_key';
    }
}
