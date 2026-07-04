@extends('admin.layout')
@section('seo_title')
<title>Order Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Order Details</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h4>
               #RNOD{{ $order->id }}
               <div class="float-end">
                  @can('order-list')
                  <a class="btn btn-warning btn-sm" href="{{ route('orders.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>
                  <a class="btn btn-outline-danger btn-sm" href="{{ route('generate_order_pdf', $order) }}"> <i class="bx bxs-file-pdf"></i> Download Order PDF</a>
                  @if($order->delivery_charge > 0 && $order->manifest_ids == 0)
                  <form action="{{ route('orders.generate.manifest') }}" method="post">
                     @csrf
                     <input type="hidden" value="{{$order->id}}" name="order_ids">
                     <button class="btn btn-outline-danger btn-sm"> <i class="bx bxs-file-pdf"></i> Generate Manifest</button>

                  </form>
                  @endif
                  @endcan
                  @can('order-edit')
                  @if($order->status=="Pending")
                  <a class="btn btn-dark btn-sm" href="{{ route('orders.edit', $order) }}"> Edit Order <i class="bx bx-edit"></i></a>
                  @endif
                  @endcan
               </div>
            </h4>
         </div>
      </div>
      <div class="clearfix"></div>
      <div class="row">
         <div class="col-lg-6">
            <div class="card-title border text-center">
               <h5 class="mb-0">
                  <strong class="text-dark">Personal Details</strong>
               </h5>
            </div>
            <div class="table-responsive">
               <table class="table table-bordered">
                  <tr>
                     <th>Name</th>
                     <td>{{ $order->user->name??'' }}</td>
                  </tr>
                  <tr>
                     <th>Mobile</th>
                     <td>{{ $order->user->country->code??'' }}{{ $order->user->mobile??'' }}</td>
                  </tr>
                  <tr>
                     <th>Email</th>
                     <td>{{ $order->user->email??'' }}</td>
                  </tr>
                  <tr>
                     <th>City-State-Country</th>
                     <td>{{ $order->user->city->name??'' }} - {{ $order->user->state->name??'' }} - {{ $order->user->country->name??'' }}</td>
                  </tr>
                  <tr>
                     <th>Pincode</th>
                     <td>{{ $order->user->zipcode??'' }}</td>
                  </tr>
                  <tr>
                     <th>UUID</th>
                     <td>{{ $order->user->user_code??'' }}</td>
                  </tr>
               </table>
            </div>
         </div>
         <div class="col-lg-6">
            <div class="card-title border text-center">
               <h5 class="mb-0">
                  <strong class="text-dark">Shipping Details</strong>
               </h5>
            </div>
            <div class="table-responsive">
               <table class="table table-bordered">
                  <tr>
                     <th>Name</th>
                     <td>{{ $order->name??'' }}</td>
                  </tr>
                  <tr>
                     <th>Mobile</th>
                     <td>{{ $order->mobile??'' }}</td>
                  </tr>
                  <tr>
                     <th>Email</th>
                     <td>{{ $order->email??'' }}</td>
                  </tr>
                  <tr>
                     <th>City-State</th>
                     <td>{{ $order->city??'' }} - {{ $order->state??'' }}</td>
                  </tr>
                  <tr>
                     <th>Pincode</th>
                     <td>{{ $order->zipcode??'' }}</td>
                  </tr>
                  <tr>
                     <th>Booking Address</th>
                     <td>{{ $order->booking_address??'' }}</td>
                  </tr>
               </table>
            </div>
         </div>
         <div class="col-lg-12">
            <div class="card-title border text-center">
               <h5 class="mb-0">
                  <strong class="text-dark">Order Details</strong>
               </h5>
            </div>
            <div class="table-responsive">
               <table class="table table-bordered">
                  <tr>
                     <th>Order Number</th>
                     <td>#OD{{ $order->id??0 }}</td>
                     <th>Order Unique Id</th>
                     <td>{{ $order->uuid??'' }}</td>
                  </tr>
                  <tr>
                     <th>Discount Code</th>
                     <td>{{ $order->discount_code??'' }}</td>
                     <th>Discount Amount</th>
                     <td><span class="bold-span text-success">₹{{ $order->discount_amount??0 }}</span></td>
                  </tr>
                  <tr>
                     <th>Shipping Amount</th>
                     <th><span class="bold-span">₹{{ $order->shipping_amount??'' }}</span></th>
                     <th>Total Amount</th>
                     <th><span class="bold-span">₹{{ $order->total_amount??0 }}</span></th>
                  </tr>
                  <tr>
                     <th>Status</th>
                     <td style="font-size: 18px;" class="@if($order->status=="Cancelled") text-white bg-danger @elseif($order->status=="Completed") bg-success text-white @endif">
                        <strong>{{ $order->status??'' }}</strong>
                     </td>
                     <th>Fulfillment</th>
                     <td><span class="bold-span">{{ $order->fulfillment_type ?? 'Delivery' }}</span></td>
                  </tr>
                  <tr>
                     <th>Is Payment?</th>
                     <td>{{ $order->isPaid() ? 'Yes' : 'No' }}</td>
                     <th>Payment Terms</th>
                     <td><span class="bold-span">{{ $order->payment_term }}</span></td>
                  </tr>
                  <tr>
                     <th>Payment Key</th>
                     <td colspan="3">{{ $order->payment_key }}</td>
                  </tr>
                  <tr>
                     <th>Note</th>
                     <td>
                        <textarea rows="6" class="form-control" disabled="">{{ $order->note }}</textarea>
                     </td>
                     @if(!empty($order->orderTransort->attachment))
                     <th>Courier Slip</th>
                     <td>
                        <a href="{{ url($order->orderTransort->attachment??'') }}" target="_blank"><img src="{{ url($order->orderTransort->attachment??'') }}" width="150px"></a>
                     </td>
                     @endif
                  </tr>
               </table>
               <table class="table table-bordered table-striped">
                  <tr>
                     <th colspan="4"><h5 class="text-center mb-0"><strong>Payment Details</strong></h5></th>
                  </tr>
                  <tr>
                     <th>Payment Link Id</th>
                     <td>{{ $order->pay_link_id??'' }}</td>
                     <th>Payment URL</th>
                     <td>
                        @if(!empty($order->pay_link_id))
                        {{ App\Models\Payment::getPaymentUrl($order->pay_link_id)->short_url??'' }} &nbsp;&nbsp;
                        <a target="_blank" href="{{ url(App\Models\Payment::getPaymentUrl($order->pay_link_id)->short_url??'') }}" class="btn btn-sm btn-dark">Click for Payment </a>
                        @endif
                     </td>
                  </tr>

                  @if(!empty($order->payment_data))
                  @php $payment_data = json_decode($order->payment_data); @endphp
                  <tr>
                     <th>Payment Id</th>
                     <td>{{ $payment_data->razorpay_payment_id??'' }} </td>
                     <th>Payment Rrf. Id</th>
                     <td>{{ $payment_data->razorpay_payment_link_reference_id??'' }} <span class="bold-span"> ({{ @$payment_data->razorpay_payment_link_status??'' }})</span></td>
                  </tr>
                  <tr>
                     <td colspan="4">{{ $order->payment_data??'' }}</td>
                  </tr>
                  @endif

                  @if(empty($order->pay_link_id))
                  <tr>
                     <td colspan="2">Generate Payment Link</td>
                     <td colspan="2">
                        <a href="{{ route('orders.generatePaymentLink', $order) }}" class="btn btn-sm btn-dark">Generate</a>
                     </td>
                  </tr>
                  @endif
               </table>
            </div>
         </div>
         <div class="col-lg-9">
            <div class="card-title border text-center">
               <h5 class="mb-0">
                  <strong class="text-dark">Order Products Detail</strong>
               </h5>
            </div>
            <div class="table-responsive">
               <table class="table table-bordered">
                  <tr>
                     <th>Id</th>
                     <th>OrderId</th>
                     <th>Product Name</th>
                     <th>Product Code</th>
                     <th>Color</th>
                     <th>Size</th>
                     <th>Price</th>
                     <th>LBH-Weight</th>
                     <th>Qty</th>
                     <th>Amount</th>
                     <th>Date</th>
                  </tr>
                  @foreach($order->order_items??'' as $item)
                  <tr>
                     <td>{{ $item->id }}</td>
                     <td>{{ $item->order_id }}</td>
                     <td>{{ $item->product->name??'' }}</td>
                     <td>{{ $item->product_code }}</td>
                     <td>{{ $item->product_color }}</td>
                     <td>{{ $item->product_size }}</td>
                     <td>{{ $item->price }}</td>
                     <td>{{ $item->product_lbh_weight_gm }}</td>
                     <td>{{ $item->total_qty }}</td>
                     <td>{{ $item->total_amount }}</td>
                     <td>{{ $item->created_at->format('d M Y') }}</td>
                  </tr>
                  @endforeach
               </table>
            </div>
         </div>
         <div class="col-lg-3">
            <div class="card-title border text-center">
               <h5 class="mb-0">
                  <strong class="text-dark">Order Logs</strong>
               </h5>
            </div>
            <div class="table-responsive" style="max-height: 400px; overflow-y: scroll;">
               <table class="table table-bordered">
                  @foreach($order->orderLogs->sortByDesc('id')??'' as $log)
                  <tr>
                     <td>
                        {{ $log->user_name??'' }} <br>
                        {{ $log->created_at->format('d M Y, H:i:s') }} <br>
                        <strong>{{ $log->change_value??'' }}</strong> ({{ $log->change_type??'' }})
                     </td>
                  </tr>
                  @endforeach
               </table>
            </div>
         </div>
         @if(!empty($order->order_cancel_log))
         <div class="col-lg-12">
            <div class="card-title border text-center">
               <h5 class="mb-0">
                  <strong class="text-dark">Order Cancel Detail</strong>
               </h5>
            </div>
            <div class="table-responsive">
               <table class="table table-bordered">
                  <tr>
                     <th>Order Cancel By</th>
                     <td>{{ @$order->order_cancel_log->user_name??'' }} </td>
                     <th>Select Reason</th>
                     <td class="bg-danger text-white">{{ @$order->order_cancel_log->selected_reason??'' }}</td>
                  </tr>
                  <tr>
                     <th colspan="2">Text Cancel Reason</th>
                     <td colspan="2">{{ @$order->order_cancel_log->cancel_reason_text??'' }}</td>
                  </tr>
               </table>
            </div>
         </div>
         @endif

         <div class="col-lg-12">
            <div class="card-title border text-center">
               <h5 class="mb-0">
                  <strong class="text-dark">Transport Details</strong>
               </h5>
            </div>
            <div class="table-responsive">
               <table class="table table-bordered">
                  <tr>
                     <th>Transport Name</th>
                     <td>{{ @$order->orderTransort->transport_name??'' }} </td>
                     <th>Transport Contact</th>
                     <td>{{ @$order->orderTransort->transport_contact??'' }}</td>
                     <th>Transport Tracking URL</th>
                     <td>{{ @$order->orderTransort->transport_url??'' }}</td>
                  </tr>
                  <tr>
                     @if(!empty($order->orderTransort->attachment))
                     <th>Transport Slip</th>
                     <td><a target="_blank" href="{{ url($order->orderTransort->attachment??'https://rnvalves.shipway.com/track') }}">Download</a></td>
                     @endif

                     <th>Transport Tracking ID</th>
                     <td>{{ @$order->orderTransort->order_tracking_id??'' }}</td>
                     @if(!empty($order->orderTransort->created_at))
                     <th>Created Date</th>
                     <td>{{ @$order->orderTransort->created_at->format('d M Y, H:i:s')??'' }}</td>
                     @endif
                  </tr>
               </table>
            </div>
         </div>

         @include('admin.orders.partials.order_admin_actions')

         @include('admin.orders.partials.shipway')

         @include('admin.orders.partials.order_status')
      </div>
   </div>
