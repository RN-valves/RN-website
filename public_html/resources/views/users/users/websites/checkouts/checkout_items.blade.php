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
               {{-- <span class="cutprice"><del>₹{{$mrp}}</del></span> --}}
            </div>
            <div class="mini_cart_actions d-flex">
               <div class="prosize">Size: <b>{{ $item->options->size??'' }}</b></div>
               <div class="prosize">Qty: <b>{{$item->qty}}</b></div>
            </div>
         </div>
      </div>
      <div class="cart_pro_thunbxx">
         <a href="{{ route('productList', $getSingleProId->url_key) }}">
         <img class="" src="{{ url($getSingleProId->image??'') }}" alt="{{ $getSingleProId->name??'' }}">
         </a>
      </div>
   </div>
</div>
<!--item end-->
@endforeach