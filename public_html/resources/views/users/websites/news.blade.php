@extends('users.master')
@section('seo_tags')
<title>Media | RN Valves & Faucets</title>
<meta name="description" content="Our full range of Bath Accessories, Bathroom Fitting, Faucets, Automatic Faucets, Valves, Sanitaryware, includes designs best suited for your home and building.">
<meta name="keywords" content="Bath Accessories, Bathroom Fitting, Faucets, Sensor Faucets, Valves, Showers, Health Faucets, Single Lever Mixer, Overhead Shower, Brass Ball Valves">
<meta property="og:title" content="Media | RN Valves & Faucets">
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
   <div class="container">
   <h1 class="text-center" style="
    font-size: 30px;
    font-weight: 600;
    margin-bottom: 40px;
    margin-top:20px;
">Media</h1>
<hr>
      
      <div class="blog_grid_area">
         <ul>
            @if($getNewsList->count()>0)
            @foreach($getNewsList??'' as $news)
            <li class="wow fadeInUp"  data-wow-delay="0.1s">
               <div class="blog_boxxxx">
                  <a href="{{ route('news', $news->url_key) }}"> 
                     <img src="{{url($news['image'])}}" alt="{{$news['title']}}" title="{{$news['title']}}">
                  </a>
                  <div class="blogg__text">
                     <h4>{{ $news['name'] }}</h4>
                     <p></p>
                     <a href="{{ route('news', $news->url_key) }}" class="btn_blog_link">View Full News</a>
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