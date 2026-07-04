<?php 
   $CartItems = \Cart::content();
   ?>
<?php $total_price = 0; $mrp_price=0; ?>
<div class="col-md-7 col-lg-8">
   @if(Session::has('emptyCart'))
   <p class="alert alert-success">
      {{Session::get('emptyCart')}}
   </p>
   @endif
   @if(Session::has('success'))
   <p class="alert alert-success">
      {{Session::get('success')}}
   </p>
   @endif
   <h4 class="p-2 bg-light">
      <b>My Cart</b> 
      {{ \Cart::content()->count() }} Item(s)
      @if(\Cart::count()>0)
      <a href="{{ route('cartEmpty') }}" class="float-right border px-2">
         <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25" height="25" viewBox="0 0 48 48">
            <path fill="#F44336" d="M21.5 4.5H26.501V43.5H21.5z" transform="rotate(45.001 24 24)"></path>
            <path fill="#F44336" d="M21.5 4.5H26.5V43.501H21.5z" transform="rotate(135.008 24 24)"></path>
         </svg>
         <small>Clear</small>
      </a>
      @endif
   </h4>
   @foreach(\Cart::content() as $key => $item)
   <?php  $getSingleProId = App\Models\Product::getSingleProId($item->id); ?> 
   <!--item-->
   <div class="cart_item_grid">
      <div class="inside_d_flex">
         <div class="page_cart_info">
            <div class="mini_cart_body">
               <h5 class="mini_cart_title mg__0 mb__5"><a href="{{ route('productList', $getSingleProId->url_key) }}">{{ substr($item->name??'', 0, 55) }}..</a>   
                  <span>{{ $item->options->product_code??'' }}</span>
               </h5>
               <div class="common_price_style">
                  ₹{{ $getSingleProId->in_mrp??'' }} 
                  <span class="alrttexttt text-dark">  x {{ $item->qty }} = {{ $getSingleProId->in_mrp * $item->qty }}</span>
                  {{-- <span class="cutprice"><del>₹{{$mrp}}</del></span> --}}
               </div>
               
               {{-- <div class="alrttexttt text-success mb-2" style="margin-top:-10px;">You Saved x {{ $item->qty }} = {{ $getSingleProId->in_mrp * $item->qty }} on this product!</div> --}}
              
               <div class="mini_cart_actions d-flex">
                  <div class="prosize">Size: <b>{{ $item->options->size??'' }}</b></div>
                  <div class="cstm__qty">
                     <input type="text" class="qty" value="{{ $item->qty??'' }}" id="appendedInputButtons" name="quantity" disabled="disabled">
                     <button type="button" class="qty-minus qtyMinus btnItemUpdate" data-cartid="{{$item->rowId}}"><font><i class="fa fa-minus"></i></font></button>
                     <button type="button" class="qty-plus qtyPlus btnItemUpdate" data-cartid="{{$item->rowId}}"><font><i class="fa fa-plus"></i></font></button>
                  </div>
               </div>
            </div>
         </div>
         <div class="cart_pro_thunbxx">
            <a href="{{ route('productList', $getSingleProId->url_key) }}">
            <img class="" src="{{ url($getSingleProId->image??'') }}" alt="{{ $getSingleProId->name??'' }}">
            </a>
         </div>
      </div>
      <div class="crtbtnactionlst">
         <div class="row p_lr_8">
            <div class="col-12 p_lr_8">
               <button href="javascript:;" data-cartid="{{$item->rowId}}" data-proid="{{$getSingleProId->sku_code}}" data-name="{{$getSingleProId->name}}" data-brand="{{$getSingleProId->brand}}" data-category="{{$getSingleProId->category->name}}" data-subcategory="{{$getSingleProId->subcategory->name}}" data-color="{{$getSingleProId->color_name}}" data-price="{{$getSingleProId->in_mrp}}" data-quantity="{{$item->qty}}" class="btn btn-block removeCartItem">
               <i class="fa fa-trash"></i>Remove</button>
            </div>
            {{-- 
            <div class="col-6 p_lr_8 pipline">
               <a href="#" class="btn btn-block"><i class="fa fa-heart"></i>Move to Wishlist</a>
            </div>
            --}}
         </div>
      </div>
   </div>
   <!--item end-->
   @endforeach
