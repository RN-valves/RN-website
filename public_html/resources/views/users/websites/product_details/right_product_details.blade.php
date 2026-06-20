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
                     <a href="{{ $getSingleProduct['productAttribute']['flipkart_link'] }}" target="_blank" class="external-store-link" data-platform="Flipkart">
                     <img src="{{ url('users/images/flipkart.png') }}" width="150" class="img-thumbnail p-2" alt="RN Valves & Faucets - Flipkart">
                     </a>
                     @endif
                     @if(!empty($getSingleProduct['productAttribute']['amazon_link']))
                     <a href="{{ $getSingleProduct['productAttribute']['amazon_link'] }}" target="_blank" class="external-store-link" data-platform="Amazon">
                     <img src="{{ url('users/images/amazon.png') }}" width="150" class="img-thumbnail p-2" alt="RN Valves & Faucets - Amazon">
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
               <div class="product-meta" id="stock_status_container">
                  <span class="product-meta-name">Availability :</span>
                  @if($getSingleProduct->productAttribute->stock_pcs>0)
                  <span class="name" style="color: #10b981; font-weight: 700; background: #ecfdf5; padding: 2px 8px; border-radius: 4px;">In Stock</span>
                  @else
                  <h3 style="margin-top: 5px;"><strong style="color: #ef4444;">Sold Out</strong> <br> <small style="color: #ef4444; font-size: 12px; font-weight: 500;">This item is currently out of stock</small></h3>
                  @endif
               </div>
              
               <div class="product-meta">
                  <span class="product-meta-name">Product Code :</span>
                  <span class="name" id="product_code_display" style="font-family: monospace; color: #475569; font-weight: 600; background: #f1f5f9; padding: 2px 8px; border-radius: 4px;">{{$getSingleProduct['sku_code']??''}}</span>
               </div>
               <div class="product-meta">
                  <span class="product-meta-name">Category :</span>
                  <span class="name"><a href="{{route('productList', $getSingleProduct['subcategory'])}}" style="color: #00a0e3; font-weight: 600; text-decoration: underline; text-underline-offset: 4px; border-radius: 4px; background: #f0f9ff; padding: 2px 8px;">{{$getSingleProduct['subcategory']->name??''}}</a></span>
               </div>
               <div class="product-meta">
                  <span class="product-meta-name">Product Size :</span>
                  <span class="name" id="product_size_display" style="color: #334155; font-weight: 600; background: #f8fafc; border: 1px solid #e2e8f0; padding: 2px 8px; border-radius: 4px;">{{$getSingleProduct['size']??''}}</span>
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
               <a href="{{ route('productList.view', [$getSingleProduct->category->url_key, $getSingleProduct->subcategory->url_key, $pack]) }}" class="packaging-link" data-packaging="{{$pack['packaging_name']??''}}" data-price="{{$pack['in_mrp']??0}}"> 
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
                     <a href="{{ route('productList.view', [$getSingleProduct->category->url_key, $getSingleProduct->subcategory->url_key, $color]) }}" id="{{$color['color_name']??''}}" title="{{$color['color_name']??''}}" class="color-link {{$url==route('productList',$color)?'active':''}}" data-color="{{$color['color_name']??''}}">
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
                  <input type="radio" name="product_id" value="{{ $sizeGroup['id']??'' }}" autocomplete="off" data-price="{{ $sizeGroup['in_mrp']??0 }}" data-v1-mrp="{{ $sizeGroup['in_v1_mrp']??0 }}" data-size="{{$sizeGroup['size']??''}}" data-sku="{{$sizeGroup['sku_code']??''}}" data-stock-status="In Stock" class="getSizePrice" product-id="{{ $sizeGroup['id']??'' }}" class="@error('product_id') is-invalid text-danger @enderror" required>
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
                  <input type="radio" name="sku_code" value="{{ $getSingleProduct->sku_code }}" autocomplete="off" class="turn-selection" data-turn="Half Turn" class="@error('sku_code') is-invalid text-danger @enderror" required>
                  <div class="size_name">{{$getSingleProduct->sku_code}}</div>
                  <div class="size_name">Half Turn</div>  
               </label>
               <label class="btn btn-secondary mt-2" width="100%">
                  <input type="radio" name="sku_code" value="{{ $getSingleProduct->full_turn_code }}" autocomplete="off" class="turn-selection" data-turn="Full Turn" class="@error('sku_code') is-invalid text-danger @enderror" required>
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
               data-brand="{{ $getSingleProduct->brand ?? 'RN Valves' }}" 
               data-category="{{ $getSingleProduct->category->name }}"
               data-subcategory="{{ $getSingleProduct->subcategory->name }}"  
               data-color="{{ $getSingleProduct->color_name }}"
               data-article="{{ $getSingleProduct->article }}"   
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

      <!-- ✅ Premium Product USP Section -->
      <div class="rn-usp-section">
         <style>
            .rn-usp-section {
               margin-top: 24px;
               padding: 20px 18px;
               background: linear-gradient(135deg, #f8fbff 0%, #f0f6ff 100%);
               border: 1px solid #ddeaf8;
               border-radius: 16px;
               position: relative;
               overflow: hidden;
            }
            .rn-usp-section::before {
               content: '';
               position: absolute;
               top: -30px;
               right: -30px;
               width: 120px;
               height: 120px;
               border-radius: 50%;
               background: radial-gradient(circle, rgba(0,160,227,0.08) 0%, transparent 70%);
               pointer-events: none;
            }
            .rn-usp-header {
               display: flex;
               align-items: center;
               gap: 8px;
               margin-bottom: 16px;
            }
            .rn-usp-header-line {
               flex: 1;
               height: 1px;
               background: linear-gradient(to right, #d0e4f5, transparent);
            }
            .rn-usp-header-text {
               font-size: 10px;
               font-weight: 800;
               color: #003366;
               letter-spacing: 2px;
               text-transform: uppercase;
               white-space: nowrap;
               font-family: 'Neo Sans', 'Neo Sans Std', sans-serif;
            }
            .rn-usp-grid {
               display: grid;
               grid-template-columns: repeat(4, 1fr);
               gap: 12px 8px;
            }
            .rn-usp-item {
               display: flex;
               flex-direction: column;
               align-items: center;
               text-align: center;
               gap: 8px;
               cursor: default;
            }
            .rn-usp-icon {
               width: 54px;
               height: 54px;
               border-radius: 14px;
               background: linear-gradient(135deg, #003366 0%, #00a0e3 100%);
               display: flex;
               align-items: center;
               justify-content: center;
               font-size: 20px;
               color: #ffffff;
               transition: all 0.35s cubic-bezier(0.2, 0.8, 0.2, 1);
               box-shadow: 0 4px 12px rgba(0, 51, 102, 0.18);
               flex-shrink: 0;
            }
            .rn-usp-item:hover .rn-usp-icon {
               transform: translateY(-4px) scale(1.05);
               box-shadow: 0 10px 24px rgba(0, 51, 102, 0.28);
               background: linear-gradient(135deg, #00a0e3 0%, #003366 100%);
            }
            .rn-usp-label {
               font-size: 10px;
               color: #334155;
               font-weight: 600;
               line-height: 1.4;
               font-family: 'Neo Sans', 'Neo Sans Std', sans-serif;
            }
            @media (max-width: 576px) {
               .rn-usp-grid { grid-template-columns: repeat(3, 1fr); gap: 10px 6px; }
               .rn-usp-icon { width: 46px; height: 46px; font-size: 17px; border-radius: 12px; }
            }
         </style>

         <div class="rn-usp-header">
            <div class="rn-usp-header-line"></div>
            <div class="rn-usp-header-text">✦ Why Choose RN Valves</div>
            <div class="rn-usp-header-line" style="background: linear-gradient(to left, #d0e4f5, transparent);"></div>
         </div>

         <div class="rn-usp-grid">
            <div class="rn-usp-item">
               <div class="rn-usp-icon"><i class="fas fa-redo-alt"></i></div>
               <div class="rn-usp-label">3 Lakh+<br>Usage Tested</div>
            </div>
            <div class="rn-usp-item">
               <div class="rn-usp-icon"><i class="fas fa-cloud-sun"></i></div>
               <div class="rn-usp-label">All Weather<br>Performance</div>
            </div>
            <div class="rn-usp-item">
               <div class="rn-usp-icon"><i class="fas fa-sun"></i></div>
               <div class="rn-usp-label">UV &amp; Fade<br>Resistant</div>
            </div>
            <div class="rn-usp-item">
               <div class="rn-usp-icon"><i class="fas fa-weight-hanging"></i></div>
               <div class="rn-usp-label">100kg Weight<br>Tested</div>
            </div>
            <div class="rn-usp-item">
               <div class="rn-usp-icon"><i class="fas fa-tint-slash"></i></div>
               <div class="rn-usp-label">Hard Water<br>Resistant</div>
            </div>
            <div class="rn-usp-item">
               <div class="rn-usp-icon"><i class="fas fa-shield-alt"></i></div>
               <div class="rn-usp-label">100%<br>Rust-Proof</div>
            </div>
            <div class="rn-usp-item">
               <div class="rn-usp-icon"><i class="fas fa-certificate"></i></div>
               <div class="rn-usp-label">Warranty<br>Included</div>
            </div>
         </div>
      </div>
      <!-- ✅ End USP Section -->

   </div>
</div>

{{-- 
==================================================================================
GA4 ECOMMERCE TRACKING - VARIANT SELECTION & INTERACTIONS
All your commented code is preserved above. Only tracking code added below.
==================================================================================
--}}

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // ===================================================================
    // Track Size Selection
    // ===================================================================
    $('input[name="product_id"]').on('change', function() {
        const size = $(this).data('size') || $(this).closest('label').find('.size_name').eq(1).text().trim();
        const price = $(this).data('price');
        const v1mrp = parseFloat($(this).data('v1-mrp')) || 0;
        const sku = $(this).data('sku');
        const stockStatus = $(this).data('stock-status');
        
        // Update product info elements
        if (sku) {
            $('#product_code_display').text(sku);
        }
        if (size) {
            $('#product_size_display').text(size);
        }
        if (stockStatus) {
            $('#stock_status_container').html(
                '<span class="product-meta-name">Availability :</span>' +
                '<span class="name" style="color: #10b981; font-weight: 700; background: #ecfdf5; padding: 2px 8px; border-radius: 4px;">' + stockStatus + '</span>'
            );
        }

        // Update price DOM element
        if (price) {
            let priceHtml = '₹ ' + price;
            if (v1mrp > price) {
                const discount = Math.ceil(((v1mrp - price) / v1mrp) * 100);
                priceHtml += '\n' +
                    '<span class="cutprice">\n' +
                    '     <del>₹ ' + v1mrp + '</del>\n' +
                    '</span>\n' +
                    '<span class="text-success">' + discount + '% </span>OFF</span>\n';
            }
            $('#appendProductPriceItem .common-price-style').html(priceHtml);
            $('.addtocartbtn').attr('data-price', price); // update add to cart behavior
        }
        
        if (typeof gtag !== 'undefined') {
            gtag("event", "select_item", {
                item_list_id: "size_variants",
                item_list_name: "Size Variants",
                items: [{
                    item_id: "{{ $getSingleProduct->article ?? $getSingleProduct->id }}",
                    item_name: "{{ $getSingleProduct->name ?? '' }}",
                    item_variant: size,
                    price: parseFloat(price)
                }]
            });
            
            console.log('📏 Size selected:', size, '- Price: ₹' + price);
        }
    });
    
    
    // ===================================================================
    // Track Color Selection
    // ===================================================================
    $('.color-link').on('click', function(e) {
        const colorName = $(this).data('color') || $(this).attr('title');
        
        if (typeof gtag !== 'undefined') {
            gtag("event", "select_item", {
                item_list_id: "color_variants",
                item_list_name: "Color Variants",
                items: [{
                    item_id: "{{ $getSingleProduct->article ?? $getSingleProduct->id }}",
                    item_name: "{{ $getSingleProduct->name ?? '' }}",
                    item_variant: colorName,
                    price: {{ $getSingleProduct->in_mrp ?? 0 }}
                }]
            });
            
            console.log('🎨 Color selected:', colorName);
        }
    });
    
    
    // ===================================================================
    // Track Packaging Selection
    // ===================================================================
    $('.packaging-link').on('click', function(e) {
        const packaging = $(this).data('packaging');
        const price = $(this).data('price');
        
        if (typeof gtag !== 'undefined') {
            gtag("event", "select_item", {
                item_list_id: "packaging_variants",
                item_list_name: "Packaging Variants",
                items: [{
                    item_id: "{{ $getSingleProduct->article ?? $getSingleProduct->id }}",
                    item_name: "{{ $getSingleProduct->name ?? '' }}",
                    item_variant: packaging,
                    price: parseFloat(price)
                }]
            });
            
            console.log('📦 Packaging selected:', packaging, '- Price: ₹' + price);
        }
    });
    
    
    // ===================================================================
    // Track Turn Selection (Half/Full)
    // ===================================================================
    $('.turn-selection').on('change', function() {
        const turn = $(this).data('turn');
        
        if (typeof gtag !== 'undefined') {
            gtag("event", "select_item", {
                item_list_id: "turn_variants",
                item_list_name: "Turn Variants",
                items: [{
                    item_id: "{{ $getSingleProduct->article ?? $getSingleProduct->id }}",
                    item_name: "{{ $getSingleProduct->name ?? '' }}",
                    item_variant: turn,
                    price: {{ $getSingleProduct->in_mrp ?? 0 }}
                }]
            });
            
            console.log('🔄 Turn selected:', turn);
        }
    });
    
    
    // ===================================================================
    // Track Buy Now Button
    // ===================================================================
    $('.buy-button').on('click', function() {
        const quantity = parseInt($('#quantity').val()) || 1;
        const price = {{ $getSingleProduct->in_mrp ?? 0 }};
        
        // Get selected size if available
        let selectedSize = '{{ $getSingleProduct->size ?? "" }}';
        const selectedSizeInput = $('input[name="product_id"]:checked');
        if (selectedSizeInput.length > 0) {
            selectedSize = selectedSizeInput.data('size');
        }
        
        if (typeof gtag !== 'undefined') {
            gtag("event", "begin_checkout", {
                currency: "INR",
                value: price * quantity,
                items: [{
                    item_id: "{{ $getSingleProduct->article ?? $getSingleProduct->id }}",
                    item_name: "{{ $getSingleProduct->name ?? '' }}",
                    affiliation: "RN Valves & Faucets",
                    item_brand: "{{ $getSingleProduct->brand ?? 'RN Valves' }}",
                    item_category: "{{ $getSingleProduct->category->name ?? '' }}",
                    item_category2: "{{ $getSingleProduct->subcategory->name ?? '' }}",
                    item_category3: selectedSize,
                    item_variant: "{{ $getSingleProduct->color_name ?? '' }}",
                    price: price,
                    quantity: quantity
                }]
            });
            
            console.log('🛒 Buy Now clicked - Value: ₹' + (price * quantity));
        }
    });
    
    
    // ===================================================================
    // Track External Store Clicks (Amazon/Flipkart)
    // ===================================================================
    $('.external-store-link').on('click', function(e) {
        const platform = $(this).data('platform');
        
        if (typeof gtag !== 'undefined') {
            gtag("event", "select_promotion", {
                creative_name: platform + " Link",
                creative_slot: "product_page",
                promotion_id: platform.toLowerCase(),
                promotion_name: "Buy on " + platform,
                items: [{
                    item_id: "{{ $getSingleProduct->article ?? $getSingleProduct->id }}",
                    item_name: "{{ $getSingleProduct->name ?? '' }}",
                    affiliation: platform,
                    price: {{ $getSingleProduct->in_mrp ?? 0 }}
                }]
            });
            
            console.log('🛍️ External store clicked:', platform);
        }
    });
    
    
    // ===================================================================
    // Track Quantity Changes
    // ===================================================================
    $('#quantity').on('change', function() {
        const quantity = parseInt($(this).val()) || 1;
        console.log('🔢 Quantity changed:', quantity);
    });
    
});
</script>