<div class="col-lg-6">
   <!--Product Description-->
   <div class="product-description pl-lg-4">
      <form method="POST" action="{{ route('addToCart') }}">
         @csrf
         <h5>   {{ $getSingleProduct->category->name ?? '' }} | {{$getSingleProduct->subcategory->name??''}}</h5>
         <h1 class="title" style="margin:0px!important;">
         {{$getSingleProduct['name']??''}}
         </h1>
         <p class="title pt-2">Article : {{$getSingleProduct['article']??''}}</p>
         <span id="appendProductPriceItem">
            <div class="common-price-style">
               ₹ {{$getSingleProduct['in_mrp']}}
               @if($getSingleProduct->in_v1_mrp>$getSingleProduct['in_mrp'])
               <span class="cutprice">
                    <del>₹ {{$getSingleProduct['in_v1_mrp']}}</del>
               </span>
               <span class="text-success">{{(ceil(($getSingleProduct->in_v1_mrp - $getSingleProduct->in_mrp)/$getSingleProduct->in_v1_mrp*100))}}% </span>OFF</span>
               @endif

               {{-- start if buy opions --}}
               @if(!empty($getSingleProduct['productAttribute']['amazon_link']??'') || !empty($getSingleProduct['productAttribute']['flipkart_link']??''))
               <div class="pt-3">
                  <p class="product-meta-name" style="font-size:15px!important;font-weight: 700;">Buy Options </p>
                  <div class="pt-2 mb-3">
                     @if(!empty($getSingleProduct['productAttribute']['flipkart_link']))
                     <a href="javascript:void(0);">
                     <img src="{{ url('users/images/flipkart.png') }}" width="150" class="img-thumbnail p-2">
                     </a>
                     @endif
                     @if(!empty($getSingleProduct['productAttribute']['amazon_link']))
                     <a href="javascript:void(0);">
                     <img src="{{ url('users/images/amazon.png') }}" width="150" class="img-thumbnail p-2">
                     </a>
                     @endif
                  </div>
               </div>
               @endif
               {{-- end if buy opions --}}
            </div>
            <div class="proshortdata">
               @if($getSingleProduct->productAttribute->inner_pcs>1) 
               <div class="product-meta">
                  <span class="product-meta-name">Product pack of : </span>
                  <span class="name">
                    {{$getSingleProduct->productAttribute->inner_pcs}} Pcs 
                    {{--<span class="text-dark font-weight-bold">[</span> 
                    <span class="text-dark">₹{{$getSingleProduct->in_mrp*$getSingleProduct->productAttribute->inner_pcs}} </span>
                    <span class="text-dark font-weight-bold">]</span> --}}
                  </span>
               </div>
               @endif
               @if($getSingleProduct['packaging_name'] == 'Box')
               <div class="product-meta">
                  <span class="product-meta-name">Packaging :</span>
                  <span class="name text-info"><strong>{{$getSingleProduct['packaging_name']}}</strong></span>
               </div> 
               @endif
               <div class="product-meta">
                  <span class="product-meta-name">Availability :</span>
                  @if($getSingleProduct->productAttribute->stock_pcs>0)
                  <span class="name text-success"><b>In Stock</b></span>
                  @else
                  <h3><strong>Sold Out</strong> <br> <small class="text-danger" style="font-size: 12px;">This item is currently out of stock</small></h3>
                  @endif
               </div>
              
               <div class="product-meta">
                  <span class="product-meta-name">Product Code :</span>
                  <span class="name"><b>{{$getSingleProduct['sku_code']??''}}</b></span>
               </div>
               <div class="product-meta">
                  <span class="product-meta-name">Category :</span>
                  <span class="name"><a href="{{route('productList', $getSingleProduct['subcategory'])}}" class="text-info"><b>{{$getSingleProduct['subcategory']->name??''}}</b></a></span>
               </div>
               <div class="product-meta">
                  <span class="product-meta-name">Product Size :</span>
                  <span class="name"><b>{{$getSingleProduct['size']??''}}</b></span>
               </div>
              
               @include('users.websites.commons.discount_popup')
             {{--  @if($getSingleProduct->bullets->count()>0)
               <ul>
                  @foreach($getSingleProduct->bullets??'' as $bullet)
                  <li>{{ $bullet->name??'' }}</li>
                  @endforeach
               </ul>
               @endif --}}
            {{--   <div style="display: flex; flex-direction: column; gap: 10px; margin-top:10px;">
                  @if($getSingleProduct->productAttribute->residential_warranty > 0)
                  <div style="background: #f8f9fa; padding: 15px; border-left: 5px solid #007BFF;">
                      <b>🏡 Residential Warranty</b> - {{$getSingleProduct->productAttribute->residential_warranty}} Year
                  </div>
                  @endif
                  @if($getSingleProduct->productAttribute->commercial_warranty > 0)
                  <div style="background: #f8f9fa; padding: 15px; border-left: 5px solid #28A745;">
                      <b>🏢 Commercial Warranty</b> - {{$getSingleProduct->productAttribute->commercial_warranty}} Year
                  </div>
                  @endif
               </div>
            </div> --}}
         </span>
    <!---packaging-->
         <div class="mb-4">
            @if($packagingGroups->count()>0)
            <div class="size_heaidng"><span>Available Packaging</span></div>
            <div class="btn-group btn-group-toggle size_button" data-toggle="buttons">
               @foreach($packagingGroups??'' as $pack)
               <a href="{{ route('productList.view', [$getSingleProduct->category->url_key, $getSingleProduct->subcategory->url_key, $pack]) }}"> 
                  <label class="btn btn-secondary mt-2" width="100%">
                     <div class="size_name">{{$pack['sku_code']??''}}</div>
                     <div class="size_name">{{$pack['packaging_name']??''}}</div>
                     <div class="s_price text-success">₹ {{ $pack['in_mrp']??0 }}</div>
                  </label> 
               </a>
              
               @endforeach
            </div>
            @endif
         </div>

         <!---color-->
         <div class="mb-2">
            <div class="size_heaidng"><span>Color Name:</span> {{$getSingleProduct['color_name']??''}}</div>
            @if($colorGroups->count()>0)
            <div class="row">
               @foreach($colorGroups??'' as $color)
               <div class="col-lg-1 col-sm-2 col-2 pr-0 mr-0 mb-2">
                  <div class="border">
                     <a href="{{ route('productList.view', [$getSingleProduct->category->url_key, $getSingleProduct->subcategory->url_key, $color]) }}" id="{{$color['color_name']??''}}" title="{{$color['color_name']??''}}" class="{{$url==route('productList',$color)?'active':''}}">
                        <img src="{{ $color['image']??'' }}" width="100%">
                     </a>
                  </div>
               </div>
               @endforeach
            </div>
            {{-- <div class="color-list style-02" style="border-bottom: none; margin-bottom: 0px;">
               <ul class="color-list-row">
                  @foreach($colorGroups??'' as $color)
                  <li class="list-item pr-2">
                     <a href="{{route('productList',$color)}}" id="{{$color['color_name']??''}}" title="{{$color['color_name']??''}}" class="{{$url==route('productList',$color)?'active':''}}">
                        <img src="{{ $color['color_icon']??'' }}" width="100%" class="mb-2">
                     </a>
                  </li>
                  @endforeach
               </ul>
            </div> --}}
            @endif
         </div>
         <!---color-->
         <div class="mb-4">
            @if($sizeGroups->count()>1)
            <div class="size_heaidng"><span>Available Size</span></div>
            <div class="btn-group btn-group-toggle size_button" data-toggle="buttons">
               @foreach($sizeGroups??'' as $sizeGroup)
               @if($sizeGroup->productAttribute->stock_pcs>0)
               <label class="btn btn-secondary mt-2" width="100%">
                  <input type="radio" name="product_id" value="{{ $sizeGroup['id']??'' }}" autocomplete="off" data-price="{{ $sizeGroup['in_mrp']??0 }}" class="getSizePrice" product-id="{{ $sizeGroup['id']??'' }}" class="@error('product_id') is-invalid text-danger @enderror" required>
                  <div class="size_name">{{$sizeGroup['sku_code']??''}}</div>
                  <div class="size_name">{{$sizeGroup['size']??''}}</div>
                  <div class="s_price">₹ {{ $sizeGroup['in_mrp']??0 }}</div>
               </label>
               <x-input-error class="mt-2 text-danger" :messages="$errors->get('product_id')" />
               @else
               <label class="btn btn-secondary not_allowed">
                  <input type="radio" name="size" value="{{$sizeGroup['size']??''}}" autocomplete="off" class="getPrice" product-id="{{$sizeGroup['id']??''}}" disabled="">
                  <div class="size_name">{{$sizeGroup['sku_code']??''}}</div>
                  <div class="size_name">{{$sizeGroup['size']??''}}</div>
                  <div class="s_price">₹ {{ $sizeGroup['in_mrp']??0 }}</div>
               </label>
               @endif
               @endforeach
            </div>
            @else
            <input type="hidden" name="product_id" value="{{$getSingleProduct['id']??''}}">
            @endif
         </div>
         <div class="mb-4">
            @if($getSingleProduct->is_full_turn)
            <div class="size_heaidng"><span>Available In</span></div>
            <div class="btn-group btn-group-toggle size_button" data-toggle="buttons">
               <label class="btn btn-secondary mt-2" width="100%">
                  <input type="radio" name="sku_code" value="{{ $getSingleProduct->sku_code }}" autocomplete="off" class=""  class="@error('sku_code') is-invalid text-danger @enderror" required>
                  <div class="size_name">{{$getSingleProduct->sku_code}}</div>
                  <div class="size_name">Half Turn</div>  
               </label>
               <label class="btn btn-secondary mt-2" width="100%">
                  <input type="radio" name="sku_code" value="{{ $getSingleProduct->full_turn_code }}" autocomplete="off" class=""  class="@error('sku_code') is-invalid text-danger @enderror" required>
                  <div class="size_name">{{$getSingleProduct->full_turn_code}}</div>
                  <div class="size_name">Full Turn</div>    
               </label>
            </div>
            @else
            
            <input type="hidden" name="sku_code" value="0" autocomplete="off">
            @endif
         </div>
         
         {{-- <div class="padding-bottom-15">
            <p>{!! $getSingleProduct['content']['content']??'' !!}</p>
         </div> --}}
        
         
         @if($getSingleProduct->productAttribute->stock_pcs>0)
         
         
         <div class="cart-wrap padding-top-0 padding-bottom-10" style="display: flex!important;">
            <input type="number" value="1" name="quantity" id="quantity" class="qty" min="1">
            <div class="main-btn-wrap">
               <button class="addtocartbtn" @if($getSingleProduct->productAttribute->stock_pcs>0) @else disabled="" @endif type="button"
               data-id="{{ $getSingleProduct->id }}" 
               data-name="{{ $getSingleProduct->name }}" 
               data-price="{{ $getSingleProduct->in_mrp }}" 
               data-brand="{{ $getSingleProduct->brand }}" 
               data-category="{{ $getSingleProduct->category->name }}"
               data-subcategory="{{ $getSingleProduct->subcategory->name }}"  
               data-color="{{ $getSingleProduct->color_name }}"   
               ><i class="flaticon-shopping-cart"></i> Add To Cart</button>

               <input type="hidden" name="buy_now" value="1">
               @if(auth()->check())
               <button type="submit" class="buy-button">
                 <i class="flaticon-shopping-cart"></i> Buy Now
               </button>
               @else
               <button type="button" class="buy-button" data-toggle="modal" data-target="#loginModal">
                 <i class="flaticon-shopping-cart"></i> Buy Now
               </button>
               @endif

            </div>
         </div>
         @endif

         <div id="discountedText"> 
         @if(\Cart::content()->count() > 0 && $nextDiscount)
            <p class="discount-message">
               <b>Add products worth ₹ {{ $nextDiscount->start_value - $totalPrice }} more to unlock a discount of {{ $nextDiscount->value }}%!</b>
            </p>
         @endif
         </div>  
         <!--// Cart Wrap-->
         {{-- @if(!empty($getCategoryCoupon))
         <div class="row">
            <div class="col-lg-6">
               <div class="secure__label"><i class="fa fa-gift"></i> &nbsp; {{$getCategoryCoupon['coupon_code']}} <span>Use coupon get @if($getCategoryCoupon['amount_type']=='Percentage') 
               {{$getCategoryCoupon['amount']}}% @else ₹ {{$getCategoryCoupon['amount']}} @endif</span></div>
            </div>
         </div>
         @endif --}}
      </form>
      <div class="widget widget_search">
         <div class="search-form">
            <div class="form-group">
               <input type="text" class="form-control" maxlength="6" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');" id="pincode" name="pincode" placeholder="Enter Delivery Pincode">
            </div>
            <button class="submit-btn" type="submit" id="checkPincode">Check</button>
         </div>
         <div class="pinsbtext" id="pincode_message">Enter pincode for exact delivery days / charges</div>
      </div>
      <!--// Search-->
   </div>
</div>