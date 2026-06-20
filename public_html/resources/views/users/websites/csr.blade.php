@extends('users.master')
@section('seo_tags')
<title>RN Valves & Faucets Corporate Social Responsibility (CSR) </title>
<!-- SEO Meta Tags-->
<meta name="description" content="We, at RN Valves, firmly believe in empowering social and economic development by providing technology and expertise."/>
<meta name="keywords" content="RN Valves CSR, CSR Activities, RN Valves Vision, RN Valves Skill Development, RN Valves Corporate Social Responsibility, RN Valves">
<meta property=og:type content=category>
<meta property="og:title" content="RN Valves & Faucets Corporate Social Responsibility (CSR) ">
<meta property="og:image" content="{{url('users/images/exb/exhibition1.jpg')}}">
<meta name="og:description" content="We, at RN Valves, firmly believe in empowering social and economic development by providing technology and expertise.">
<meta property=og:image:url content="{{url('users/images/exb/exhibition1.jpg')}}">
<meta property=twitter:title content="RN Valves & Faucets Corporate Social Responsibility (CSR) ">
<meta property=twitter:description content="We, at RN Valves, firmly believe in empowering social and economic development by providing technology and expertise.">
<meta property=twitter:image content="{{url('users/images/exb/exhibition1.jpg')}}">
@endsection
@section('content')
<div class="breadcrumb-area style-03">
   <div class="container">
      <div class="row">
         <div class="breadcrumb-content">
            <h1 class="page-title">{{dynamicPage('our-csr')->title}}</h1>
            <ul class="page-list">
               <li><a href="{{route('welcome')}}">Home</a></li>
               <li>{{dynamicPage('our-csr')->title}}</li>
            </ul>
         </div>
      </div>
   </div>
</div>
<!--Page-->
<div class="cstm_page_section">
   <div class="container-fluid">
      <div class="catalogue__listbox csr_gallery">
         <!---cate wise looop start-->
         <div class="catalogue__boxxxx">
            <h4><strong>{{dynamicPage('our-csr')->title}}</strong></h4>
            <!-- <p>
               We, at RN Valves, firmly believe in empowering the social and economic development by providing technology and expertise. With our constant efforts in upbringing the growth in social responsibilities, we are determined towards the welfare of society and the environment.<br><br>
               The RN Valves cluster is a quickly growing multi-diversified Valves and Faucets Manufacturer. Today, it caters to varied socio-economic segments with brands like Precious and Ornate and CP Fitting, RN Valves within the premium section. RN Valves cluster is the undisputed market leader of the unionized marketplace for faucets and valves in India, and one in all the quickest growing in its class across the planet.<br>
               Moving forward with our vision of achieving a “Swachh, Swastha Avam Shikshit Bharat”, we the family of RN Valves are tenacious towards creating a difference in the society.
            </p>
            <h4>Our Successfull Exhibitions</h4> -->
            {!! dynamicPage('our-csr')->description !!}
            <ul>
               <!--loop--->     
               @php $images =  App\Models\ExhibitionImage::get(); @endphp    
               @foreach($images as $img)
               <li>
                  <div class="rn_proframebox">
                     <img src="{{asset($img->file)}}" alt="RN Successfull Exhibitions">
                  </div>
               </li>
               @endforeach
               <!--loop--->  
              
               <!--loop---> 
            </ul>
         </div>
         <!---cate wise looop end-->
         </ul>
      </div>
      <!---cate wise looop end-->
   </div>
</div>
<!--//Page-->
</div>
<link rel="stylesheet" href="{{url('users/assets/css/custom.css')}}" type="text/css">
<style type="text/css">
   .csr_gallery .catalogue__boxxxx {background:transparent !important;border-bottom:0px !important;padding:0px !important;
   margin-bottom: 25px;}
   .csr_gallery .catalogue__boxxxx h4 {font-weight: 400 !important;}
   .csr_gallery.catalogue__listbox ul li .rn_proframebox{height: auto !important;}
   .csr_gallery.catalogue__listbox ul li .rn_proframebox img{-webkit-filter: grayscale(0) !important;filter: grayscale(0) !important;}
   @media only screen and (max-width: 767px){
   .breadcrumb-area.style-03 .breadcrumb-content .page-list li:last-child {
   display: inline-block !important;}
   }
</style>
@endsection