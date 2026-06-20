@extends('users.master')
@section('seo_tags')
<title>Cart | For Customers and Dealers | RN Valves & Faucets </title>
<meta name="description" content="RN Valves gives complete bath solutions with products such as bathroom accessories, showers, valves, and sanitaryware. Book your RN Valves product today!"/>
<meta name="keywords" content="Faucets, Sanitaryware, Sensor Faucets, Taps, Valves, Overhead Showers, Bathroom Accessories, Diverter, Shower Panels, Hoses & Connections, Luxury Faucets, Single Lever Basin Mixer">
<meta property="og:title" content="Cart | For Customers and Dealers | RN Valves & Faucets ">
<meta property="og:image" content="{{asset('public/images/dealer.jpg')}}">
<meta name="og:description" content="RN Valves gives complete bath solutions with products such as bathroom accessories, showers, valves, and sanitaryware. Book your RN Valves product today!">
<meta property=twitter:title content="Cart | For Customers and Dealers | RN Valves & Faucets ">
<meta property=twitter:description content="RN Valves gives complete bath solutions with products such as bathroom accessories, showers, valves, and sanitaryware. Book your RN Valves product today!">
<meta property=twitter:image content="{{asset('public/images/dealer.jpg')}}">
@endsection
@section('ccs_links')
<link rel="stylesheet" href="{{ url('users/assets/css/custom.css') }}" type="text/css">
@endsection
@section('content')
<!--Page-->
<div class="cstm_page_section website-cart">
   <div class="container-fluid">
      <div class="row" id="AppendCartItems">
         @include('users.websites.carts.cart_items')
      </div>
      <!--end cart section-->   
   </div>
</div>
<!--//  Page-->

<script>
      const cartItems = @json($cartItems);

      const items = Object.values(cartItems).map((item, index) => ({
          item_id: item.id,
          item_name: item.name,
          affiliation: "RN Valves & Faucets",
          coupon: "",
          discount: item.discount,
          index: index,
          item_brand: item.brand,
          item_category: item.category,
          item_category2: item.subcategory,
          price: parseFloat(item.price),
          quantity: parseInt(item.quantity, 10)
      }));
      
      // Calculate the total value of the cart
      const totalValue = items.reduce((sum, item) => sum + item.price * item.quantity, 0);
      
      // Trigger the view_cart event
      gtag("event", "view_cart", {
          currency: "INR",
          value: totalValue.toFixed(2),
          items: items
      });
</script>
<script>
    document.querySelectorAll(".removeCartItem").forEach(function(button) {
        button.addEventListener("click", function() {
            const quanty = document.getElementById("appendedInputButtons").value;
            if (quanty < 1) {
               alert("Quantity must be at least 1.");
               return;
            }
            const item = {
                item_id: button.dataset.proid,
                item_name: button.dataset.name,
                item_brand: button.dataset.brand,
                item_category: button.dataset.category,
                item_category2: button.dataset.subcategory,
                item_variant: button.dataset.color,
                price: parseFloat(button.dataset.price),
                quantity: quanty
            };
            
            gtag("event", "remove_from_cart", {
                currency: "INR",
                value: item.price * quanty,
                items: [item]
            });
            console.log(item);
        });
    });
</script>
@endsection
@section('scripts')
<script type="text/javascript">
   $(document).on('click','.btnItemUpdate', function() {
        if($(this).hasClass('qtyMinus')){
            var quantity = $(this).prev().val();
            if(quantity<=1){
                iziToast.error({position: 'topRight', message: 'Item quantity must be 1 or Greater!'});
                return false;
            }else{ 
                new_qty = parseInt(quantity)-1;
            }
        }
        if($(this).hasClass('qtyPlus')){
            var quantity = $(this).prev().prev().val();
            new_qty = parseInt(quantity)+1;
        }
   
        var cartid = $(this).data('cartid');
        $.ajax({
          data:{"_token": "{{ csrf_token() }}",
            cartid:cartid,
            new_qty:new_qty,
          },
          url: "{{ route('cartUpdate') }}",
          type:"POST",
            success:function(data){
                if(data.status==false){
                    iziToast.error({message: data.message});
                }
                $("#AppendCartItems").html(data.success);
            },error:function(){
                iziToast.error({position: 'topRight', message: 'Something went wrong!'});
            }
        });
    });
</script>

<script type="text/javascript">
   $(document).on('click','.removeCartItem', function() {
        var cartid = $(this).data('cartid');
        $.ajax({
          data:{
            "_token": "{{ csrf_token() }}",
            cartid:cartid,
          },
          url: "{{ route('cartRemoveItem') }}",
          type:"POST",
            success:function(data){
                if(data.status==false){
                    iziToast.error({position: 'topRight', message: data.message});
                    return false;
                }
                
                $("#AppendCartItems").html(data.success);
                $(".totalCartItems").html(data.totalCartItems);
                iziToast.success({timeout: 3000, position: 'topRight', title: 'OK', message: 'Product removed successfully!'});
            },error:function(){
                alert("Error");
            }
        });
    });

    $(document).on('click', '.checkout_fixedbtn', function () {
    var encryptDisCode = $('#getEncryptedDisCode').val();
    var authCheck = "{{auth()->check()}}";
    if(authCheck){
        if(encryptDisCode){
            var renderUrl = `{{ route('CartCheckout') }}?discode=${encodeURIComponent(encryptDisCode)}`;     
        }else{
            var renderUrl = `{{ route('CartCheckout') }}`;
        }
        window.location = renderUrl;
    }else{
        var modal = $('#loginModal');
        modal.modal('show');
    }
});

</script>

<script type="text/javascript">
   $(".DiscountSuccess").hide();
   $('body').delegate('#ApplyDiscount', 'click', function(){
        
        var discount_code = $("#getDiscountCode").val();
        if(discount_code==""){
            $("#coupon_error").text('Please Enter Coupon Code to apply Coupon!');
            return false;
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
            if(data.status == true){
                var discountAmount = parseFloat(data.discount_amount);
                var shipping = $("#getShippingCharge").val();
                var final_total = parseFloat(data.total_payble) + parseFloat(shipping);
               $(".getDiscountAmount").html(data.discount_amount);
               $(".getTotalAmount").html(final_total.toFixed(2));
               $("#getFinalAmount").val(final_total.toFixed(2));                   
               $(".getDiscountAmount").val(discountAmount);     
               $("#getEncryptedDisCode").val(data.encrypted_discode);    
                   
            }else if(data.status == false)
               alert(data.message);
            else{
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

<!-- <script type="text/javascript">
    $('body').delegate('#ApplyDiscount', 'click', function(){
         var discount_code = $("#getDiscountCode").val();
         $.ajax({
            type: "POST",
            url: "{{ route('cartApplyDiscount') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                discount_code : discount_code,
            },
            dataType: 'json',
            success : function(data){
                $("#getDiscountAmount").html(data.discount_amount);
                $("#getTotalAmount").html(data.total_payble);
                $("#getTotalAmountMobile").html(data.total_payble);
                if(data.status == false){
                    iziToast.error({position: 'topRight',message: data.message});
                }else{

                }
            },
            error : function(data){
               
            }
         });
      });
</script> -->
@endsection