</div>
<style type="text/css">
   .bold-span{font-size:20px;font-weight: bold;}
</style>
@endsection
@section('scripts')
<script>
$(document).ready(function () {
   $(".confirm-form").submit(function (e) {
      $("#btn-submit").attr("disabled", true);
      return true;
         
   });

   $(document).on('click', '#calculate_btn', function() {
    var order_id = "{{$order->id}}";
    var length = parseFloat($('#box_length').val()) || 0;
    var breadth = parseFloat($('#box_breadth').val()) || 0;
    var height = parseFloat($('#box_height').val()) || 0;
    var weight = parseFloat($('#box_weight').val()) || 0;

      if (length > 0 && breadth > 0 && height > 0 && weight > 0) {
        $.ajax({
            url: "{{ route('orders.carrier.rate') }}",
            type: "GET",
            data: {
                length: length,
                breadth: breadth,
                height: height,
                weight: weight,
                order_id: order_id
            },
            success: function(data) {
                console.log(data);
                $('#carrier_id').empty().append(data.html)
            },
            error: function(xhr) {
                alert("Error: " + xhr.responseText);
            }
        });
      }
   });
   
   $(document).on('change', '#carrier_id', function () {
      let selectedOption = $(this).find(':selected');
      let courierName = selectedOption.data('courier-name'); 
      let deliveryCharge = selectedOption.data('delivery-charge');
      let codCharge = selectedOption.data('cod-charge');
      
      $('#courier_name').val(courierName);
      $('#delivery_charge').val(deliveryCharge);
      $('#cod_charge').val(codCharge);
   });
});
</script>
@endsection