@extends('users.master')
@section('seo_tags')
<title>Career - RN Valves & Faucets</title>
<meta name="description" content="This Career explains how we collect and use information that you give via our websites or when you register for our services. Please review this Policy before you give us any data."/>
<meta name="keywords" content="RN Valves Career, RN Valves Policy, RN Valves Disclaimer, Career">
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
<!--Page-->
<div class="cstm_page_section" style="background:#ffffff;">
   <div class="blog-page-content">
      <div class="container-fluid">
         <div class="brdcrm_menu" style="margin-top: 5px !important;"><a href="{{ route('welcome') }}"><i class="fas fa-chevron-left"></i>Back to Home </a></div>
         <div class="row">
            <div class="col-lg-7">
               <div class="blog-details-wrap">
                  <!--Blog Details item-->
                  <div class="blog-details-items">
                     <h1 class="acc_page_title">Career with Us</h1>
                     <div class="blog_content_areaaa">
                        <p>
                           We, at RN Valves, believe in empowering the growth and development of aspiring professionals by providing a workspace full of rewarding opportunities.<br><br>
                           We constantly seek aspiring individuals who are looking for the right opportunity to work with full dedication and diligence to contribute to the success of the company. We, on the other hand, offer an environment full of trust and freedom to enhance the capabilities of individuals and help them sharpen their skills with expert guidance.
                        </p>
                     </div>
                  </div>
               </div>
            </div>
            @php
            $careers = App\Models\Career::getCareers();
            @endphp
            @if($careers->count()>0)
            <div class="col-lg-12">
               <div class="acc_page_title">We Are Hiring</div>
               <div class="table-responsive">
                  <table class="table table-striped">
                     <thead>
                        <tr>
                           <th>Title</th>
                           <th>Location</th>
                           <th>Posted</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($careers??'' as $career)
                        <tr>
                           <td class="blog_content_areaaa">
                              <a target="_blank" href="{{ url('career', $career) }}">
                                <u>{{ $career->title??'' }}</u>
                              </a>
                           </td>
                           <td class="blog_content_areaaa">
                              {{ $career->city??'' }} - {{ $career->state??'' }}
                           </td>
                           <td class="blog_content_areaaa">
                              {{ $career->published_at->format('d M Y')??'' }}
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
            @endif
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