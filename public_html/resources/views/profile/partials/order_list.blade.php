@php
$user = auth()->user();
@endphp
<div class="col-md-10 col-lg-9">
   <div class="table-responsive">
      <table class="table table-bordered" style="font-size:12px;">
         <thead>
            <tr>
               <th class="text-center">Order</th>
               <th class="text-center">Value</th>
               <th class="text-center">Action</th>
               <th class="text-center" style="width:50px;">VIEW</th>
            </tr>
         </thead>
         <tbody style="font-size:13px !important;">
            @foreach($user->orders->sortByDesc('id')??'' as $order)
            <tr>
               <td class="text-center">
                  <a href="{{ route('customer_order_detail', $order) }}" class="text-primary">#RNOD00{{ $order->id }}<br>
                  <strong>{{ $order->created_at->format('d M Y')??'NA' }}</strong>
                  </a>
               </td>
               <td class="text-center">
                  <strong>₹ {{ $order->total_amount??'NA' }}</strong><br>
                  <span>{{ $order->status??'NA' }}</span>
               </td>
               <td class="text-center">
                  @if(!empty($order->is_payment))
                  <span class="text-success">Completed</span>
                  @else
                  <a target="_blank" href="{{ url(App\Models\Payment::getPaymentUrl($order->pay_link_id)->short_url??'') }}">Complete Payment<i class="czi-card flaticon-next font-size-sm"></i></a>
                  @endif
               </td>
               <td class="text-center">
                  <a href="{{ route('customer_order_detail', $order) }}">
                  <i class="fa fa-eye"></i> <br> Details</a>
               </td>
            </tr>
            @endforeach
         </tbody>
      </table>
   </div>
</div>
<!--end cart section-->