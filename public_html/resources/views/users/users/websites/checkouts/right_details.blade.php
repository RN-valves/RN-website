<div class="col-md-5 col-lg-4">
   <div class="">
      <textarea rows="5" name="note" class="form-control shadow-none border" placeholder="Note (Opt.)">{{ old('note') }}</textarea>
   </div>
   <div class="pt-1" style="position: sticky; top: 150px;">
   @if(\Cart::content()->count() > 0 && $nextDiscount)
            <p class="discount-message">
               <b>Add products worth ₹ {{ $nextDiscount->start_value - $totalPrice }} more to unlock a discount of {{ $nextDiscount->value }}%!</b>
            </p>
         @endif
     @php
      $getActiveSlabDiscountCode = App\Models\Discount::getActiveSlabDiscountCode();
      @endphp
      @if(!empty($getActiveSlabDiscountCode))
         <div class="alert alert-success">You are eligible 
            <strong class="text-success">@if($getActiveSlabDiscountCode->type=="Percent") {{ $getActiveSlabDiscountCode->value??'' }} % @else ₹{{ $getActiveSlabDiscountCode->value??'' }} @endif OFF</strong> 
            <span class="badge badge-warning rounded-0" style="font-size:15px;">{{ $getActiveSlabDiscountCode->name??'' }}</span>
         </div>
      @endif
      <div class="distexbox">
         <div>Get Discount with using coupon code!</div>
      </div>
      <div class="mscrt">
         <div class="d-flex">
            <input class="form-control" type="text" value="@if(!empty($getActiveSlabDiscountCode)) {{ $getActiveSlabDiscountCode->name??'' }} @endif" placeholder="Enter Coupon code" id="getDiscountCode">
            <span class="btn btn-info" type="#" id="ApplyDiscount">Apply</span>
         </div>
         <span class="text-danger" id="coupon_error"></span>
      </div>
      <div class="price__items">
         <div class="crttitle">PRICE SUMMARY</div>
         <!-- <div class="greenbadeg mt-0 DiscountSuccess">Discount Applied!!</div> -->
         <div class="crtlsttext"><span>Total MRP (Inc. of Taxes)</span><span> ₹ {{ \Cart::subtotal(2, '.', '') }} </span></div>
         <div class="crtlsttext"><span>Shipping Fee</span><span id="shippingCharge"> ₹ 00 </span></div>
         <div class="crtlsttext"><span>Cart Discount</span><span class="getDiscountAmount" style="color: rgb(9, 181, 9);">- ₹ {{@$decryptDisAmount ?? '0.00'}} </span></div>
         <div class="crtlsttext cod_div" style="display:none;"><span>Cod Charge</span><span class="getCodAmount" style="float:right"> ₹ 0.00 </span></div>
         <div class="crtlsttext"><span>Subtotal</span><span> <b class="getTotalAmount">₹ {{ @$decryptAmount ?? \Cart::subtotal(2, '.', '') }} </b> </span>
         </div>
         <div class="greenbadeg DiscountSuccess">You are saving ₹ <b class="getDiscountAmount">0.00</b> on this order</div>
         <!--payment start----->
         <div class="custom-radio-button">
            <div>
               <input type="radio" id="payonline" name="payment_term" required value="Prepaid" checked="">
               <label for="payonline" id="rzp-button1">
               <span></span>  Online Pay <i class="fas fa-money-check"></i>
               </label>
               <form name='razorpayform' action="/pay/verify" method="POST">
                   <input type="hidden" name="_token" value="{{ csrf_token() }}">
                   <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                   <input type="hidden" name="razorpay_signature" id="razorpay_signature">
                   <input type="hidden" name="razorpay_order_id" id="razorpay_order_id" value="<?php echo request()->order_id ?>">
               </form>
            </div>
            <div>
               <input type="radio" id="paycod" name="payment_term" required value="COD">
               <label for="paycod">
                 <span></span> Cash On Delivery <i class="fas fa-truck"></i>
               </label>
            </div>
         </div>
         <!--payment end----->
         <div class="total__amount">
            <div class="row p_lr_8">
               <input type="hidden" name="discount_code" id="discount_code" value="{{@$decryptCode}}">
               <input type="hidden" name="discount_amount" class="getDiscountAmount" value="{{@$decryptDisAmount}}">
               <input type="hidden" id="paybleTotal" name="total_payable" value="{{ @$decryptAmount ?? \Cart::priceTotal(2, '.', '') }}">
               <input type="hidden" name="shipping_amount" id="getShippingCharge" value="0">
               <input type="hidden" name="total_amount" id="getFinalAmount" value="{{ @$decryptAmount ?? \Cart::priceTotal(2, '.', '') }}">
               <div class="col-5 p_lr_8">
                  <div style="font-weight: 700; color: #000000; font-size: 22px;line-height: 22px;">₹<span class="getTotalAmount" style="font-weight: 700; color: #000000; font-size: 22px;line-height: 22px;">{{ @$decryptAmount ?? \Cart::priceTotal(2, '.', '') }}</span></div>
                  <div style="font-size: 13px;">Total Amount</div>
               </div>
               @if(!empty(auth()->user()))
               <div class="col-7 p_lr_8">
                  <button type="submit" class="checkout_fixedbtn">
                     <i class="czi-card font-size-lg mr-2"></i>Place Order
                  </button>
               </div>
               @endif
            </div>
         </div>
      </div>
   </div>
   <!-- Mobile Button -->
   <div class="mobile_section mt-4">
      <div class="row p_lr_8">
         <div class="col-5 p_lr_8">
            <b class="text-heading"> ₹<span class="getTotalAmount"> {{ @$decryptAmount ?? \Cart::priceTotal(2, '.', '') }}</span></b>
            <div class="font-size-sm">Total Amount</div>
         </div>
         @if(!empty(auth()->user()))
         <div class="col-7 p_lr_8">
            <button type="submit" class="checkout_fixedbtn">
               <i class="czi-card font-size-lg mr-2"></i>Place Order
            </button>
         </div>
         @endif
      </div>
   </div>
   <!--  End Mobile Button  -->
</div>