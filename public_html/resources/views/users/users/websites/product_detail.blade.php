@extends('users.master')
<?php 
$url= url()->full(); 
?>
@section('seo_tags')
<title>{{$getSingleProduct['title']??''}}</title>
<!-- SEO Meta Tags-->
<meta name="description" content="{{ $getSingleProduct['description']??'' }} at most suitable rates with free delivery. Callus:+91-7827049866"/>
<meta name="keywords" content="{{$getSingleProduct['keywords']??''}}">
<meta property=og:type content=product>
<meta property="og:title" content="{{$getSingleProduct['title']??''}}">
<meta property="og:image" content="{{ url($getSingleProduct['image']??'') }}">
<meta name="og:description" content="{{ $getSingleProduct['description']??'' }} at most suitable rates with free delivery. Callus:+91-7827049866"> 
<meta property=og:image:url content="{{ url($getSingleProduct['image']??'') }}">
<meta property=twitter:title content="{{$getSingleProduct['title']??''}}">
<meta property=twitter:description content="{{ $getSingleProduct['description']??'' }} at most suitable rates with free delivery. Callus:+91-7827049866">
<meta property=twitter:image content="{{ url($getSingleProduct['image']??'') }}">

<script type="application/ld+json">
{
  "@context" : "http://schema.org",
  "@type" : "LocalBusiness",
  "name" : "{{$getSingleProduct['name']}}",
  "image" : "{{ url($getSingleProduct['image']??'') }}",
   "telephone" : "+919811103377",
   "email" : "web@rnvalves.com",
   "address" : {
   "@type" : "PostalAddress",
   "addressCountry" : "India"
  },
  "url" : "{{$url}}",
"sameAs" : [
   " https://twitter.com/RNValves",
   " https://www.facebook.com/rnvalvesandfaucets/",
   " https://www.linkedin.com/company/rn-valves-faucets/",
   " https://www.youtube.com/channel/UCpUUF6ZFL88S85IuSsHDRSQ/?sub_confirmation=1", 
   " https://www.instagram.com/rnvalvesandfaucets/"
   ],

  "aggregateRating" : {
    "@type" : "AggregateRating",
    "ratingValue" : "5",
    "bestRating" : "5",
       "ratingCount" : "150"
  },
  "review" : {
    "@type" : "Review",
    "author" : {
      "@type" : "Person",
      "name" : "150"
    },
    "reviewRating" : {
      "@type" : "Rating",
   "ratingValue":"4.5"
   }
  }
}
</script>

<!-- <script> 
   gtag('event', 'conversion', {'send_to': 'AW-610718723/u5BYCMzDuYYaEIOom6MC'}); 
  
</script> -->

@endsection
@section('content')
<div class="breadcrumb-area style-03">
   <div class="container">
      <div class="row">
         <div class="breadcrumb-content">
            <ul class="page-list">
               <li><a href="{{route('welcome')}}">Home</a></li>
               <li><a href="{{route('productList', $getSingleProduct['subcategory'])}}"> {{$getSingleProduct['subcategory']->name??''}} </a></li>
               <li>{{$getSingleProduct['name']??''}}</li>
            </ul>
         </div>
      </div>
   </div>
</div>
<!--Page-->
<div class="cstm_page_section" style="background: #ffffff !important; padding-bottom: 0px;">
   <!--Product Details Tab-->
   <div class="product-details-tab">
      <div class="container-fluid">
         <div class="row">
            @include('users.websites.product_details.left_image')
            @include('users.websites.product_details.right_product_details')
         </div>
      </div>
      <div style="background: #fdfdfd; margin-top: 50px;">
         <div class="container-fluid">
            <div class="product-information padding-top-10 padding-bottom-50">
               <div class="tab-content description-tab-content">
                  <h4 class="tabsectiontitle">Product Details</h4>
                  <!--// Tab Panel-->
                  <div class="pro_content_details">
                     <p>{!! $getSingleProduct['content']['content']??'' !!}</p>
                  </div>
                  <div class="pro_content_details">
                     <p>{!! @$getSingleProduct->productAttribute->short_description !!}</p>
                  </div>

                  @if(!empty($getSingleProduct->productAttribute->video_url))
                  <div class="row">
                     <div class="col-lg-6">
                        <iframe width="100%" height="350" src="{{ $getSingleProduct->productAttribute->video_url??'' }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                     </div>
                  </div>
                  @endif
                  
               </div>
            </div>
         </div>
      </div>
      
      <!-----Review Section ----->
      {{-- @include('users.websites.product_details.similar_products') --}}
      <!-----Review Section ----->

      <!-----Similar Product Section ----->
      @if($similarProducts->count()>0)
      @include('users.websites.product_details.similar_products')
      @endif
      <!-----Similar Product Section ----->
   </div>
</div>
<!--//  Page-->

