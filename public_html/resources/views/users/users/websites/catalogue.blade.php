@extends('users.master')
@php $data = App\Models\AboutUs::first(); @endphp
@section('seo_tags')
<title>Catalogue | RN Valves & Faucets Product Price List</title>
<meta name="description" content="Stay updated by Downloading RN Valves Product Price List/Catalogue - Faucets | Showers | Valves | Sensor Faucets | Bath Accessories | Overhead Showers"/>
<meta name="keywords" content="RN Valves Product Catalogue, RN Valves products, Price List, RN Valves price list, bath accessories price list, showers price list, brochure, RN Valves brochure, sanitaryware price list, Valves Catalogue">
<meta property=og:type content=Catalogue>
<meta property="og:title" content="Catalogue | RN Valves & Faucets Product Price List">
<meta property="og:image" content="{{url('users/images/catalogue.png')}}">
<meta name="og:description" content="Stay updated by Downloading RN Valves Product Price List/Catalogue - Faucets | Showers | Valves | Sensor Faucets | Bath Accessories | Overhead Showers">
<meta property=twitter:title content="Catalogue | RN Valves & Faucets Product Price List">
<meta property=twitter:description content="Stay updated by Downloading RN Valves Product Price List/Catalogue - Faucets | Showers | Valves | Sensor Faucets | Bath Accessories | Overhead Showers">
<meta property=twitter:image content="{{url('users/images/catalogue.png')}}">
@endsection
@section('ccs_links')
<link rel="stylesheet" href="{{url('users/assets/css/custom.css')}}" type="text/css">
@endsection
@section('content')
<?php $url= url()->full(); ?>
<div class="breadcrumb-area style-03">
   <div class="container">
      <div class="row">
         <div class="breadcrumb-content">
            <h1 class="page-title">Catalogue</h1>
            <ul class="page-list">
               <li><a href="{{route('welcome')}}">Home</a></li>
               <li>Catalogue</li>
            </ul>
         </div>
      </div>
   </div>
</div>
<!--Page-->
<div class="cstm_page_section" style="background: #ffffff;">
   <div class="container-fluid">
      <div class="catalogue__listbox">
         <!---cate wise looop start-->
         <div class="catalogue__boxxxx">
            <h4>Complete Catalogues</h4>

            <ul>
               <li>
                  <div class="rn_proframebox">
                     <a target="_blank" href="{{ asset($data->catalogue)}}">
                        <img src="https://rnvalves.media/Catalogue/Banner/5.jpg" alt="RN Valves  Faucets - Catalogue" title="RN Valves  Faucets - Catalogue">
                     </a>
                  </div>
                  <h3> 
                     <a target="_blank" href="{{ asset($data->catalogue) }}"></a> Complete Catalogue 
                     <a href="{{ asset($data->catalogue) }}" class="dnld_links" download="RN-Catalogue-Price-List.pdf"><i class="fas fa-download"></i></a>
                  </h3>
               </li>
               @if(ActiveCategories()->count()>0)
               @foreach(ActiveCategories()??'' as $category)
               <!--loop--->      
               @if(!empty($subcategory->pdf_catalogue)) 
               <li>
                  <div class="rn_proframebox">
                     <a target="_blank" href="{{ asset($category->pdf_catalogue??'') }}">
                     <img src="{{ asset($category->image??'') }}" alt="{{ $category->title??'' }}" title="{{ $category->title??'' }}">
                     </a>
                  </div>
                  <h3> 
                     <a target="_blank" href="{{ asset($category->pdf_catalogue??'') }}"></a> {{ $category->name??'' }} 
                     <a href="{{ asset($category->pdf_catalogue??'') }}" class="dnld_links" download=""><i class="fas fa-download"></i></a>
                  </h3>
               </li>
               @endif
               <!--loop---> 
               @endforeach 
               @endif
            </ul>
         </div>
         <!---cate wise looop end-->
      </div>
   </div>
   <!--//Page-->
</div>
<style type="text/css">
   @media only screen and (max-width: 767px){
   .breadcrumb-area.style-03 .breadcrumb-content .page-list li:last-child {
   display: inline-block !important;
   }
   }
</style>
<!--popup form-->
@endsection