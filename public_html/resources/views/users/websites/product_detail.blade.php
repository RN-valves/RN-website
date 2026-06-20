@extends('users.master')
<?php 
$url= url()->full(); 
?>
@section('seo_tags')
<title>{{$getSingleProduct['title']??''}}</title>
<!-- SEO Meta Tags product_detail-->
<meta name="description" content="{{ $getSingleProduct['description']??'' }} at most suitable rates with free delivery. Callus:+91-9811103377"/>
<meta name="keywords" content="{{$getSingleProduct['keywords']??''}}">
<meta property=og:type content=product>
<meta property="og:title" content="{{$getSingleProduct['title']??''}}">
<meta property="og:image" content="{{ url($getSingleProduct['image']??'') }}">
<meta name="og:description" content="{{ $getSingleProduct['description']??'' }} at most suitable rates with free delivery. Callus:+91-9811103377"> 
<meta property=og:image:url content="{{ url($getSingleProduct['image']??'') }}">
<meta property=twitter:title content="{{$getSingleProduct['title']??''}}">
<meta property=twitter:description content="{{ $getSingleProduct['description']??'' }} at most suitable rates with free delivery. Callus:+91-9811103377">
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

<style>
   /* Premium Breadcrumb */
   .breadcrumb-area.style-03 {
      background: #f8fafc !important;
      padding: 30px 0 !important;
      border-bottom: 1px solid #e2e8f0;
   }
   .breadcrumb-area.style-03 .page-list {
      display: flex;
      gap: 10px;
      font-size: 0.95rem;
      color: #64748b;
      margin: 0;
      padding: 0;
      list-style: none;
   }
   .breadcrumb-area.style-03 .page-list li a {
      color: #1a1a1a;
      font-weight: 600;
      text-decoration: none;
      transition: color 0.3s ease;
   }
   .breadcrumb-area.style-03 .page-list li a:hover {
      color: #00a0e3;
   }

   /* Product Page Spacing */
   .product-details-tab {
      padding: 60px 0;
   }

   /* Section Titles */
   .tabsectiontitle {
      font-size: 1.5rem;
      font-weight: 700;
      color: #003366;
      margin-bottom: 30px;
      position: relative;
      padding-bottom: 12px;
   }
   .tabsectiontitle::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 50px;
      height: 3px;
      background: #00a0e3;
      border-radius: 2px;
   }

   /* Pricing in Details */
   .product-description .common-price-style {
      font-size: 2.2rem;
      font-weight: 800;
      color: #003366;
      margin: 20px 0;
      display: flex;
      align-items: center;
      gap: 15px;
   }
   .product-description .common-price-style .cutprice {
      font-size: 1.25rem;
      color: #94a3b8;
      font-weight: 400;
   }
   .product-description .common-price-style .text-success {
      font-size: 1rem;
      background: #f0fdf4;
      padding: 4px 12px;
      border-radius: 20px;
      font-weight: 600;
   }

   /* Meta Info */
   .product-meta {
      margin-bottom: 10px;
      font-size: 0.95rem;
   }
   .product-meta-name {
      color: #64748b;
      font-weight: 500;
      min-width: 120px;
      display: inline-block;
   }
   .product-meta .name b {
      color: #1e293b;
   }

   /* Quantity & Buttons */
   .cart-wrap {
      margin-top: 30px;
      gap: 15px;
      align-items: center;
   }
   .qty {
      width: 80px !important;
      height: 54px !important;
      border-radius: 12px !important;
      border: 1px solid #e2e8f0 !important;
      text-align: center;
      font-weight: 700;
      font-size: 1.1rem;
   }
   .addtocartbtn, .shop-now {
      background: #1a1a1a !important;
      border-radius: 12px !important;
      padding: 15px 35px !important;
      font-weight: 700 !important;
      letter-spacing: 1px !important;
      text-transform: uppercase !important;
      border: none !important;
      transition: all 0.3s ease !important;
      color: white !important;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      text-decoration: none !important;
   }
   .addtocartbtn:hover, .shop-now:hover {
      background: #003366 !important;
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(0,51,102,0.2);
      color: white !important;
   }
   .buy-button {
      background: linear-gradient(135deg, #003366, #00a0e3) !important;
      border-radius: 12px !important;
      padding: 15px 35px !important;
      font-weight: 700 !important;
      letter-spacing: 1px !important;
      text-transform: uppercase !important;
      border: none !important;
      transition: all 0.3s ease !important;
      color: white !important;
   }
   .buy-button:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(0,160,227,0.3);
   }

   /* USP Section Customization */
   .rn-usp-section {
      background: white !important;
      border: 1px solid #f1f5f9 !important;
      box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05) !important;
   }

   /* Similar Products Card Override */
   .product-details-tab .grid-list-column-item {
      width: 100% !important;
      margin-bottom: 30px;
   }
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