<style type="text/css">
   .grid-list-column-item{width: 100% !important;}
   .theiaStickySidebar .nt_bg_lz {background-size: contain  !important; border: 1px solid #ddd !important;}
   .pswp__img{height: auto !important; margin-top: 50px;}
   .pswp__button--share{display: none !important;}
   .theiaStickySidebar .padding-top__127_66 { padding-top: 115.66%;}
   .shipping-product {
   display: flex;
   align-items: center;
   padding: 8px 15px;
   background: #f9f9f9;
   font-size: 13px;
   margin-bottom: 10px; border-radius: 3px;
   }
   .shipping-product span {
   color: #000;
   margin-left: 10px;
   font-weight: 800;
   }
   .shipping-product p {
   padding-right: 10px;
   margin-left: 5px; margin-bottom: 0px;
   }
   .quantity .tc a,  .quantity .tc button { top: 1px !important;}
   .quantity input.input-text[type="number"] { height: 35px !important;}
   .header_shadow{box-shadow: none !important;}
   @import url(https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css);
   fieldset, label { margin: 0; padding: 0; }
   h1 { font-size: 1.5em; margin: 10px; }
   /****** Style Star Rating Widget *****/
   .rating { 
   border: none;
   float: left;
   }
   .rating > input { display: none; } 
   .rating > label:before { 
   margin: 5px;
   font-size: 1.25em;
   font-family: 'Font Awesome 5 Free';
   display: inline-block;
   content: "\f005";
   }
   .rating > .half:before { 
   content: "\f089";
   position: absolute;
   }
   .rating > label { 
   color: #ddd; 
   float: right; 
   }
   /***** CSS Magic to Highlight Stars on Hover *****/
   .rating > input:checked ~ label, /* show gold star when clicked */
   .rating:not(:checked) > label:hover, /* hover current star */
   .rating:not(:checked) > label:hover ~ label { color: #FFD700;  } /* hover previous stars in list */
   .rating > input:checked + label:hover, /* hover current star when changing rating */
   .rating > input:checked ~ label:hover,
   .rating > label:hover ~ input:checked ~ label, /* lighten current selection */
   .rating > input:checked ~ label:hover ~ label { color: #FFED85;  }  
   .breadcrumb-area { padding: 50px 0 50px 0 !important;}
   .breadcrumb-area.style-03 .breadcrumb-content{padding: 10px 25px 10px 25px !important;}
</style>


<script>
    gtag("event", "view_item", {
        currency: "INR",
        value: "{{ $getSingleProduct['in_mrp'] }}",
        items: [
            {
                item_id: "{{ $getSingleProduct['id'] }}",
                item_name: "{{ $getSingleProduct['name'] }}",
                affiliation: "RN Valves & Faucets",
                discount: 0,
                item_brand: "RN",
                item_category: "{{ $getSingleProduct->category->name }}",
                item_category2: "{{ $getSingleProduct->subcategory->name }}",
                item_variant: "{{$getSingleProduct['color_name']}}",
                location_id: "{{@$stateName}}",
                price: "{{ $getSingleProduct['in_mrp'] }}",
                quantity: 1
            }
        ]
    });
</script>

<script>
    document.querySelectorAll(".addtocartbtn").forEach(function(button) {
        button.addEventListener("click", function() {
            const quanty = document.getElementById("quantity").value;
            if (quanty < 1) {
               alert("Quantity must be at least 1.");
               return;
            }
            const item = {
                item_id: button.dataset.id,
                item_name: button.dataset.name,
                item_brand: button.dataset.brand,
                item_category: button.dataset.category,
                item_category2: button.dataset.subcategory,
                item_variant: button.dataset.color,
                price: parseFloat(button.dataset.price),
                quantity: quanty
            };
            
            gtag("event", "add_to_cart", {
                currency: "INR",
                value: item.price * quanty,
                items: [item]
            });
            gtag_report_conversion(item.price * quanty);
        });
    });

      function gtag_report_conversion(price) {
         var callback = function () {
           console.log("Conversion event tracked successfully.");
         };
         gtag("event", "conversion", {
             send_to: "AW-610718723/Dar9CKaW0JYaEIOom6MC",
             value: price,
             currency: "INR",
             event_callback: callback
         });
         return false;
      }
</script>
@endsection

@section('scripts')
<script type="text/javascript">   
   $("#checkPincode").on('click',function(){
      var pincode = $("#pincode").val();
      if(pincode==""){
         iziToast.error({position: 'topRight', message: "please enter valid pincode"});
         return false;
      }
      $.ajax({
         type: 'post',           
         data: {
            "_token": "{{ csrf_token() }}",
            pincode:pincode,
         },
         url: "{{ route('check_pincode') }}",
         dataType: 'json',
         success:function(data){
            $("#pincode_message").html(data.message);   
         },error:function(){
            iziToast.error({position: 'topRight', message: "please enter valid pincode"});
         }
      });
   });
</script>
<script type="text/javascript">
   $(document).on('click','.addtocartbtn', function() {
      var productid;
      var fskucode = '';
      if ($("input[name='product_id']").length > 1) {
        productid = $("input[name='product_id']:checked").val();
        if (!productid) {
            iziToast.error({
                position: 'topRight',
                message: 'Please select a product size before adding to the cart.'
            });
            return false;
        }
      }
    
      else if ($("input[name='product_id']").length === 1) {
          productid = $("input[name='product_id']").val();
          if (!productid) {
              iziToast.error({
                  position: 'topRight',
                  message: 'Product information is missing.'
              });
              return false;
          }
      } else {
        
          iziToast.error({
              position: 'topRight',
              message: 'No product available to add to the cart.'
          });
          return false;
      }
      fskucode = $("input[name='sku_code']:checked").val();
      if ($("input[name='sku_code']").length > 1) {
          if (!fskucode) {
            iziToast.error({
                position: 'topRight',
                message: 'Please select a turn before adding to the cart.'
            });
            return false;
        }
        }
        var qty = $('.qty').val();
        $.ajax({
          data:{
            "_token": "{{ csrf_token() }}",
            product_id:productid,
            quantity:qty,
            sku_code:fskucode,
          },
          url: "{{ route('addToCart') }}",
          type:"POST",
            success:function(data){
                if(data.status==true){
                    $('.alert-success').css('display','block');
                    iziToast.success({timeout: 3000, position: 'topRight', title: 'OK', message: data.message});
                   let cartQuantity = parseInt(data.totalCartItems) || 0;
                   $('.totalCartItems').text(cartQuantity);
                   $('#discountedText').empty().append(data.discountText);
                }
            },error:function(){
                iziToast.error({title: 'Error', message: "Something went wrong!"});
            }
        });
    });
</script>
@endsection





