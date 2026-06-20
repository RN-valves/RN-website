@extends('users.master')
@section('seo_tags')
<title>Certificates - RN Valves & Faucets</title>
<meta name="description" content="This Certificates explains how we collect and use information that you give via our websites or when you register for our services. Please review this Policy before you give us any data."/>
<meta name="keywords" content="RN Valves Certificates, RN Valves Policy, RN Valves Disclaimer, Certificates">
<meta property=og:type content="Certificates">
<meta property="og:title" content="Certificates - RN Valves & Faucets">
<meta property="og:image" content="{{url('users/images/assured.png')}}">
<meta name="og:description" content="This Certificates explains how we collect and use information that you give via our websites or when you register for our services. Please review this Policy before you give us any data.">
<meta property=og:image:url content="{{url('users/images/assured.png')}}">
<meta property=twitter:title content="Certificates - RN Valves & Faucets">
<meta property=twitter:description content="This Certificates explains how we collect and use information that you give via our websites or when you register for our services. Please review this Policy before you give us any data.">
<meta property=twitter:image content="{{url('users/images/assured.png')}}">
@endsection
@section('ccs_links')
<link rel="stylesheet" href="{{url('users/assets/css/custom.css')}}" type="text/css">
@endsection
@section('content')
<!--Page-->
<div class="cstm_page_section website-cart addressbxx">
   <div class="container-fluid">
      <div class="brdcrm_menu" style="margin-top: 5px !important;"><a href="{{route('welcome')}}"><i class="fas fa-chevron-left"></i>Back to Home </a></div>
      <div class="row">
         @include('users.websites.policies.menu')
         <div class="col-lg-8">
            <div class="blog-details-wrap">
               <!--Blog Details item-->
               <div class="blog-details-items">
                  <h1 class="acc_page_title">{{@$data->title}}</h1>
                  <div class="blog_content_areaaa">
                     <!-- <p class="mb-1">
                        RN Valves & Faucets is a company involved in the manufacturing and distribution of valves, faucets, and related products. Certifications play a crucial role in establishing the quality, safety, and reliability of their products.
                     </p>
                     <div>
                        <b>Here are some common certifications that a company like RN Valves & Faucets might have:</b>
                     </div>
                     <ul>
                        <li>
                           <p class="mb-2 pt-2"><strong>ISO Certifications:</strong></p>
                           <ul>
                              <li><strong>ISO 9001:</strong> Quality Management System Certification. This ensures that the company&apos;s products meet customer and regulatory requirements and that they consistently improve their processes.</li>
                              <li><strong>ISO 14001:</strong> Environmental Management System Certification. It demonstrates the company&apos;s commitment to minimizing environmental impact through responsible management.</li>
                           </ul>
                        </li>
                        <li>
                           <p class="mb-2 pt-2"><strong>BIS Certification:</strong></p>
                           <ul>
                              <li><strong>Bureau of Indian Standards (BIS):</strong> For products sold in India, this certification ensures that the products meet Indian standards for safety, quality, and reliability.</li>
                           </ul>
                        </li>
                        <li>
                           <p class="mb-2 pt-2"><strong>CE Marking:</strong></p>
                           <ul>
                              <li>A certification mark that indicates conformity with health, safety, and environmental protection standards for products sold within the European Economic Area (EEA).</li>
                           </ul>
                        </li>
                        <li>
                           <p class="mb-2 pt-2"><strong>NSF/ANSI Standards:</strong></p>
                           <ul>
                              <li>Particularly important for faucets, this certification ensures that the product meets health and safety standards for materials in contact with drinking water.</li>
                           </ul>
                        </li>
                        <li>
                           <p class="mb-2 pt-2"><strong>UPC Certification:</strong></p>
                           <ul>
                              <li>The Uniform Plumbing Code (UPC) certification, particularly in North America, ensures that the plumbing products meet the necessary standards for safety and durability.</li>
                           </ul>
                        </li>
                        <li>
                           <p class="mb-2 pt-2"><strong>Green Certifications:</strong></p>
                           <ul>
                              <li>Certifications such as LEED (Leadership in Energy and Environmental Design) or GreenPro</li>
                           </ul>
                        </li>
                     </ul>
                     <p>
                        <i>These certifications would ensure that RN Valves & Faucets' products are recognized for their quality and safety across various markets. If you need details on specific certifications they hold, it might be best to check their official website or contact them directly.</i>
                     </p> -->
                     {!! @$data->description !!}
                  </div>
               </div>
            </div>
            <div class="blog_right_side row">
               @foreach($certs as $certi)
               <div class="col-lg-3">
                  <div class="card">
                     <div class="card-img rn_proframebox">
                        <img src="{{ asset(@$certi->image) }}" width="100%">
                     </div>
                  </div>
               </div>
               @endforeach
               <!-- <div class="col-lg-3">
                  <div class="card">
                     <div class="card-img rn_proframebox">
                        <img src="{{ url('users/images/rn-certificate.jfif') }}" width="100%">
                     </div>
                  </div>
               </div>
               <div class="col-lg-3">
                  <div class="card">
                     <div class="card-img rn_proframebox">
                        <img src="{{ url('users/images/rn-green.jfif') }}" width="100%">
                     </div>
                  </div>
               </div>
               <div class="col-lg-3">
                  <div class="card">
                     <div class="card-img rn_proframebox">
                        <img src="{{ url('users/images/rn-iso.jfif') }}" width="100%">
                     </div>
                  </div>
               </div> -->
            </div>
         </div>
      </div>
   </div>
</div>
</div>
</div>
@endsection