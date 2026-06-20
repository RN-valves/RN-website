@php
$newArriwals = App\Models\Product::where(['new_arrival'=>1, 'status'=>'Active', 'is_visible_website'=>1])->inRandomOrder()->limit(8)->get();
@endphp
@if($newArriwals->count()>0)
<div class="our-team-section padding-top-60 padding-bottom-50" style="background: #fafafa; margin-top:0px;">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12">
            <div class="section-title-wrap text-center">
               <!--Section Title-->
               <div class="section-title">
                  <h2 class="heading-02">New Arrival Products</h2>
                  <div class="padding-top-10 padding-bottom-20">
                     <p>Check out our new features designed to improve your bathroom's elegance and functionality. Our range includes innovative taps, beautiful showers, durable PTMT taps and high quality CP accessories, all designed for functionality and beauty.   Our PTMT taps and CP taps feature a new design that allows smooth water flow. Optimize water pressure with adjustable settings to make showering more convenient. Made from high-quality polymer, our PTMT Taps are very strong,  rust- and corrosion-resistant, and offer superior performance. At the same time, CP products add a touch of luxury, shine, sparkle, and stay beautiful for years to come.   Renovate your bathroom with these new accessories that combine elegance, durability and innovation, tailored to your everyday needs.</p>
                  </div>
               </div>
               <!--// Section Title-->
            </div>
         </div>
         <!------Mobile Related start---------------->
         <div class="mobile_related_product col-lg-12" style="display:none!important;">
            @foreach($newArriwals->take(8)??'' as $newArriwal)
            <!-- Grid List Column-->
            <div class="grid-list-column-item">
               {{-- <span class="price-drop-tag"></span> --}}
               <div class="thumb">
                  <a href="{{ route('productList.view', [$newArriwal->category->url_key, $newArriwal->subcategory->url_key, $newArriwal->url_key]) }}"><img src="{{ url($newArriwal->image??'') }}" alt="{{$newArriwal->title??''}}"></a>
               </div>
               <div class="contnt_bxxx">
                  <a href="{{ route('productList.view', [$newArriwal->category->url_key, $newArriwal->subcategory->url_key, $newArriwal->url_key]) }}">
                     <h6>{{$newArriwal->category->name??''}} | {{$newArriwal->subcategory->name??''}}</h6>
                  </a>
                  <a href="{{ route('productList.view', [$newArriwal->category->url_key, $newArriwal->subcategory->url_key, $newArriwal->url_key]) }}">
                     <h5 class="title">{{$newArriwal->name??''}}</h5>
                  </a>
                  <div class="prdct_code">Product Code : <strong>{{$newArriwal->article??''}}</strong></div>
                  <div class="prdct_code">Product Size : <strong>{{$newArriwal->size??''}}</strong></div>
                  <div class="common-price-style ">
                     <span>₹</span>{{$newArriwal->in_mrp??0}}
                     <div class="main-btn-wrap">
                        <a href="{{ route('productList.view', [$newArriwal->category->url_key, $newArriwal->subcategory->url_key, $newArriwal->url_key]) }}" class="main-btn"><i class="flaticon-shopping-cart"></i> Add To Cart</a>
                     </div>
                  </div>
               </div>
            </div>
            @endforeach
            <!--// Grid List Column-->
         </div>
         <!------Mobile Related end---------------->
         <div class="col-lg-12">
            <div class="padding-top-20 padding-bottom-20">
               <div class="h2-our-team-slider-active related_products">
                  @foreach($newArriwals??'' as $newArriwal)
                  <div class="home-2-our-team-items">
                     <div class="items-inner">
                        <!-- Team image-->
                        <div class="grid-list-column-item">
                           {{-- <span class="price-drop-tag"></span> --}}
                           <div class="thumb">
                              <a href="{{ route('productList.view', [$newArriwal->category->url_key, $newArriwal->subcategory->url_key, $newArriwal->url_key]) }}">
                                 <img src="{{ url($newArriwal->image??'') }}" alt="{{$newArriwal->title??''}}" loading="lazy" title="{{$newArriwal->title??''}}"{{--  class="hvrimg" --}}>
                                 {{-- <img src="https://rnvalves.media/Catalogue/RNPTMT/ANI-PRO/White/RNANP01A15.png" alt="{{$newArriwal->title??''}}" title="{{$newArriwal->title??''}}"> --}}
                              </a>
                           </div>
                           <div class="contnt_bxxx">
                              <a href="{{ route('productList.view', [$newArriwal->category->url_key, $newArriwal->subcategory->url_key, $newArriwal->url_key]) }}">
                                 <h6>{{$newArriwal->category->name??''}} | {{$newArriwal->subcategory->name??''}}</h6>
                              </a>
                              <a href="{{ route('productList.view', [$newArriwal->category->url_key, $newArriwal->subcategory->url_key, $newArriwal->url_key]) }}">
                                 <h5 class="title">{{$newArriwal->name??''}}</h5>
                              </a>
                              <div class="prdct_code">Product Code : <strong>{{$newArriwal->article??''}}</strong></div>
                              <div class="prdct_code">Product Size : <strong>{{$newArriwal->size??''}}</strong></div>
                              <div class="common-price-style ">
                                 <span>₹</span>{{$newArriwal->in_mrp??0}}
                                 <!--amazon and flipkart link start-->
                                 <div class="amaflipbox">
                                    @if(!empty($newArriwal['productAttribute']['flipkart_link']))
                                    <a href="{{ url($newArriwal['productAttribute']['flipkart_link']??'') }}"><img src="icons/flipkart.png" alt="RN Valves & Faucets - Flipkart" title="RN Valves & Faucets - Flipkart" /></a>
                                    @endif
                                    @if(!empty($newArriwal['productAttribute']['amazon_link']))
                                    <a href="{{ url($newArriwal['productAttribute']['amazon_link']) }}"><img src="icons/amazon.png" alt="RN Valves & Faucets - Amazon" title="RN Valves & Faucets - Amazon" /></a>
                                    @endif
                                 </div>
                                 <!--amazon and flipkart link end-->
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  @endforeach
               </div>
               <!--// Slider Active-->
            </div>
         </div>
      </div>
      <!--// Row-->
   </div>
   <!--// Container-->
