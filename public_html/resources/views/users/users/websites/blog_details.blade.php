@extends('users.master')
@section('seo_tags')
<title>{{$getSingleBlogUrl['title']}}</title>
<meta name="description" content="{{$getSingleBlogUrl['description']}}">
<meta name="keywords" content="{{$getSingleBlogUrl['keywords']}}">
<meta property="og:title" content="{{$getSingleBlogUrl['title']}}">
<meta property="og:image" content="{{url($getSingleBlogUrl['image'])}}">
<meta name="og:description" content="{{$getSingleBlogUrl['description']}}">
<meta property=og:image:url content="{{url($getSingleBlogUrl['image'])}}">

<meta property=twitter:title content="{{$getSingleBlogUrl['title']}}">
<meta property=twitter:description content="{{$getSingleBlogUrl['description']}}">
<meta property=twitter:image content="{{url($getSingleBlogUrl['image'])}}">
@endsection
@section('ccs_links')
<link rel="stylesheet" href="{{ url('users/assets/css/custom.css') }}" type="text/css">
@endsection
@section('content')
<?php $url= url()->full(); ?>
<!--Page-->
<div class="cstm_page_section" style="background:#ffffff;">
   <div class="blog-page-content">
      <div class="container-fluid">
         <div class="brdcrm_menu" style="margin-top: 5px !important;"><a href="{{route('blogs', ['url_key'=>'blogs'])}}"><i class="fas fa-chevron-left"></i>Back to Blog List</a></div>
         <div class="row">
            <div class="col-lg-8">
               <div class="blog-details-wrap" style="padding-bottom: 30px;">
                  <!--Blog Details item-->
                  <div class="blog-details-items">
                     <!-- <div class="thumb">
                        <img src="" alt="img">
                        </div> -->
                     <!--// Thumbnail Area-->
                     <div class="blog_content_areaaa">
                        <h1 class="title" style="font-size:30px">{{$getSingleBlogUrl['title']}}</h1>
                        <p>{!! $getSingleBlogUrl['content'] !!}</p>
                     </div>
                  </div>
                  <!--// Blog Details item-->
               </div>
            </div>
            <div class="col-lg-4">
               <div class="blog_right_side">
                  <div class="widget-area">
                     <div class="widget widget_nav_menu radio-button">
                        <h5 class="widget-title">Blog Categories</h5>
                        <ul>
                           @if($categories->count()>0)
                           @foreach($categories as $blogCat)
                           @php
                           $countAccountBlogs = App\Models\Blog::where(['category_id' => $blogCat->id, 'status'=>'Active'])->count();
                           @endphp
                           <li><a href="{{route('blogs',$blogCat)}}">{{$blogCat['name']}} <span> ({{$countAccountBlogs}})</span></a></li>
                           @endforeach
                           @endif
                        </ul>
                     </div>
                     <!--// Category Widget-->
                     <div class="widget widget_recent_posts style-01">
                        <h5 class="widget-title">Recent Post</h5>
                        <ul class="recent_post_item">
                           @if($getBlogList->count()>0)
                           @foreach($getBlogList->sortByDesc('id')->take(3) as $blog)
                           <li class="single-recent-post-item">
                              <div class="thumb">
                                 <img src="{{url($blog['image'])}}" alt="{{$blog['title']}}" title="{{$blog['title']}}">
                              </div>
                              <div class="content">
                                 <h5 class="title"><a href="{{route('blogs', $blog->url_key)}}">{{substr($blog['name'], 0,40)}}...</a></h5>
                                 <span class="time">{{$blog['published_at']->format('d M Y')}}</span>
                              </div>
                           </li>
                           @endforeach
                           @endif
                        </ul>
                     </div>
                     <!--// Recent Post Widget-->
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--// Container-->
   </div>
   <!--// Blog Page Content-->
</div>
<!--//  Page-->
@endsection