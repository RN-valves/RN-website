@extends('users.master')
@section('seo_tags')
<title>Blogs | RN Valves & Faucets</title>
<meta name="description" content="Our full range of Bath Accessories, Bathroom Fitting, Faucets, Automatic Faucets, Valves, Sanitaryware, includes designs best suited for your home and building.">
<meta name="keywords" content="Bath Accessories, Bathroom Fitting, Faucets, Sensor Faucets, Valves, Showers, Health Faucets, Single Lever Mixer, Overhead Shower, Brass Ball Valves">
<meta property="og:title" content="Blogs | RN Valves & Faucets">
<meta property="og:image" content="{{asset('public/users/assets/images/about.jpg')}}">
<meta name="og:description" content="Our full range of Bath Accessories, Bathroom Fitting, Faucets, Automatic Faucets, Valves, Sanitaryware, includes designs best suited for your home and building.">
@endsection
@section('content')
@section('ccs_links')
<link rel="stylesheet" href="{{ url('users/assets/css/custom.css') }}" type="text/css">
@endsection
<?php $url= url()->full(); ?>
<!--Page-->
<div class="cstm_page_section website-cart addressbxx">
   <div class="container-fluid">
   <h1 class="text-center" style="
    font-size: 30px;
    font-weight: 600;
    margin-bottom: 40px;
">Blogs</h1>
<hr>
      <ul class="blog_category">
         @php
            $countAccountBlogs = App\Models\Blog::where(['status'=>'Active'])->count();
         @endphp
         <li><a class="{{$url==route('blogs', ['url_key'=>'blogs'])?'active':''}}" href="{{route('blogs', ['url_key'=>'blogs'])}}">All <span>({{ $countAccountBlogs }})</span></a></li>
         @if($categories->count()>0)
         @foreach($categories as $blogCat)
         @php
            $countAccountBlogs = App\Models\Blog::where(['category_id' => $blogCat->id, 'status'=>'Active'])->count();
         @endphp
         <li><a href="{{route('blogs',$blogCat)}}" class="{{$url==route('blogs',$blogCat)?'active':''}}">{{$blogCat['name']}} <span>({{ $countAccountBlogs }})</span></a></li>
         @endforeach
         @endif
      </ul>
      <div class="blog_grid_area">
         <ul>
            @if($getBlogList->count()>0)
            @foreach($getBlogList??'' as $blog)
            <li class="wow fadeInUp"  data-wow-delay="0.1s">
               <div class="blog_boxxxx">
                  <a href="{{ route('blogs', $blog->url_key) }}"> 
                     <img src="{{url($blog['image'])}}" alt="{{$blog['title']}}" title="{{$blog['title']}}">
                  </a>
                  <div class="blogg__text">
                     <h4>{{ $blog['name'] }}</h4>
                     <p></p>
                     <a href="{{ route('blogs', $blog->url_key) }}" class="btn_blog_link">View Full Post</a>
                  </div>
               </div>
            </li>
            @endforeach
            @endif
         </ul>
         <div class="clear"></div>
      </div>
   </div>
</div>
<!--//  Page-->
@endsection