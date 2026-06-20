@if($productsList->count()>0)
@foreach($productsList as $product)
<!-- Grid List Column-->
<div class="grid-list-column-item" data-product-id="{{ $product->id }}">
      <div class="thumb" style="position: relative;">
         @if(!empty($product->subcategory->name))
         <div style="position: absolute; bottom: 0; left: 0; background: rgba(0, 51, 102, 0.85); backdrop-filter: blur(8px); padding: 6px 14px; border-top-right-radius: 12px; font-size: 0.75rem; font-weight: 600; color: #ffffff; z-index: 5; box-shadow: 2px -2px 10px rgba(0,0,0,0.1); letter-spacing: 0.5px; border-top: 1px solid rgba(255,255,255,0.2); border-right: 1px solid rgba(255,255,255,0.2);">
            {{ $product->subcategory->name }}
         </div>
         @endif
      <a href="{{ route('productList.view', [$product->category->url_key, $product->subcategory->url_key, $product->url_key]) }}" 
         class="product-link" 
         data-product-index="{{ $loop->index }}"
         data-product-id="{{ $product->id }}"
         data-product-name="{{ $product->name ?? '' }}"
         data-product-category="{{ $product->category->name ?? '' }}"
         data-product-subcategory="{{ $product->subcategory->name ?? '' }}"
         data-product-code="{{ $product->article ?? '' }}"
         data-product-price="{{ $product->in_mrp ?? 0 }}"
         data-product-size="{{ $product->size ?? '' }}">
         <img src="{{ url($product->image??'') }}" alt="{{ $product['name']??'' }}" loading="lazy" title="{{ $product['name']??'' }}">
      </a>
   </div>
   <div class="contnt_bxxx">
      <a href="{{ route('productList.view', [$product->category->url_key, $product->subcategory->url_key, $product->url_key]) }}" 
         class="product-link" 
         data-product-index="{{ $loop->index }}"
         data-product-id="{{ $product->id }}"
         data-product-name="{{ $product->name ?? '' }}"
         data-product-category="{{ $product->category->name ?? '' }}"
         data-product-subcategory="{{ $product->subcategory->name ?? '' }}"
         data-product-code="{{ $product->article ?? '' }}"
         data-product-price="{{ $product->in_mrp ?? 0 }}"
         data-product-size="{{ $product->size ?? '' }}">
         <h6>{{ $product->category->name ??'' }} | {{ $product->subcategory->name ??'' }}</h6>
      </a>
      <a href="{{ route('productList.view', [$product->category->url_key, $product->subcategory->url_key, $product->url_key]) }}" 
         class="product-link" 
         data-product-index="{{ $loop->index }}"
         data-product-id="{{ $product->id }}"
         data-product-name="{{ $product->name ?? '' }}"
         data-product-category="{{ $product->category->name ?? '' }}"
         data-product-subcategory="{{ $product->subcategory->name ?? '' }}"
         data-product-code="{{ $product->article ?? '' }}"
         data-product-price="{{ $product->in_mrp ?? 0 }}"
         data-product-size="{{ $product->size ?? '' }}">
         <h5 class="title">{{ $product['name']??'' }}</h5>
      </a>
      <div class="prdct_code">Code: <strong>{{ $product['article']??'' }}</strong></div>
      <div class="prdct_code">Size: <strong>{{ $product['size']??'' }}</strong></div>
      <div class="prdct_code" style="margin-top: 5px;">Price: <strong>₹{{ $product['in_mrp']??'' }}</strong>
         @if($product->in_v1_mrp>$product['in_mrp'])
         <del style="margin-left: 8px; color: #b0b0b0;">₹{{$product->in_v1_mrp}}</del>
         @endif
      </div>
      <div class="amaflipbox" style="margin-top: 15px;">
         @if(!empty($product['productAttribute']['flipkart_link']))
         <a href="{{ $product['productAttribute']['flipkart_link'] }}" target="_blank"><img src="{{asset('icons/flipkart.png')}}" alt="Flipkart"></a>
         @endif
         @if(!empty($product['productAttribute']['amazon_link']))
         <a href="{{ $product['productAttribute']['amazon_link'] }}" target="_blank"><img src="{{asset('icons/amazon.png')}}" alt="Amazon"></a>
         @endif
      </div>
   </div>