</div>
<!-----right side--->
<div class="col-md-5 col-lg-4">
   <div style="position: sticky; top: 150px;">

   @if(\Cart::content()->count() > 0 && $nextDiscount)
            <p class="discount-message">
               <b>Add products worth ₹ {{ $nextDiscount->start_value - $totalPrice }} more to unlock a discount of {{ $nextDiscount->value }}%!</b>
            </p>
   @endif
      
      @php
      $getActiveSlabDiscountCode = App\Models\Discount::getActiveSlabDiscountCode();
      @endphp
      @if(!empty($getActiveSlabDiscountCode))
         <div class="alert alert-success">You are eligible 
            <strong class="text-success">@if($getActiveSlabDiscountCode->type=="Percent") {{ $getActiveSlabDiscountCode->value??'' }} % @else ₹{{ $getActiveSlabDiscountCode->value??'' }} @endif OFF</strong> 
            <span class="badge badge-warning rounded-0" style="font-size:15px;">{{ $getActiveSlabDiscountCode->name??'' }}</span>
         </div>
      @endif
      <div class="distexbox">
         <div>Get Discount with using coupon code!</div>
      </div>
      <div class="mscrt">
         <div class="d-flex">
            <input class="form-control" type="text" value="{{ $getActiveSlabDiscountCode->name??'' }}" placeholder="Enter Coupon code" id="getDiscountCode">
            <span class="btn btn-info" type="#" id="ApplyDiscount">Apply</span>
         </div>
         <span class="text-danger" id="coupon_error"></span>
      </div>
      <div class="price__items">
         <div class="crttitle">PRICE SUMMARY</div>
         <!-- <div class="text-center alert alert-dark p-1 rounded-0" style="margin-top: -15px;"><span class="">Discount and shipping calculated at checkout </span> -->
         </div>
         <div class="crtlsttext"><span>Total MRP (Inc. of Taxes)</span><strong> ₹ {{ \Cart::subtotal() }} </strong></div>
         {{-- 
         <div class="crtlsttext"><span>Delivery Fee</span><span style="color: rgb(9, 181, 9);"> FREE</span></div>
         --}}
         <div class="crtlsttext"><span>Shipping Fee</span><span> ₹ 00 </span></div>
         <div class="crtlsttext"><span>Cart Discount</span><span class="getDiscountAmount" style="color: rgb(9, 181, 9);"> - ₹ 0.00</span></div>
         <div class="crtlsttext"><span>Subtotal</span><span> <b class="getTotalAmount">₹ {{ \Cart::subtotal() }} </b> </span></div>
         <div class="greenbadeg DiscountSuccess">You are saving ₹ <b class="getDiscountAmount">0.00</b> on this order</div>
         <div class="total__amount">
            <div class="row p_lr_8">
               <div class="col-5 p_lr_8">
                  <div style="font-weight: 700; color: #000000; font-size: 22px;line-height: 22px;" class="getTotalAmount" id="getTotalAmount">₹ {{ \Cart::priceTotal() }}</div>
                  <div style="font-size: 13px;">Total Amount</div>
               </div>
               <input type="hidden" name="shipping_amount" id="getShippingCharge" value="0">
               <input type="hidden" name="total_amount" id="getFinalAmount" value="">
               <input type="hidden" name="encrypt_amount" id="getEncryptedAmount" value="">
               <input type="hidden" name="encrypt_discode" id="getEncryptedDisCode" value="">
               <div class="col-7 p_lr_8"><a class="checkout_fixedbtn" href="#">
                  Checkout Securely <i class="czi-card flaticon-next font-size-lg mr-2"></i></a>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Mobile Button -->
   <div class="mobile_section mt-4">
      <div class="row p_lr_8">
         <div class="col-5 p_lr_8">
            <b class="text-heading getTotalAmount" id="getTotalAmountMobile">₹ {{ \Cart::priceTotal() }}</b>
            <div class="font-size-sm">Total Amount</div>
         </div>
         @if(auth()->check())
         <div class="col-7 p_lr_8"><a class="checkout_fixedbtn" href="{{ route('CartCheckout') }}">
            Checkout Securely </a>
         </div>
         @else
         <div class="col-7 p_lr_8"><a class="checkout_fixedbtn" data-toggle="modal" data-target="#loginModal" href="#">
            Checkout Securely </a>
         </div>
         @endif
      </div>
   </div>
   <!--  End Mobile Button  -->
</div>
<!-----right side--->


