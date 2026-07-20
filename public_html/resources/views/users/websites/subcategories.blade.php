@extends('users.master')
@section('seo_tags')
<title>{{$category['title']}}</title>
<!-- SEO Meta Tags-->
<meta name="description" content="{{$category['description']}}"/>
<meta name="keywords" content="{{$category['keywords']}}">
<meta property=og:type content=section>
<meta property="og:title" content="{{$category['title']}}">
<meta property="og:image" content="{{ url($category->image??'') }}">
<meta name="og:description" content="{{$category['description']}}">
<meta property=og:image:url content="{{ url($category->image??'') }}">
<meta property=twitter:title content="{{$category['title']}}">
<meta property=twitter:description content="{{$category['description']}}">
<meta property=twitter:image content="{{ url($category->image??'') }}">
@endsection
@section('content')
<style>
   .breadcrumb-area:before{
      background-image:url("{{asset($category['banner'])}}")!important;
   }
   
   @media (max-width: 768px) {
      .breadcrumb-area:before{
         background-image:url("{{asset($category['mobile_banner'])}}")!important;
      }
   }
</style>
<div class="breadcrumb-area style-03">
</div>

<div class="w-100 text-center py-2 cstm-sticky-banner-container">
    <div class="cstm-product-banner-wrapper">
        <h1 class="page-title fw-bold cstm-product-banner-title">
            {{ $category['name'] ?? '' }}
        </h1>

        <ul class="page-list cstm-product-banner-list">
           <!-- <li><a href="{{route('welcome')}}">Home</a></li> -->
           {{-- <li>{{ $category['name'] ?? '' }}</li> --}}
        </ul>
    </div>
</div>
<!--Page-->
<div class="cstm_page_section">
   <div class="container-fluid">
      <div class="rn_cate_listbox">
         <ul>
            @foreach($category['subcategories']->sortBy('display_order')??'' as $subCategory)
            @if($subCategory['is_visible_website']==1 && $subCategory['status']=='Active')
            <li>
               <a href="{{ route('productList.list', [$category['url_key'],$subCategory]) }}">
                  <div class="rn_proframebox">
                     <img src="{{ url($subCategory['image']??'') }}" alt="{{ $subCategory['name']??'' }}" title="{{ $subCategory['name']??'' }}">
                  </div>
                  <h3>
                    {{-- @if($subCategory->pdf_catalogue)
                     <img src="{{asset($subCategory->pdf_catalogue)}}" width="60" alt="">  
                     @endif --}}
                     {{$subCategory['name']??''}}  
                     @if($subCategory->is_new == 1)
                     <img src="https://rnvalves.media/Catalogue/master/new-1.gif" width="40" height="25" alt="New" srcset="">                                                        
                     @endif
                  </h3>
               </a>
            </li>
            @endif
            @endforeach
         </ul>
      </div>
   </div>
   <div class="container-fluid">
      <div class="page_editor">
         {!! $category['content']->content??'' !!}
      </div>
   </div>
</div>
<!--// Sign Up Page-->
@endsection