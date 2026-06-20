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
            <!-- <div class="col-lg-4 form-group">
               <label class="mb-2">Transport Name</label>
               <input type="text" class="form-control shadow-none" name="transport_name" value="{{ old('transport_name', @$order->orderTransort->transport_name) }}">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('transport_name')" />
            </div>
            <div class="col-lg-4 form-group">
               <label class="mb-2">Transport Contact No.</label>
               <input type="text" class="form-control shadow-none" name="transport_contact" value="{{ old('transport_contact', @$order->orderTransort->transport_contact) }}">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('transport_contact')" />
            </div>
            <div class="col-lg-4 form-group">
               <label class="mb-2">Transport Tracking URL</label>
               <input type="text" class="form-control shadow-none" name="transport_url" value="{{ old('transport_url', @$order->orderTransort->transport_url) }}">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('transport_url')" />
            </div>
            <div class="col-lg-4 form-group">
               <label class="mb-2">Transport Tracking ID</label>
               <input type="text" class="form-control shadow-none" name="order_tracking_id" value="{{ old('order_tracking_id', @$order->orderTransort->order_tracking_id) }}">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('order_tracking_id')" />
            </div>
            <div class="col-lg-4 form-group">
               <label class="mb-2">Upload Courier Slip</label>
               <input type="file" class="form-control shadow-none" name="attachment">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('attachment')" />
               @if(!empty($order->orderTransort->attachment))
               <a target="_blank" href="{{ url($order->orderTransort->attachment??'') }}">Download</a>
               @endif
            </div>
            <div class="col-lg-4 form-group">
               <label class="mb-2">Upload Invoice</label>
               <input type="file" class="form-control shadow-none" name="invoice">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('invoice')" />
               @if(!empty($order->invoice))
               <a target="_blank" href="{{ url($order->invoice??'') }}">Download</a>
               @endif
            </div> -->
            <div class="col-md-12 form-group mt-3">
               <button type="submit" class="btn btn-dark btn-block" id="btn-submit">Save Details</button>
            </div>
         </form>
      </div>
   </div>
</div>