<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'news';
    protected $fillable = ['auth_id','created_by','name','url_key','title','keywords','description','short_description','content','image','status','published_at'];

    public function auth(){
        return $this->belongsTo(User::class, 'auth_id');
    }

    public static function getNewsList($blog_id=''){
        $getBlogList = News::query();
        if(!empty($blog_id)){
            $getBlogList = $getBlogList->where('id', $blog_id);
        }

        return $getBlogList = $getBlogList->where('status', '=', 'Active')
            ->orderByDesc('id')
            ->get();
    }

    public static function getSingleNewsUrl($url_key){
        return self::where('url_key','=',$url_key)
            ->where('news.status', '=', 'Active')
            ->first();
    }

    public static function getSingleNews($blog_id){
        return self::where('id','=',$blog_id)
            ->where('news.status', '=', 'Active')
            ->first();
    }

    protected $casts = [
        'published_at' => 'immutable_datetime',
    ];

    public function getRouteKeyName(){
        return 'url_key';
    }
}
