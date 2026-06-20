@extends('users.master')
@section('seo_tags')
@php
$url = url()->full();
@endphp
<title>{{$getSingleSubCategory['title']??'RN Valves & Faucets' }}</title>
<!-- SEO Meta Tags-->
<meta name="description" content="{{$getSingleSubCategory['description']??'RN Valves & Faucets' }}"/>
<meta name="keywords" content="{{ $getSingleSubCategory->keywords??'' }}">
<meta property=og:type content=category>
<meta property="og:title" content="{{$getSingleSubCategory['title']??'RN Valves & Faucets' }}">
<meta property="og:image" content="{{ url($getSingleSubCategory->image??'')??"" }}">
<meta name="og:description" content="{{$getSingleSubCategory['description']??'RN Valves & Faucets' }}">
<meta property=og:image:url content="{{ url($getSingleSubCategory->image??'')??"" }}">
<meta property=twitter:title content="{{$getSingleSubCategory['title']??'RN Valves & Faucets' }}">
<meta property=twitter:description content="{{$getSingleSubCategory['description']??'RN Valves & Faucets' }}">
<meta property=twitter:image content="{{ url($getSingleSubCategory->image??'')??"" }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<script type="application/ld+json">
{
   "@context" : "http://schema.org",
   "@type" : "LocalBusiness",
     "name" : "{{ $getSingleSubCategory['title']??'RN Valves & Faucets' }}",
     "image" : "{{ url($getSingleSubCategory->image??'') }}",
      "telephone" : "+919811103377",
     "email" : "web@rnvalves.com",
     "address" : {
       "@type" : "PostalAddress",
       "addressCountry" : "India"
     },
     "url" : "{{$url}}",
   "sameAs" : [
      " https://twitter.com/RNValves",
      " https://www.facebook.com/rnvalvesandfaucets/",
      " https://www.linkedin.com/company/rn-valves-faucets/",
      " https://www.youtube.com/channel/UCpUUF6ZFL88S85IuSsHDRSQ/?sub_confirmation=1", 
      " https://www.instagram.com/rnvalvesandfaucets/"
      ],
   
     "aggregateRating" : {
       "@type" : "AggregateRating",
       "ratingValue" : "5",
       "bestRating" : "5",
          "ratingCount" : "150"
     },
     "review" : {
       "@type" : "Review",
       "author" : {
         "@type" : "Person",
         "name" : "150"
       },
       "reviewRating" : {
         "@type" : "Rating",
      "ratingValue":"4.5"
      }
   }
}   

</script>
<script> 
   gtag('event', 'conversion', {'send_to': 'AW-610718723/u5BYCMzDuYYaEIOom6MC'}); 
</script>
@endsection
@section('content')
@if(!empty($getSingleSubCategory))
<style>
   .breadcrumb-area:before{
      background-image:url("{{asset($getSingleSubCategory['banner'])}}")!important;
      background-size: cover;
      background-repeat: no-repeat;
      width: 100%;
      height: 120%;
   }  
</style>
@endif
<div class="breadcrumb-area style-03">
   {{-- <div class="container">
      <div class="row">
         <div class="breadcrumb-content">
            @if(!empty($getSingleSubCategory))
            <h1 class="page-title">{{ $getSingleSubCategory['name']??'' }}</h1>
            @else
            <h1 class="page-title">{{ request('q') ?? request('product_name') }}</h1>
            @endif
            @if(!empty($getSingleSubCategory))
            <ul class="page-list">
               <li><a href="{{route('welcome')}}">Home</a></li>
               <li><a href="{{route('productList', $getSingleSubCategory->category)}}">{{ $getSingleSubCategory->category->name??'' }}</a></li>
               <li>{{ $getSingleSubCategory['name']??'' }}</li>
            </ul>
            @endif
         </div>
      </div>
   </div> --}}
</div>

<div class="w-100 text-center py-2 cstm-sticky-banner-container">
    <div class="cstm-product-banner-wrapper">
        @if(!empty($getSingleSubCategory))
            <h1 class="page-title fw-bold cstm-product-banner-title">
                {{ $getSingleSubCategory['name'] ?? '' }}
            </h1>
        @else
            <h1 class="page-title cstm-product-banner-title-alt">
                {{ request('q') ?? request('product_name') }}
            </h1>
        @endif

        @if(!empty($getSingleSubCategory))
             <ul class="page-list cstm-product-banner-list">
               {{-- <li><a href="{{route('welcome')}}">Home</a></li> --}}
               <li><a href="{{route('productList', $getSingleSubCategory->category)}}">{{ $getSingleSubCategory->category->name??'' }}</a></li>
               {{-- <li>{{ $getSingleSubCategory['name']??'' }}</li> --}}
            </ul>
        @endif
    </div>
</div>


         
         
