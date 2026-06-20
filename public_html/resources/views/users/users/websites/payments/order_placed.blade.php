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
@php 
    $order = App\Models\Order::where('id',$_GET['transactionId'])->first();
    $orderItems = $order->order_items->map(function ($item) {
        return [
            'item_id' => $item->product_code,
            'item_name' => $item->product->name,
            'affiliation' => "RN Valves & Faucets",
            'discount' => $item->discount ?? 0,
            'item_brand' => "RN",
            'item_category' => optional($item->product->category)->name,
            'item_category2' => optional($item->product->subcategory)->name,
            'item_variant' => optional($item->product)->color_name ?? '',
            'price' => $item->price,
            'quantity' => $item->total_qty,
        ];
    })->values();

    $orderItemsJson = $orderItems->toJson();
@endphp 
@section('seo_tags')
<script>
   var amount = getParameterByName('orderAmount');
   var transactionid = getParameterByName('transactionId');
  gtag('event', 'conversion', {
      'send_to': 'AW-610718723/aBjtCIjn0pYaEIOom6MC',
      'value': amount ? parseFloat(amount) : 1.0,
      'currency': 'INR',
      'transaction_id': transactionid
  });
</script>
@endsection
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

let orderItems = {!! $orderItemsJson !!};
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
    console.log('successfully event fire');
});
</script>
@endsection