{{-- 
==================================================================================
ADD THIS SCRIPT AT THE VERY BOTTOM OF YOUR CART PAGE
This adds GA4 tracking WITHOUT removing any of your existing code
==================================================================================
--}}

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // ===================================================================
    // EVENT: view_cart - Fires when cart page loads
    // ===================================================================
    
    const cartItems = [
        @foreach(\Cart::content() as $item)
        @php
            $getSingleProId = App\Models\Product::getSingleProId($item->id);
        @endphp
        {
            item_id: "{{ $getSingleProId->article ?? $getSingleProId->sku_code ?? $item->id }}",
            item_name: "{{ $getSingleProId->name ?? $item->name }}",
            affiliation: "RN Valves & Faucets",
            item_brand: "{{ $getSingleProId->brand ?? 'RN Valves' }}",
            item_category: "{{ $getSingleProId->category->name ?? '' }}",
            item_category2: "{{ $getSingleProId->subcategory->name ?? '' }}",
            item_category3: "{{ $item->options->size ?? '' }}",
            item_variant: "{{ $getSingleProId->color_name ?? '' }}",
            price: {{ $getSingleProId->in_mrp ?? 0 }},
            quantity: {{ $item->qty ?? 1 }}
        }@if(!$loop->last),@endif
        @endforeach
    ];
    
    // Fire view_cart event
    if (typeof gtag !== 'undefined' && cartItems.length > 0) {
        const cartValue = cartItems.reduce((total, item) => total + (item.price * item.quantity), 0);
        
        gtag("event", "view_cart", {
            currency: "INR",
            value: cartValue,
            items: cartItems
        });
        
        console.log('✅ GA4 view_cart fired');
        console.log('   Items in cart:', cartItems.length);
        console.log('   Cart value: ₹' + cartValue);
    }
    
    
    // ===================================================================
    // EVENT: remove_from_cart - When user removes item from cart
    // ===================================================================
    
    $(document).on('click', '.removeCartItem', function(e) {
        const $button = $(this);
        const cartId = $button.data('cartid');
        const productId = $button.data('proid');
        const productName = $button.data('name');
        const productBrand = $button.data('brand');
        const productCategory = $button.data('category');
        const productSubcategory = $button.data('subcategory');
        const productColor = $button.data('color');
        const productPrice = parseFloat($button.data('price'));
        const productQuantity = parseInt($button.data('quantity'));
        
        // Fire remove_from_cart event
        if (typeof gtag !== 'undefined') {
            gtag("event", "remove_from_cart", {
                currency: "INR",
                value: productPrice * productQuantity,
                items: [{
                    item_id: productId,
                    item_name: productName,
                    affiliation: "RN Valves & Faucets",
                    item_brand: productBrand,
                    item_category: productCategory,
                    item_category2: productSubcategory,
                    item_variant: productColor,
                    price: productPrice,
                    quantity: productQuantity
                }]
            });
            
            console.log('🗑️ GA4 remove_from_cart fired:', productName);
            console.log('   Quantity:', productQuantity);
            console.log('   Value removed: ₹' + (productPrice * productQuantity));
        }
    });
    
    
    // ===================================================================
    // BONUS: Track Coupon Application
    // ===================================================================
    
    $('#ApplyDiscount').on('click', function() {
        const couponCode = $('#getDiscountCode').val();
        
        if (couponCode && typeof gtag !== 'undefined') {
            gtag("event", "apply_coupon", {
                event_category: "Ecommerce",
                event_label: couponCode,
                coupon_code: couponCode
            });
            
            console.log('🎟️ Coupon applied:', couponCode);
        }
    });
    
    
    // ===================================================================
    // BONUS: Track Checkout Button Click
    // ===================================================================
    
    $('.checkout_fixedbtn').on('click', function(e) {
        // Get current cart value from page or calculate
        const cartValueText = $('.getTotalAmount').first().text().replace('₹', '').replace(',', '').trim();
        const cartValue = parseFloat(cartValueText) || {{ \Cart::priceTotal(2, '.', '') }};
        
        if (typeof gtag !== 'undefined' && cartItems.length > 0) {
            gtag("event", "begin_checkout", {
                currency: "INR",
                value: cartValue,
                items: cartItems
            });
            
            console.log('🛒 GA4 begin_checkout fired');
            console.log('   Proceeding to checkout with value: ₹' + cartValue);
        }
    });
    
    
    // ===================================================================
    // BONUS: Track Quantity Update (Plus/Minus buttons)
    // ===================================================================
    
    $('.btnItemUpdate').on('click', function() {
        const cartId = $(this).data('cartid');
        const action = $(this).hasClass('qtyPlus') ? 'increase' : 'decrease';
        
        console.log('🔢 Quantity ' + action + 'd for cart item:', cartId);
    });
    
});
</script>