@extends('users.master')
@section('seo_tags')
<title>About Us | Manufacturing | RN Valves & Faucets </title>
<meta name="description" content="RN Valves is a fast-growing multi-diversified full Bathroom and Sanitaryware brand. RN Valves is an acknowledged business manager in the combined bathroom fittings section"/>
<meta name="keywords" content="About RN Valves, brand, know about RN Valves, RN bathroom fittings, RN taps, RN Showers, RN sanitaryware, RN Ball Valves">
<meta property="og:title" content="RN Valves & Faucets | About Us | Manufacturing">
<meta property="og:image" content="{{url('users/assets/images/logo.png')}}">
<meta name="og:description" content="RN Valves is a fast-growing multi-diversified full Bathroom and Sanitaryware brand. RN Valves is an acknowledged business manager in the combined bathroom fittings section">
<meta property=twitter:title content="About Us | Manufacturing | RN Valves & Faucets ">
<meta property=twitter:description content="RN Valves is a fast-growing multi-diversified full Bathroom and Sanitaryware brand. RN Valves is an acknowledged business manager in the combined bathroom fittings section">
<meta property=twitter:image content="{{url('users/assets/images/logo.png')}}">
@endsection
@section('ccs_links')
<link rel="stylesheet" href="{{url('users/assets/css/custom.css')}}" type="text/css">
@endsection
@section('content')
<!--Page-->

<div class="cstm_page_section" style="background:#ffffff;">
   <div class="about_page_content">
      <div class="container-fluid">
         <h1 class="text-center" style="
    font-size: 30px;
    font-weight: 600;
    margin-bottom: 40px;
">About RN Valves & Faucets</h1>
     
            <div class="col-lg-12">
               {!! $data->youtube_link !!}
               {{-- <img src="{{url('images/about.jpg')}}" style="max-width: 100%;" alt="RN Valves & Faucets"> --}}
            </div>
         
         {!! $data->desc1 !!}

         <div class="row rnbxlsst">
            <div class="col-md-4">
               <div class="bxxmvs">
                  <h4>Vision</h4>
                  {!! $data->vision !!}
               </div>
            </div>
            <div class="col-md-4">
               <div class="bxxmvs" style="background: #00a0e3;">
                  <h4>Mission</h4>
                  {!! $data->mission !!}               
               </div>
            </div>
            <div class="col-md-4">
               <div class="bxxmvs">
                  <h4>Values</h4>
                  {!! $data->values !!}
               </div>
            </div>
         </div>
         <div class="about_tree">
            <div class="cntrhddng">
               <div class="bighdng">Milestones</div>
               Offering cutting-edge designs and energy-saving products that are proudly manufactured in India!
            </div>
            <div class="tree_outer_area">
              @foreach($milestones as $key => $milestone)
                  <!-- Loop start -->
                  <div class="histry_box">
                      <div class="insideb_xx treebox_50 {{ $key % 2 == 0 ? 'left__side' : 'right__side' }}">
                          <h3>{{ $milestone['year'] }}</h3>
                          <div class="histry_content_box">
                              <h5>{{ $milestone['title'] }}</h5>
                              <p>{{ $milestone['description'] }}</p>
                          </div>
                      </div>
                  </div>
                  <!-- Loop end -->
              @endforeach
            </div>
         </div>
      </div>
      <!--// Container-->
   </div>
</div>
<div class="about_btm_boxx">
   <div class="row">
      <div class="col-md-4 img_thboxx">
         <img src="{{asset($data->img1)}}" alt="RN Faucet">
      </div>
      <div class="col-md-4">
         <div class="abouttxxt">  
            {!! $data->desc2 !!}
         </div>
      </div>
      <div class="col-md-4 img_thboxx">
         <img src="{{asset($data->img2)}}" alt="Taps - RN">
      </div>
      <div class="col-md-12">
         <div class="bxxmvs p-4">
           {!! $data->desc3 !!}
         </div>
      </div>
   </div>
</div>
@endsection