</div>
@endif
<style type="text/css">
   .grid-list-column-item{width: 100% !important;}
   .theiaStickySidebar .nt_bg_lz {background-size: contain  !important; border: 1px solid #ddd !important;}
   .pswp__img{height: auto !important; margin-top: 50px;}
   .pswp__button--share{display: none !important;}
   .theiaStickySidebar .padding-top__127_66 { padding-top: 115.66%;}
   .shipping-product {
   display: flex;
   align-items: center;
   padding: 8px 15px;
   background: #f9f9f9;
   font-size: 13px;
   margin-bottom: 10px; border-radius: 3px;
   }
   .shipping-product span {
   color: #000;
   margin-left: 10px;
   font-weight: 800;
   }
   .shipping-product p {
   padding-right: 10px;
   margin-left: 5px; margin-bottom: 0px;
   }
   .quantity .tc a,  .quantity .tc button { top: 1px !important;}
   .quantity input.input-text[type="number"] { height: 35px !important;}
   .header_shadow{box-shadow: none !important;}
   @import url(https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css);
   fieldset, label { margin: 0; padding: 0; }
   h1 { font-size: 1.5em; margin: 10px; }
   /****** Style Star Rating Widget *****/
   .rating { 
   border: none;
   float: left;
   }
   .rating > input { display: none; } 
   .rating > label:before { 
   margin: 5px;
   font-size: 1.25em;
   font-family: 'Font Awesome 5 Free';
   display: inline-block;
   content: "\f005";
   }
   .rating > .half:before { 
   content: "\f089";
   position: absolute;
   }
   .rating > label { 
   color: #ddd; 
   float: right; 
   }
   /***** CSS Magic to Highlight Stars on Hover *****/
   .rating > input:checked ~ label, /* show gold star when clicked */
   .rating:not(:checked) > label:hover, /* hover current star */
   .rating:not(:checked) > label:hover ~ label { color: #FFD700;  } /* hover previous stars in list */
   .rating > input:checked + label:hover, /* hover current star when changing rating */
   .rating > input:checked ~ label:hover,
   .rating > label:hover ~ input:checked ~ label, /* lighten current selection */
   .rating > input:checked ~ label:hover ~ label { color: #FFED85;  }  
   .breadcrumb-area { padding: 50px 0 50px 0 !important;}
   .breadcrumb-area.style-03 .breadcrumb-content{padding: 10px 25px 10px 25px !important;}
</style>