<!--Page-->
<div class="cstm_page_section">
   <div class="container-fluid">
      <div class="row">
         
         <div class="col-lg-9 order-1 order-lg-2">
            <!-- Shop Page Grig View-->
            <div class="shop-page-grid-view">
               <div class="product-filtering-area">
                  <div class="filter-left">
                     <!--mobile filter-->
                     @if(empty(request('q')) && empty(request('product_name')))
                     @include('users.websites.listings.mobile_filter')
                     @endif
                     <!--mobile filter end-->
                  </div>
                  <div class="filter-right">
                     <select class="sort_select changeSortBy" id="sortBy" name="sortBy">
                        <option value="">Select Filter</option>
                        <option value="product_new">Sort by New</option>
                        <option value="price_lowest">Price : low to high</option>
                        <option value="price_highest">Price : high to low</option>
                     </select>
                  </div>
               </div>
               <!--// Product Filtering Area-->
               <div class="grid-list-wrapper padding-top-20 product-item" id="AjaxProductList">
                  @include('users.websites.listings.product_listing')
               </div>
               <!-- Pagination-->
               <div class="text-center pt-3">
                  <a href="javascript:;" @if(empty($page)) style="display:none;" @endif data-page="{{ $page }}" class="btn btn-primary rounded-0 shadow-none LoadMore">View More</a>
               </div>
               <!--// Pagination-->
            </div>
            <!--// Shop Page Grid View-->
         </div>
         {{-- Desktop sidebar Filter  --}}
         @include('users.websites.listings.desktop_filter')
         {{-- Desktop sidebar Filter  --}}
      </div>
   </div>
</div>
<!--//  Page-->
<style type="text/css">
   .right-menu {
   margin-right: 10px;
   background-color: lightgrey;
   padding: 0px 10px;
   border-radius:5px;
   font-weight:bold;
   }
