@if($productsList->count()>0)
@foreach($productsList as $product)
<!-- Grid List Column-->
<div class="grid-list-column-item" data-product-id="{{ $product->id }}">
   <div class="thumb">
      <a href="{{ route('productList.view', [$product->category->url_key, $product->subcategory->url_key, $product->url_key]) }}">
         <img src="{{ url($product->image??'') }}" alt="{{ $product['name']??'' }}" loading="lazy" title="{{ $product['name']??'' }}">
      </a>
   </div>
   <div class="contnt_bxxx">
      <!-- <ul>
         <li>{{ $getSingleSubCategory->category->name??'' }}</li>
      </ul> -->
      <a href="{{ route('productList.view', [$product->category->url_key, $product->subcategory->url_key, $product->url_key]) }}">
         <h6>{{ $product->category->name ??'' }} | {{ $product->subcategory->name ??'' }}</h6>
      </a>
      <a href="{{ route('productList.view', [$product->category->url_key, $product->subcategory->url_key, $product->url_key]) }}">
         <h5 class="title">{{ $product['name']??'' }}</h5>
      </a>
      <div class="prdct_code">Product Code : <strong>{{ $product['article']??'' }}</strong></div>
      <div class="prdct_code">Product Size : <strong>{{ $product['size']??'' }}</strong></div>
      {{--<div class="prdct_code">Product Material : <strong>{{ $product['material']??'' }}</strong></div> --}}
      {{-- <div class="prdct_code">MRP : <strong><span>₹</span>{{ $product['in_mrp']??'' }}</strong></div> --}}
      <div class="common-price-style">
         <span>₹</span>{{ $product['in_mrp']??'' }}
         @if($product->in_v1_mrp>$product['in_mrp'])
         <del><small>₹{{$product->in_v1_mrp}}</small></del>
         @endif
         <!--amazon and flipkart link start-->
         <div class="amaflipbox">
            @if(!empty($product['productAttribute']['flipkart_link']))
            <a href="javascript:void(0);"><img src="{{asset('icons/flipkart.png')}}" alt="RN Valves & Faucets - Flipkart" title="RN Valves & Faucets - Flipkart" /></a>
            @endif
            @if(!empty($product['productAttribute']['amazon_link']))
            <a href="javascript:void(0);"><img src="{{asset('icons/amazon.png')}}" alt="RN Valves & Faucets - Amazon" title="RN Valves & Faucets - Amazon" /></a>
            @endif
         </div>
         <!--amazon and flipkart link end-->
      </div>
      <div class="main-btn-wrap" style="display:none!important;">
         <a href="{{ route('productList.view', [$product->category->url_key, $product->subcategory->url_key, $product->url_key]) }}" class="main-btn"><i class="flaticon-shopping-cart"></i> Add To Cart</a>
      </div>
   </div>
</div>
<!--// Grid List Column-->
@endforeach
@endif
