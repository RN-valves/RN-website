@extends('users.master')
@section('seo_tags')
<title>Career/Jobs | {{ $getSingleCareer->title??'' }} - RN Valves & Faucets</title>
<meta name="description" content="This Career explains how we collect and use information that you give via our websites or when you register for our services. Please review this Policy before you give us any data."/>
<meta name="keywords" content="RN Valves Career, RN Valves Policy, RN Valves Disclaimer, Career, {{ $getSingleCareer->title??'' }}">
<meta property=og:type content="Career">
<meta property="og:title" content="Career - RN Valves & Faucets">
<meta property="og:image" content="{{url('users/images/resize.png')}}">
<meta name="og:description" content="This Career explains how we collect and use information that you give via our websites or when you register for our services. Please review this Policy before you give us any data.">
<meta property=og:image:url content="{{url('users/images/resize.png')}}">
<meta property=twitter:title content="Career - RN Valves & Faucets">
<meta property=twitter:description content="This Career explains how we collect and use information that you give via our websites or when you register for our services. Please review this Policy before you give us any data.">
<meta property=twitter:image content="{{url('users/images/resize.png')}}">
@endsection
@section('ccs_links')
<link rel="stylesheet" href="{{ url('users/assets/css/custom.css') }}" type="text/css">
@endsection
@section('content')
<div class="breadcrumb-area style-03">
   {{-- <img src="{{ url('users/images/hiring.webp') }}" width="100%"> --}}
   <div class="container">
      <div class="row">
         <div class="breadcrumb-content">
            <ul class="page-list">
               <li><a href="{{ route('welcome') }}">Home</a></li>
               <li><a href="{{ route('career') }}">Careers</a></li>
               <li>{{ $getSingleCareer->title??'' }}</li>
            </ul>
         </div>
      </div>
   </div>
</div>
<!--Page-->
<div class="cstm_page_section" style="background:#ffffff;">
   <div class="blog-page-content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12">
               <div class="acc_page_title">{{ $getSingleCareer->title??'' }}</div>
               <h4>{{ $getSingleCareer->designation??'' }}</h4>
               <p>{!! $getSingleCareer->content !!}</p>

               <a href="{{ route('contactUs') }}" class="btn btn-dark">Apply</a>
            </div>
         </div>
      </div>
   </div>
   <!--// Container-->
</div>
<!--// Blog Page Content-->
</div>
</div>
<!--//  Page-->
@endsection