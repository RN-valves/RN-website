<div class="col-md-7 col-lg-8">
   <div>
      <!---Step 2--->
      <div class="check_tbs_box">
         <div class="head_section">Order #RNOD00{{ $order['id'] }}</div>
         <div class="estimated_pro_list">
            <div class="order_del_step">
               <div class="steps steps-dark">
                  <!-- Step: -->
                  @php
                  $statuses = App\Models\OrderLog::orderLogStatuses($order->id);
                  @endphp
                  @foreach($statuses??'' as $status)
                  @php 
                  $getOrderLogStatus = App\Models\OrderLog::getOrderLogStatus($order->id, $status);
                  @endphp
                  <a class="step-item active">
                     <div class="step-label">
                        {{ $status??'' }}
                     </div>
                     <div class="step-progress">
                        <span class="step-count"></span>
                     </div>
                     @if(!empty($getOrderLogStatus))
                     <small>{{ $getOrderLogStatus->created_at->format('d M Y') }}</small>
                     @endif
                  </a>
                  @endforeach
                  <!-- Step: -->
               </div>
            </div>
            @if(empty($order->is_payment))
            <div class="cart_item_grid">
               <div class="inside_d_flex">
                  <div class="page_cart_info">
                     <div class="mini_cart_body">
                        <h5 class="mini_cart_title mg__0 mb__5">You have not complete Payment</h5>
                     </div>
                  </div>
                  @if(empty($order->is_payment) && !empty(App\Models\Payment::getPaymentUrl($order->pay_link_id)->short_url))
                  <div class="">
                     <a href="{{ url(App\Models\Payment::getPaymentUrl($order->pay_link_id)->short_url??'') }}" class="btn btn-warning btn-sm">
                        Click to Complete
                     </a>
                  </div>
                  @endif
               </div>
            </div>
            @endif
            <!--item-->
            @if($order['order_items']->count()>0)
            @foreach($order['order_items']??'' as $item)
            <?php  $getSingleProId = App\Models\Product::getSingleProId($item->product_id); ?> 
            <div class="cart_item_grid">
               <div class="inside_d_flex">
                  <div class="page_cart_info">
                     <div class="mini_cart_body">
                        <h5 class="mini_cart_title mg__0 mb__5"><a href="{{ route('productList', $getSingleProId->url_key) }}">{{ substr($getSingleProId->name??'', 0, 55) }}..</a>   
                           <span>{{ $getSingleProId->article??'' }}</span>
                        </h5>
                        <div class="common_price_style">
                           ₹{{ $getSingleProId->in_mrp??'' }} 
                           <span class="alrttexttt text-dark">  x {{ $item->total_qty }} = {{ $getSingleProId->in_mrp * $item->total_qty }}</span>
                        </div>
                        <div class="mini_cart_actions d-flex">
                           <div class="prosize">Size: <b>{{ $item->product_size??'' }}</b></div>
                        </div>
                     </div>
                  </div>
                  <div class="cart_pro_thunbxx">
                     <a href="{{ route('productList', $getSingleProId->url_key) }}">
                     <img class="" src="{{ url($getSingleProId->image??'') }}" alt="{{ $getSingleProId->name??'' }}">
                     </a>
                  </div>
               </div>
            </div>
            @endforeach
            @endif
            <!--item end-->
         </div>
      </div>
      <div class="price__items mt-4 mb-0">
         <div class="crttitle">NEED HELP WITH YOUR ORDER?</div>
         <div class="dlevry_address">
           {{-- @if($order->status=="Pending" || $order->status=="Status Pending" ||  $order->status=="Shipment Booked") 
            <a href="#" data-toggle="modal" data-target="#cancel_order_popup" class="btnnnnlinks">Cancel <i class="fas fa-chevron-right rgt_icon"></i></a>
            @endif --}}
            <a href="" class="btnnnnlinks">Help and Support <i class="fas fa-chevron-right rgt_icon"></i></a>
         </div>
      </div>
   </div>
</div>
@include('profile.partials.order_cancel_form')