<!-----right side--->
<div class="col-md-5 col-lg-4">
   <div class="pricsmmry">
     @if(!empty($order->orderTransort))
      <div class="price__items mb-3">
         <div class="crttitle">Courier Detail</div>
         <div class="dlevry_address">
            <div class="cusname text-success">{{ @$order->orderTransort->transport_name??'' }}</div>
            @if(!empty($order->orderTransort->order_tracking_id))
            <div class="cusname">
               <p class="text-muted">Tracking Id</p>
               {{ @$order->orderTransort->order_tracking_id??'' }} | <a target="_blank" href="{{ url('https://rnvalves.shipway.com/track') }}" class="text-info">Click to Track</a>
            </div>
            @endif
         </div>
      </div>
      @endif
      <div class="price__items mb-3">
         <div class="crttitle">SHIPPING DETAILS
            <span class="float-right">
               <a target="_blank" class="btn btn-outline-danger btn-sm" href="{{ route('generate_order_pdf', $order) }}"> Download PDF</a>
            </span>
         </div>
         <div class="dlevry_address">
            <div class="cusname">{{$order['name']??''}}</div>
            <div class="cusname">{{$order['mobile']??''}}</div>
            <div class="addrsss_dtls">{{$order['booking_address']??''}}</div>
         </div>
      </div>
      <div class="price__items">
         <div class="crttitle">PAYMENT SUMMARY</div>
         <div class="crtlsttext"><span>Cart Total</span><span> ₹ {{ ($order->total_amount+$order->discount_amount) - $order->shipping_amount }} </span></div>
         @if(!empty($order->discount_amount) || $order->discount_amount>0)
         <div class="crtlsttext"><span>Discount</span><span class="text-success"> <b>- ₹ {{ $order['discount_amount'] }}</b> </span></div>
         @endif
         <div class="crtlsttext"><span>Shipping Charge</span><span>  ₹ {{ $order->shipping_amount }} </span></div>
         <div class="crtlsttext"><span>Order Total</span><span> ₹ {{$order['total_amount']}} </span></div>
         <div class="total__amount">
            <div class="row p_lr_8" style="font-weight: 600; margin-bottom: 8px; color: #000000; font-size: 14px;line-height: 18px;">
               <div class="col-7 p_lr_8">Amount To Be Paid</div>
               <div class="col-5 p_lr_8">
                  <div class="text-right">₹ {{$order['total_amount']}}</div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-----right side--->