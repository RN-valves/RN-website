@extends('users.master')
@section('seo_tags')
@endsection
@section('ccs_links')
<link rel="stylesheet" href="{{url('users/assets/css/custom.css')}}" type="text/css">
@endsection
@section('content')
<?php 
   $CartItems = \Cart::content();
?>
<!--Page-->
<div class="cstm_page_section website-cart addressbxx">
   <div class="container-fluid">
      <form action="#" method="post" id="SubmitForm">
      @csrf
      <div class="row">
         <div class="col-md-7 col-lg-8">
            <div>
               <!---Step 2--->
               @include('users.websites.checkouts.addresses')
               <!--ESTIMATED DELIVERY START-->
               <div class="check_tbs_box mt-4">
                  <div class="head_section"> ESTIMATED DELIVERY </div>
                  <div class="estimated_pro_list">
                     <div class="estialrt text-dark">Shipment : By Min - <span class="text-success font-weight-bold">{{ now()->addDays(4)->format('d M Y') }}</span> 
                        Max - <span class="text-success font-weight-bold">{{ now()->addDays(8)->format('d M Y') }}</span>
                     </div>
                     @include('users.websites.checkouts.checkout_items')
                  </div>
               </div>
               <!--ESTIMATED DELIVERY END-->
            </div>
         </div>
         <!-----right side--->
         @include('users.websites.checkouts.right_details')
         <!-----right side--->
      </div>
   </form>
      <!--end cart section-->
   </div>
</div>
<!--//  Page-->
<style type="text/css">
   .modal-backdrop {
   background-color: #000000 !important;
   }
   .modal-backdrop.show {
   opacity: 0.50 !important;
   }
</style>

@php
    $cartItems = \Cart::content()->map(function ($item) {
        $product = App\Models\Product::getSingleProId($item->id);
        return [
            'item_id' => $product->id,
            'item_name' => $product->name,
            'affiliation' => "RN Valves & Faucets",
            'discount' => 0,
            'item_brand' => "RN",
            'item_category' => optional($product->category)->name,
            'item_category2' => optional($product->subcategory)->name,
            'item_variant' => $product->color_name ?? '',
            'price' => $product->in_mrp,
            'quantity' => $item->qty,
        ];
    })->values();

    $cartJson = $cartItems->toJson();
@endphp

<script>
    let cartData = {!! $cartJson !!};

    if (Array.isArray(cartData)) {
        cartData.forEach(item => {
            gtag("event", "begin_checkout", {
                currency: "INR",
                value: item.price,
                items: [item]
            });
        });
    } else {
        console.error("cartData is not an array:", cartData);
    }

</script>
@endsection
@section('scripts')
<script type="text/javascript">
   $(".DiscountSuccess").hide();
   $('body').delegate('#ApplyDiscount', 'click', function(){
      var payterm = $("input[name='payment_term']:checked").val()
        var discount_code = $("#getDiscountCode").val();
        if(discount_code==""){
            $("#coupon_error").text('Please Enter Coupon Code to apply Coupon!');
            return false;
        }
        if(payterm === 'COD'){
          $("#coupon_error").text('Coupons code apply to prepaid orders only!');
          return false;
         }else{
            $("#coupon_error").empty();
         }
        $.ajax({
           type: "POST",
           url: "{{ route('cartApplyDiscount') }}",
           data: {
               "_token": "{{ csrf_token() }}",
               discount_code : discount_code,
           },
           dataType: 'json',
           success : function(data){
            $(".getDiscountAmount").html('-'+data.discount_amount);
               
               var codAmount = 0;
               if(payterm === 'COD'){
                  codAmount = 90;
               }
               var shipping = $("#getShippingCharge").val();
               var final_total = parseFloat(data.total_payble) + parseFloat(shipping) + codAmount;
               $(".getTotalAmount").html(final_total);
               $("#getFinalAmount").val(final_total);
               $("#paybleTotal").val(data.total_payble);
               $("#discount_code").val(discount_code);
               $(".getDiscountAmount").val(data.discount_amount);
               if(data.status == false){
                   alert(data.message);
               }else{
                  $(".DiscountSuccess").show();
               }
           },
           error : function(data){
              
           }
        });
     });
</script>


<script type="text/javascript">
$('body').delegate('.getShippingCharge', 'change', function(){
   var address_id = $(this).val();
   var total_payble = $("#paybleTotal").val();
   $.ajax({
      type: "POST",
      url: "{{ route('getShippingCharges') }}",
      data: {
         "_token": "{{ csrf_token() }}",
            address_id : address_id,
         },
         dataType: 'json',
         success : function(data){
            $("#shippingCharge").html(data.ShippingCharge);
               $("#getShippingCharge").val(data.ShippingCharge);
               var final_total =  parseFloat(data.ShippingCharge) + parseFloat(total_payble);
               $(".getTotalAmount").html(final_total);
               $("#getFinalAmount").val(final_total);
           },
           error : function(data){
              
           }
        });
});
</script>
<script type="text/javascript">
   $('body').delegate('.DeleteAddress', 'click', function(){
        var choice = confirm("Want to delete this Address!");
        if(!choice){
            return false;
        }
    });
    $(document).on('click', '#paycod', function() {
      var subTotal = parseFloat("{{ \Cart::subtotal() }}".replace(/[^0-9.-]+/g, ""));
      var disAmount = $("input[name='discount_amount']").val();
      var codAmount = 90;
      var totalAmount = subTotal + codAmount;
      if(disAmount){
         $(".getDiscountAmount").html('-₹0.00');
         $("#discount_code").val('');
         $(".getDiscountAmount").val('');
         $("#coupon_error").text('Coupons code apply to prepaid orders only!');
      }
      $('.cod_div').css('display', 'block');
      $('.getCodAmount').html('₹'+codAmount.toFixed(2));
      $('.getTotalAmount').text(totalAmount.toFixed(2));
      $('#getFinalAmount').val(totalAmount);
   });
   $(document).on('click', '#payonline', function() {
       $('.cod_div').css('display', 'none');
       $("#coupon_error").empty();
       var subTotal = parseFloat("{{ \Cart::subtotal() }}".replace(/[^0-9.-]+/g, ""));
       var disAmount = $("input[name='discount_amount']").val();
       if(disAmount){
          var subTotal = subTotal - disAmount;
       }
       $('.getTotalAmount').text(subTotal.toFixed(2));
       $("#getFinalAmount").val(subTotal);
   });
</script>

<script type="text/javascript">
$('body').delegate('#SubmitForm', 'submit', function(e){
   e.preventDefault();
   $.ajax({
      type: "POST",
      url: "{{ route('place_order') }}",
      data: new FormData(this),
      processData: false,
      contentType: false,
      dataType: 'json',
      success : function(data){
         if(data.status == false){
            alert(data.message);
         }else{
            window.location.href = data.redirect;
         }
      },
      error : function(data){
              
      }
   });
});
</script>

@endsection