@can('orderTransport-create')
@if($order->status=="Pending" || $order->status=="In-Progress" || $order->status=="In-Transit" || $order->status=="Delivered")
<div class="col-lg-12">
   <div class="card-title border px-2">
      <h5 class="mb-0">
         <strong class="text-dark">Order Actions</strong>
      </h5>
   </div>
   <div class="card">
      <div class="card-body p-2">
         <form class="row confirm-form" method="POST" action="{{ route('orderTransports.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <div class="col-lg-4 form-group">
               <label class="mb-2">Order Status</label>
               <select class="form-control" name="status">
               @php
               $statuses = App\Models\Order::orderStatuses();
               @endphp
               @foreach($statuses??'' as $status)
               <option value="{{ $status }}" @selected(old('status', @$order->status)==$status)>{{ $status }}</option>
               @endforeach
               </select>
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('status')" />
            </div>
            <div class="col-md-12 form-group mt-3">
               <button type="submit" class="btn btn-dark btn-block" id="btn-submit">Save Details</button>
            </div>
         </form>
      </div>
   </div>
</div>
@endif
@endcan