</style>
@endsection
@section('scripts')
<script type="text/javascript">
   $(document).ready(function(){
      /*sortBy Filter*/
      $('.changeSortBy').change(function(){
         var sortBy = $(this).val();
         $('#get_sort_by').val(sortBy);
         filterForm();
      });
   
   
      $('.filterAjax').change(function(){
         var sizes = '';
         //var size = $(this).val();
         //console.log(size);
         $('.filterAjax').each(function(){
            if(this.checked){
               var size = $(this).val();
               sizes += size+',';
            }
         });
         //console.log(sizes);
         $('#get_sizes').val(sizes);
         filterForm();
      });
   
      //color filter scripts
      $('.filterColor').change(function(){
         var colors = '';
         $('.filterColor').each(function(){
            if(this.checked){
               var color = $(this).val();
               colors += color+',';
            }
         });
         $('#get_colors').val(colors);
         filterForm();
      });
        //bullet filter scripts
        $('.filterBullet').change(function(){
         var bullets = '';
         $('.filterBullet').each(function(){
            if(this.checked){
               var bullet = $(this).val();
               bullets += bullet+'@@@';
            }
         });
         $('#get_bullets').val(bullets);
         filterForm();
      });
   
      //category filter scripts
      $('.filterCategory').change(function(){
         var categories = '';
         $('.filterCategory').each(function(){
            if(this.checked){
               var category = $(this).val();
               categories += category+',';
            }
         });
         $('#get_subcategories').val(categories);
         filterForm();
      });
   
      /*var xhr;*/
      // function filterForm(){
      //    /*var values = $( "#filterForm" ).serialize();
      //    console.log(values);*/
      //    var form = $("#filterForm");
      //    /*if(xhr && xhr.readyState ! = 4){
      //       xhr.abort();
      //    }*/
      //    xhr = $.ajax({
      //       type: form.attr('method'),
      //       url: form.attr('action'),
      //       data: form.serialize(),
      //       dataType: 'json',
      //       success : function(data){
      //          if(data.length == 0){
      //             $('.NoData').append('No Data Found');
      //          }
      //          $("#AjaxProductList").html(data.success);
      //          $('.LoadMore').attr('data-page',data.page);
      //          if(data.page==0){
      //             $('.LoadMore').hide();
      //          }else{
      //             $('.LoadMore').show();
      //          }
      //       },
      //       error : function(data){
               
      //       }
      //    });
      // }
   
      // $('body').delegate('.LoadMore', 'click', function(){
      //    var page = $(this).attr('data-page');
      //    /*$("#ajaxLoadMore").html('Loading..');*/
      //    $('.LoadMore').html('Loading......');
      //    var form = $("#filterForm");
      //    xhr = $.ajax({
      //       type: form.attr('method'),
      //       url: "{{url('filter-products-list')}}?page="+page,
      //       data: form.serialize(),
      //       dataType: 'json',
      //       success : function(data){
      //          if(data.length == 0){
      //             $('.NoData').append('No Data Found');
      //          }
      //          $("#AjaxProductList").append(data.success);
      //          $('.LoadMore').attr('data-page',data.page);
      //          $('.LoadMore').html('View More');
      //          if(data.page==0){
      //             $('.LoadMore').hide();
      //          }else{
      //             $('.LoadMore').show();
      //          }
      //       },
      //       error : function(data){
               
      //       }
      //    });
      // });
   
    // Filter form changes
   
 
    let loading = false;
let allProductsLoaded = false;
let currentPage = 1; // Start from page 1
let xhr;

/*
function loadMoreProducts(page) {
    if (loading || allProductsLoaded) return;
    loading = true;
    console.log("Loading page:", page);
    $('.LoadMore').html('Loading...');

    const form = $("#filterForm");

    $.ajax({
        type: form.attr('method'),
        url: "{{ url('filter-products-list') }}?page=" + page + "&_t=" + new Date().getTime(),
        data: form.serialize(),
        dataType: 'json',
        success: function (data) {
            //console.log("Response received:", data);

            if (data.status && data.success) {
                let newProducts = $(data.success);
                let existingProductIds = new Set();

                // Store already loaded product IDs
                $(".product-item").each(function () {
                    existingProductIds.add($(this).data("product-id"));
                });

                let addedProducts = 0;

                // Append only new products
                newProducts.each(function () {
                    let productId = $(this).data("product-id");
                    if (!existingProductIds.has(productId)) {
                        $("#AjaxProductList").append($(this));
                        addedProducts++;
                    }
                });

                // Increment page number only if new products were added
                if (addedProducts > 0) {
                    currentPage = data.page; // Update with the next page from the response
                    $('.LoadMore').text('View More');
                    $('.LoadMore').attr('data-page', currentPage);
                }

                // Stop loading if no more pages
                if (data.page === 0 || addedProducts === 0) {
                    console.warn("No more products to load.");
                    allProductsLoaded = true;
                    $('.LoadMore').hide();
                }
            } else {
                console.warn("No more products to load.");
                allProductsLoaded = true;
                $('.LoadMore').hide();
            }
            loading = false;
        },
        error: function (xhr, status, error) {
            console.error("Error loading products:", {
                status: status,
                error: error,
                response: xhr.responseText
            });
            $('.LoadMore').html('View More');
            loading = false;
        },
    });
}
*/

function loadMoreProducts(page) {
    if (loading || allProductsLoaded) return;
    loading = true;
    console.log("Loading page:", page);
    $('.LoadMore').html('Loading...');

    const form = $("#filterForm");

    $.ajax({
        type: form.attr('method'),
        // ✅ FIX 1: increment the page number before sending request
        url: "{{ url('filter-products-list') }}?page=" + (page + 1) + "&_t=" + new Date().getTime(),
        data: form.serialize(),
        dataType: 'json',
        success: function (data) {
            if (data.status && data.success) {
                let newProducts = $(data.success);
                let existingProductIds = new Set();

                // ✅ FIX 2: target only actual product elements
                $("#AjaxProductList .single-product-item").each(function () {
                    existingProductIds.add($(this).data("product-id"));
                });

                let addedProducts = 0;

                // ✅ FIX 3: append only unique products
                newProducts.each(function () {
                    let productId = $(this).data("product-id");
                    if (!existingProductIds.has(productId)) {
                        $("#AjaxProductList").append($(this));
                        addedProducts++;
                    }
                });

                // ✅ FIX 4: properly increment local currentPage
                currentPage = page + 1;

                if (addedProducts > 0) {
                    $('.LoadMore').text('View More');
                    $('.LoadMore').attr('data-page', currentPage);
                }

                if (data.page === 0 || addedProducts === 0) {
                    console.warn("No more products to load.");
                    allProductsLoaded = true;
                    $('.LoadMore').hide();
                }
            } else {
                console.warn("No more products to load.");
                allProductsLoaded = true;
                $('.LoadMore').hide();
            }
            loading = false;
        },
        error: function (xhr, status, error) {
            console.error("Error loading products:", {
                status: status,
                error: error,
                response: xhr.responseText
            });
            $('.LoadMore').html('View More');
            loading = false;
        },
    });
}



let proCount = parseInt("{{ count($productsList) }}"); 
if(proCount == 21){
$(window).scroll(function () {
    const lastProduct = $('.product-item').last();
    const requrl = "{{request()->routeIs('search')}}";
   //  if (!requrl) {
        if (lastProduct.length > 0 && !loading && !allProductsLoaded) {
            const lastProductOffset = lastProduct.offset().top + lastProduct.outerHeight();
            const windowBottom = $(window).scrollTop() + $(window).height();

            if (windowBottom >= lastProductOffset - 100) {
                loadMoreProducts(currentPage); // Use the current page
            }
        }
   //  }
});
}



    // Filter form changes
    function filterForm() {
     const form = $("#filterForm");
     allProductsLoaded = false;
     $('.LoadMore').attr('data-page', 1); 

     if (xhr) xhr.abort();
        xhr = $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            dataType: 'json',
            success: function (data) {
               $("#AjaxProductList").html(data.success);

               $('.LoadMore').attr('data-page', data.page);
               if (data.page == 0) {
                   $('.LoadMore').hide();
                   allProductsLoaded = true;
               } else {
                   $('.LoadMore').show();
               }
            },
            error: function (data) {
                console.error("Error filtering products:", data);
            },
        });
    }

    // Filter form logic
    $('.filterAjax, .filterColor, .filterBullet, .filterCategory').change(filterForm);
});

</script>

@endsection