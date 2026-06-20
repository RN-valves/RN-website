@extends('users.master')
@section('seo_tags')
<title>Thank Your for choosing us - RN Valves & Faucets | Order Successfully Placed</title>
<meta name="description" content="Thank Your for choosing us - RN Valves & Faucets | Order Successfully Placed"/>
<meta name="keywords" content="Faucets, Sanitaryware, Sensor Faucets, Taps, Valves, Overhead Showers, Bathroom Accessories, Diverter, Shower Panels, Hoses & Connections, Luxury Faucets, Single Lever Basin Mixer">
<meta property="og:title" content="Thank Your for choosing us - RN Valves & Faucets | Order Successfully Placed">
<meta property="og:image" content="{{asset('public/images/dealer.jpg')}}">
<meta name="og:description" content="Thank Your for choosing us - RN Valves & Faucets | Order Successfully Placed">
<meta property=twitter:title content="Thank Your for choosing us - RN Valves & Faucets | Order Successfully Placed">
<meta property=twitter:description content="Thank Your for choosing us - RN Valves & Faucets | Order Successfully Placed">
<meta property=twitter:image content="{{asset('public/images/dealer.jpg')}}">
@endsection
@section('ccs_links')
<link rel="stylesheet" href="{{url('users/assets/css/custom.css')}}" type="text/css">
@endsection
@section('content')
<!--Sign Up Page-->
<div class="">
   <div class="container-fluid">
      <!-- start of main -->
      <div class="row">
         <div class="col-12">
            <div class="message-box">
               <div class="success-container">
                  <h1 class="monserrat-font pt-5" style="color: Grey">Thank you for your order</h1>
                  <br>
                  <div class="alert alert-success">
                     <br>  
                     <h5>ORDER CONFIRMATION</h5>
                     @if(Session::has('success'))
                     <p class="alert alert-success">
                        {{Session::get('success')}}
                     </p>
                     @endif
                     <p>Thank you for choosing <strong>RN Valves & Faucets</strong>. You will shortly receive a confirmation email.</p>
                  </div>
                  <br>
                  <a id="create-btn" href="{{ url('/') }}" class="btn btn-ouioui-secondary margin-left-5px shadow-none">Back to shop</a>
               </div>
            </div>
         </div>
      </div>
      <!-- end of main -->
   </div>
</div>
<style>
   /* Write page CSS here*/
   .message-box{
   display: flex;
   justify-content: center;
   padding-top: 10vh;
   padding-bottom: 10vh;
   }
   .success-container{
   background: white;
   width: 90%;
   box-shadow: 5px 5px 10px grey;
   text-align: center;
   }
   .confirm-green-box{
   width: 100%;
   background: #d7f5da;
   }
   .monserrat-font{
   font-family: 'Montserrat', sans-serif;
   letter-spacing: 2px;
   }
   /* --------------- site wide START ----------------- */
   .main{
   width:80vw;
   margin: 0 10vw;
   height:50vh;
   overflow:hidden;
   }
   body{
   font-family: 'Montserrat', sans-serif;
   }
   /* 
   * Setting the site variables, example of how to use
   * color:var(--text-1);
   *
   */
   :root {
   --background-1: #ffffff;
   --background-2: #E3E3E3;
   --background-3: #A3CCC8;
   --text-1: #000000;
   --text-2: #ffffff;
   --text-size-reg: calc(20px + (20 - 18) * ((100vw - 300px) / (1600 - 300)));
   --text-size-sml: calc(10px + (10 - 8) * ((100vw - 300px) / (1600 - 300)));
   }
   .verticle-align{
   text-align:center;
   display:flex;
   align-items:center;
   justify-content:center;
   }
   .no-style{
   padding:0;
   margin:0;
   }
   /* ------------------ site wide END ----------------- */
   /* ----- RESPONSIVE OPTIONS MUST STAY AT BOTTOM ----- */
   /* SM size and above unless over ridden in bigger sizes */
   @media (min-width: 576px) { /* sm size */
   }
   /* MD size and above unless over ridden in bigger sizes */
   @media (min-width: 768px) {
   }
   /* LG size and above unless over ridden in bigger sizes */
   @media (min-width: 992px) { 
   }
   /* XL size and above */
   @media (min-width: 1200px) {
   }
