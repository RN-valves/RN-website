<div class="common-price-style">
   ₹ {{$getProduct['selling_price']}} 
   <span class="cutprice">
   <del>₹ {{$getProduct['mrp_price']}}</del>
   </span>
   <span class="text-success">{{(ceil(($getProduct->mrp_price - $getProduct->selling_price)/$getProduct->mrp_price*100))}}% OFF</span>
</div>
<!--// Price-->
<div class="proshortdata">
   @if($getProduct['product_pcs'])
   <?php
      $product_pcsPrice = $getProduct['selling_price']/$getProduct['product_pcs'];
      $product_pcsPrice = round($product_pcsPrice);
      $product_code = $getProduct['product_code'];
      $product_pcs = $getProduct['product_pcs'];
      ?>
   @endif
   @if($product_pcs>1) 
   <div class="product-meta">
      <span class="product-meta-name">Product pack of : </span>
      <span class="name">
      {{$product_pcs}} Pcs <span class="text-dark font-weight-bold">[</span> ₹{{$product_pcsPrice}}/Pc <span class="text-dark font-weight-bold">]</span>
      </span>
   </div>
   @endif
   <div class="product-meta">
      <span class="product-meta-name">Availability :</span>
      @if($totalStock>0)
      <span class="name text-success">In Stock</span>
      @else
      <span class="name outofstock">Out of Stock</span>
      @endif
   </div>
   <div class="product-meta">
      <span class="product-meta-name">Product Code :</span>
      <span class="name">{{$product_code}}</span>
   </div>
   <div class="product-meta">
      <span class="product-meta-name">Category :</span>
      <span class="name"><a href="{{route('listing', $getProductCategory)}}" class="text-info">{{$getProductCategory['title']}}</a></span>
   </div>
</div>