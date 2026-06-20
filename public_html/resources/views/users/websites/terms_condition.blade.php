@extends('users.master')
@section('seo_tags')
<title>Terms & Conditions - RN Valves & Faucets</title>

<meta name="description" content="RN Valves & Faucets Terms & Conditions, Terms & Conditions"/>
<meta name="keywords" content="RN Valves & Faucets Terms & Conditions, Terms & Conditions">

<meta property=og:type content="Privacy Policy">
<meta property="og:title" content="Terms & Conditions - RN Valves & Faucets">
<meta property="og:image" content="{{url('users/images/assured.png')}}">
<meta name="og:description" content="RN Valves & Faucets Terms & Conditions, Terms & Conditions">
<meta property=og:image:url content="{{url('users/images/assured.png')}}">

<meta property=twitter:title content="Terms & Conditions - RN Valves & Faucets">
<meta property=twitter:description content="RN Valves & Faucets Terms & Conditions, Terms & Conditions">
<meta property=twitter:image content="{{url('users/images/assured.png')}}">

@endsection
@section('content')
<!--Page-->


<div class="cstm_page_section website-cart addressbxx">
   <div class="container-fluid">
      <div class="brdcrm_menu" style="margin-top: 5px !important;"><a href="{{route('welcome')}}"><i class="fas fa-chevron-left"></i>Back to Home </a></div>
      <div class="row">
         @include('users.websites.policies.menu')
         <div class="col-lg-8">
            <div class="blog-details-wrap">
               <!--Blog Details item-->
               <div class="blog-details-items">
                     <h1 class="acc_page_title">{{$data->title}}</h1>
                     <div class="blog_content_areaaa">
                        <!-- <h5>ORDERS T&C</h5>
                        <p>
                           Payment for all the orders above 50,000 needs to be done through online as per guided by our executives
                           Delivery services are not available with a purchase order below 3000.(except ex dealer showrooms)<br><br>
                           <strong>In case of out of stock items</strong> : in case of product unavailability, please do write us on <a href="mailto:sales@rnvalves.com">sales@rnvalves.com</a>  or <a href="mailto:enquiry@rnvalves.com">enquiry@rnvalves.com</a>. 
                        </p>
                        <h5>DELIVERY T&C</h5>
                        <li><strong>Delivery charges</strong></li>
                        <p>
                           Free delivery  above a total amount of 10000/- or more and for orders below 10000/- an amount 250/- is charged for delivery ( subjected to change with change in state and area)
                        </p>
                        <li><strong>Delivery time </strong></li>
                        <p>
                           The estimated time may differ from one item to another. Please read below for an explanation of delivery estimates:<br><br>
                           <strong>1. Mentioned as 15 days delivery time:</strong> These items will also be mentioned as “In Stock”. For all areas serviced by RN Valves channel partners the delivery time will be 15-18 business days. For other areas, orders will be sent from Central warehouse, Delhi through transport service which may take 21-25 days depending on the location. Business days exclude public holidays and Sundays.<br><br>
                           <strong>2. Mentioned as more than 21 days delivery time:</strong> We procure and ship the items within the time mentioned on the item details page. Some items have to be imported from outside India. These items can take 21 or more days to reach. You can always rest assured that you will receive your order within the time specified.
                        </p>
                        <li><strong>Mode of delivery</strong></li>
                        <p>We process all deliveries through Transport & Channel partners.</p> -->
                        {!! $data->description !!}
                     </div>
                  </div>
            </div>
         </div>
      </div>
   </div>
</div>

<!--//  Page-->
@endsection