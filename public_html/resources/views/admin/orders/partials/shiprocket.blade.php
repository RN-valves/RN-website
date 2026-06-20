<div class="col-lg-12">
   <div class="card-title border px-2">
      <h5 class="mb-0">
         <strong class="text-dark">Order Shipped Automatic</strong>
      </h5>
   </div>
   <div class="card">
      <div class="card-body p-2">
         <form class="row confirm-form" method="POST" action="{{ route('orders.update', $order) }}" enctype="multipart/form-data">
            @csrf
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
            <div class="col-lg-4 form-group">
               <label class="mb-2">Package Length (CM)</label>
               <input type="text" class="form-control shadow-none" name="package_length" value="{{ old('package_length', @$order->orderTransort->package_length) }}">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('package_length')" />
            </div>
            <div class="col-lg-4 form-group">
               <label class="mb-2">Package Breadth (CM)</label>
               <input type="text" class="form-control shadow-none" name="package_breadth" value="{{ old('package_breadth', @$order->orderTransort->package_breadth) }}">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('package_breadth')" />
            </div>
            <div class="col-lg-4 form-group">
               <label class="mb-2">Package Height (CM)</label>
               <input type="text" class="form-control shadow-none" name="package_height" value="{{ old('package_height', @$order->orderTransort->package_height) }}">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('package_height')" />
            </div>
            <div class="col-lg-4 form-group">
               <label class="mb-2">Package Weight (Kg)</label>
               <input type="text" class="form-control shadow-none" name="package_weight" value="{{ old('package_weight', @$order->orderTransort->package_weight) }}">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('package_weight')" />
            </div>
            <div class="col-md-12 form-group mt-3">
               <button type="submit" class="btn btn-primary btn-block" id="btn-submit">Update</button>
            </div>
         </form>
      </div>
   </div>
</div>