</div>
<!--// Grid List Column-->
@endforeach

{{-- 
==================================================================================
GA4 ECOMMERCE TRACKING SCRIPT - ADD THIS AT THE VERY BOTTOM OF THE FILE
Place this AFTER the @endforeach but BEFORE the final @endif
==================================================================================
--}}

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // ===================================================================
    // EVENT 1: view_item_list - Fires when products are displayed
    // ===================================================================
    
    const items = [
        @foreach($productsList as $product)
        {
            item_id: "{{ $product->article ?? $product->id }}", // Product Code (Article)
            item_name: "{{ $product->name ?? '' }}", // Product Name
            affiliation: "RN Valves & Faucets", // Your store name
            coupon: "", // Add coupon code if applicable
            discount: {{ ($product->in_v1_mrp ?? 0) - ($product->in_mrp ?? 0) }}, // Discount amount
            index: {{ $loop->index }}, // Position in list (0-based)
            item_brand: "RN Valves", // Your brand
            item_category: "{{ $product->category->name ?? '' }}", // Main Category
            item_category2: "{{ $product->subcategory->name ?? '' }}", // Sub Category
            item_category3: "{{ $product->size ?? '' }}", // Size
            item_list_id: "{{ $product->category->url_key ?? 'all_products' }}", // Category URL key
            item_list_name: "{{ $product->category->name ?? 'All Products' }}", // Category Name
            item_variant: "{{ $product->size ?? '' }}", // Product Size as variant
            price: {{ $product->in_mrp ?? 0 }}, // Current Price
            quantity: 1 // Default quantity for list view
        }@if(!$loop->last),@endif
        @endforeach
    ];

    // Fire view_item_list event
    if (typeof gtag !== 'undefined' && items.length > 0) {
        gtag("event", "view_item_list", {
            item_list_id: "{{ $productsList->first()->category->url_key ?? 'all_products' }}",
            item_list_name: "{{ $productsList->first()->category->name ?? 'All Products' }}",
            items: items
        });
        
        console.log('✅ GA4 view_item_list fired:', items.length, 'products');
    }

    
    // ===================================================================
    // EVENT 2: select_item - Fires when user clicks on a product
    // ===================================================================
    
    // Track all product link clicks
    document.querySelectorAll('.product-link').forEach(function(link) {
        link.addEventListener('click', function(e) {
            
            // Get product data from data attributes
            const productIndex = this.getAttribute('data-product-index');
            const productId = this.getAttribute('data-product-id');
            const productName = this.getAttribute('data-product-name');
            const productCategory = this.getAttribute('data-product-category');
            const productSubcategory = this.getAttribute('data-product-subcategory');
            const productCode = this.getAttribute('data-product-code');
            const productPrice = this.getAttribute('data-product-price');
            const productSize = this.getAttribute('data-product-size');
            
            // Fire select_item event
            if (typeof gtag !== 'undefined') {
                gtag("event", "select_item", {
                    item_list_id: "{{ $productsList->first()->category->url_key ?? 'all_products' }}",
                    item_list_name: "{{ $productsList->first()->category->name ?? 'All Products' }}",
                    items: [{
                        item_id: productCode || productId,
                        item_name: productName,
                        affiliation: "RN Valves & Faucets",
                        item_brand: "RN Valves",
                        item_category: productCategory,
                        item_category2: productSubcategory,
                        item_category3: productSize,
                        item_list_id: "{{ $productsList->first()->category->url_key ?? 'all_products' }}",
                        item_list_name: "{{ $productsList->first()->category->name ?? 'All Products' }}",
                        item_variant: productSize,
                        price: parseFloat(productPrice) || 0,
                        index: parseInt(productIndex),
                        quantity: 1
                    }]
                });
                
                console.log('✅ GA4 select_item fired:', productName);
            }
        });
    });
    
    // Track product image clicks
    document.querySelectorAll('.grid-list-column-item .thumb a').forEach(function(link) {
        link.addEventListener('click', function(e) {
            const productIndex = this.getAttribute('data-product-index');
            const productName = this.getAttribute('data-product-name');
            
            console.log('🖼️ Product image clicked:', productName, 'at position', productIndex);
        });
    });
    
});
</script>

@endif
