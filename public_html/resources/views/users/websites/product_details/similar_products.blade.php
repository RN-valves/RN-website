<div class="our-team-section padding-top-60 padding-bottom-50" style="background: #fafafa; margin-top:0px;">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12">
            <div class="section-title-wrap text-center">
               <!--Section Title-->
               <div class="section-title">
                  <h3>Other Products in this section</h3>
               </div>
               <!--// Section Title-->
            </div>
         </div>
         <!------Mobile Related start---------------->
         <div class="mobile_related_product col-lg-12">
            @foreach($similarProducts??'' as $similarProduct)
            <!-- Grid List Column-->
            <div class="grid-list-column-item">
               {{-- <span class="price-drop-tag"></span> --}}
               <div class="thumb">
                  <a href="{{ route('productList.view', [$similarProduct->category->url_key, $similarProduct->subcategory->url_key, $similarProduct->url_key]) }}"><img src="{{ url($similarProduct->image??'') }}" alt="{{$similarProduct->title??''}}"></a>
               </div>
               <div class="contnt_bxxx">
                  <a href="{{ route('productList.view', [$similarProduct->category->url_key, $similarProduct->subcategory->url_key, $similarProduct->url_key]) }}">
                     <h5 class="title">{{ $similarProduct->subcategory->name ?? '' }} | {{$similarProduct->name??''}}</h5>
                  </a>
                  <div class="prdct_code">Product Code : <strong>{{$similarProduct->article??''}}</strong></div>
                  <div class="prdct_code">Product Size : <strong>{{$similarProduct->size??''}}</strong></div>
                  <div class="common-price-style ">
                     <span>₹</span>{{$similarProduct->in_mrp??0}}
                     @if($similarProduct->in_v1_mrp>$similarProduct['in_mrp'])
                     <del><small>₹{{$similarProduct->in_v1_mrp}}</small></del>
                     @endif
                     <div class="main-btn-wrap">
                        <a href="{{ route('productList.view', [$similarProduct->category->url_key, $similarProduct->subcategory->url_key, $similarProduct->url_key]) }}" class="main-btn"><i class="flaticon-shopping-cart"></i> Add To Cart</a>
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
                  @foreach($similarProducts??'' as $similarProduct)
                  <div class="home-2-our-team-items">
                     <div class="items-inner">
                        <!-- Team image-->
                        <div class="grid-list-column-item">
                           {{-- <span class="price-drop-tag"></span> --}}
                           <div class="thumb">
                              <a href="{{ route('productList.view', [$similarProduct->category->url_key, $similarProduct->subcategory->url_key, $similarProduct->url_key]) }}">
                              <img src="{{ url($similarProduct->image??'') }}" alt="{{$similarProduct->title??''}}" title="{{$similarProduct->title??''}}">
                              </a>
                           </div>
                           <div class="contnt_bxxx">
                              <a href="#">
                                 <h6>{{ $similarProduct->category->name ?? '' }} | {{ $similarProduct->subcategory->name ?? '' }}</h6>
                              </a>
                              <a href="#">
                                 <h5 class="title">{{$similarProduct->name??''}}</h5>
                              </a>
                              <div class="prdct_code">Product Code : <strong>{{$similarProduct->article??''}}</strong></div>
                              <div class="prdct_code">Product Size : <strong>{{$similarProduct->size??''}}</strong></div>
                              <div class="common-price-style ">
                                 <span>₹</span>{{$similarProduct->in_mrp??0}}
                                 @if($similarProduct->in_v1_mrp>$similarProduct['in_mrp'])
                                 <del><small>₹{{$similarProduct->in_v1_mrp}}</small></del>
                                 @endif
                                 <div class="main-btn-wrap">
                                    <a href="{{ route('productList.view', [$similarProduct->category->url_key, $similarProduct->subcategory->url_key, $similarProduct->url_key]) }}" class="main-btn"><i class="flaticon-shopping-cart"></i> Add To Cart</a>
                                 </div>
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