</style>
{{-- Legacy GA scripts retained for reference
<script>
function getParameterByName(name) {
    let url = new URL(window.location.href);
    return url.searchParams.get(name);
}

function gtag_report_conversion(url) {
  var callback = function () {
    if (typeof(url) != 'undefined') {
      window.location = url;
    }
  };
  gtag('event', 'conversion', {
      'send_to': 'AW-610718723/aBjtCIjn0pYaEIOom6MC',
      'value': amount ? parseFloat(amount) : 0,
      'currency': 'INR',
      'transaction_id': transactionid,
      'event_callback': callback
  });
  return false;
}

document.addEventListener("DOMContentLoaded", function() {
    gtag("event", "purchase", {   
        transaction_id: "{{ @$_GET['transactionId'] }}", 
        value: {{ @$order->total_amount }} ? parseFloat({{ @$order->total_amount }}) : 0, 
        tax: 0,
        shipping: 0,
        currency: "INR",
        coupon: "",
        items: orderItems
    });
});
</script>
--}}
@endsection


{{-- 
==================================================================================
FIND THE LEGACY GA SCRIPT SECTION (around lines 133-171)
It starts with: {{-- Legacy GA scripts retained for reference
REPLACE THAT ENTIRE SECTION WITH THIS NEW SCRIPT
==================================================================================
--}}

{{-- GA4 Ecommerce Purchase Tracking --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // ===================================================================
    // Get order data from URL parameters or session
    // ===================================================================
    
    function getParameterByName(name) {
        let url = new URL(window.location.href);
        return url.searchParams.get(name);
    }
    
    // Get transaction details
    const transactionId = getParameterByName('transactionId') || 
                         getParameterByName('order_id') || 
                         "{{ @$_GET['transactionId'] }}" || 
                         "{{ @$order->order_number ?? '' }}" ||
                         "ORDER-" + Date.now();
    
    const orderTotal = parseFloat("{{ @$order->total_amount ?? 0 }}") || 0;
    const orderTax = parseFloat("{{ @$order->tax_amount ?? 0 }}") || 0;
    const orderShipping = parseFloat("{{ @$order->shipping_amount ?? 0 }}") || 0;
    const couponCode = "{{ @$order->coupon_code ?? '' }}" || "";
    
    console.log('Order Success Page Loaded');
    console.log('Transaction ID:', transactionId);
    console.log('Order Total: ₹' + orderTotal);
    
    
    // ===================================================================
    // Prepare order items
    // ===================================================================
    
    const orderItems = [
        @if(isset($order) && isset($order->orderItems))
            @foreach($order->orderItems as $item)
            {
                item_id: "{{ $item->product->article ?? $item->product->sku_code ?? $item->product_id }}",
                item_name: "{{ $item->product->name ?? $item->product_name ?? '' }}",
                affiliation: "RN Valves & Faucets",
                coupon: couponCode,
                item_brand: "{{ $item->product->brand ?? 'RN Valves' }}",
                item_category: "{{ $item->product->category->name ?? '' }}",
                item_category2: "{{ $item->product->subcategory->name ?? '' }}",
                item_category3: "{{ $item->size ?? '' }}",
                item_variant: "{{ $item->product->color_name ?? $item->color ?? '' }}",
                price: {{ $item->price ?? 0 }},
                quantity: {{ $item->quantity ?? 1 }}
            }@if(!$loop->last),@endif
            @endforeach
        @endif
    ];
    
    console.log('Order Items:', orderItems.length);
    
    
    // ===================================================================
    // EVENT: purchase - Order completed successfully
    // ===================================================================
    
    if (typeof gtag !== 'undefined' && transactionId && orderTotal > 0) {
        
        // Fire GA4 purchase event
        gtag("event", "purchase", {
            transaction_id: transactionId,
            value: orderTotal,
            tax: orderTax,
            shipping: orderShipping,
            currency: "INR",
            coupon: couponCode,
            items: orderItems
        });
        
        console.log('✅ GA4 purchase event fired');
        console.log('   Transaction ID:', transactionId);
        console.log('   Order Total: ₹' + orderTotal);
        console.log('   Items:', orderItems.length);
        
        
        // ===================================================================
        // Google Ads Conversion Tracking
        // ===================================================================
        
        gtag('event', 'conversion', {
            'send_to': 'AW-610718723/aBjtCIjn0pYaEIOom6MC',
            'value': orderTotal,
            'currency': 'INR',
            'transaction_id': transactionId
        });
        
        console.log('✅ Google Ads conversion tracked');
        
    } else {
        console.error('❌ Purchase tracking failed');
        console.error('   Transaction ID:', transactionId);
        console.error('   Order Total:', orderTotal);
        console.error('   gtag available:', typeof gtag !== 'undefined');
    }
    
});
</script>