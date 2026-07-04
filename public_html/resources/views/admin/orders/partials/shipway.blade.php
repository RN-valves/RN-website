
@if(($order->is_payment == 1 || $order->is_payment == 'Complete') && !$order->skipsShipway())
<div class="col-lg-12">
   <div class="card-title border px-2">
      <h5 class="mb-0">
         <strong class="text-dark">Process Order</strong>
      </h5>
   </div>
   <div class="card">
      <div class="card-body p-2">
         <form class="row confirm-form" method="POST" action="{{route('orders.carrier.assign')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="order_id" value="{{@$order->id}}">
            <div class="col-lg-2 form-group">
               <label class="mb-2">Package Length (CM)</label>
               <input type="text" class="form-control shadow-none" id="box_length" oninput="validateNumber(this)" name="box_length" {{$order->package_length > 0 ? 'disabled':''}} value="{{ old('box_length', @$order->package_length) }}">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('box_length')" />
            </div>
            <div class="col-lg-2 form-group">
               <label class="mb-2">Package Breadth (CM)</label>
               <input type="text" class="form-control shadow-none" id="box_breadth" oninput="validateNumber(this)" name="box_breadth" {{$order->package_breadth > 0 ? 'disabled':''}} value="{{ old('box_breadth', @$order->package_breadth) }}">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('box_breadth')" />
            </div>
            <div class="col-lg-2 form-group">
               <label class="mb-2">Package Height (CM)</label>
               <input type="text" class="form-control shadow-none" id="box_height" oninput="validateNumber(this)" name="box_height" {{$order->package_height > 0 ? 'disabled':''}} value="{{ old('box_height', @$order->package_height) }}">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('box_height')" />
            </div>
            <div class="col-lg-2 form-group">
               <label class="mb-2">Package Weight (Kg)</label>
               <input type="text" class="form-control shadow-none" id="box_weight" oninput="validateNumber(this)" name="box_weight" {{$order->package_weight > 0 ? 'disabled':''}} value="{{ old('box_weight', @$order->package_weight) }}">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('box_weight')" />
            </div>
      
            @if($order->delivery_charge == 0)
            <div class="col-lg-2 form-group mt-4">
                <button type="button" class="btn btn-sm btn-warning" id="calculate_btn">Calculate</button>
            </div>
            <div class="col-lg-4 form-group">
               <label class="mb-2">Courier</label>
               <select class="form-control" id="carrier_id" name="carrier_id" required >
                   <option value="">Select Courier</option>
               </select>
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('status')" />
            </div>
            <input type="hidden" name="courier_name" id="courier_name">
            <input type="hidden" name="delivery_charge" id="delivery_charge">
            <input type="hidden" name="cod_charge" id="cod_charge">
        
            <div class="col-md-12 form-group mt-3">
               <button type="submit" class="btn btn-primary btn-block" id="btn-submit">Generate Label</button>
            </div>
           @else
            <div class="col-6">
                <div class="table-responsive mt-4">
                   <table class="table table-bordered">
                      <tr>
                         <th>Carrier ID</th>
                         <td>{{ $order->orderTransort->carrier_id??'' }}</td>
                      </tr>
                      <tr>
                         <th>Courier Name</th>
                         <td>{{ @$order->orderTransort->transport_name??'' }}</td>
                      </tr>
                      <tr>
                         <th>Delivery Charge</th>
                         <td>₹{{ $order->delivery_charge??'' }}</td>
                      </tr>
                      <tr>
                         <th>GST Charge</th>
                         <td>₹{{ $order->gst_charge??'' }}</td>
                      </tr>
                      @if($order->payment_term == 'COD')
                        <tr>
                         <th>COD Charge</th>
                         <td>₹{{ $order->cod_charge }}</td>
                      </tr>
                      @endif
                      <tr>
                       <th>Total Delivery Amount</th>
                       <td><span class="bold-span">₹{{ $order->total_delivery_charge }}</span></td>
                    </tr>
                     
                   </table>
                </div>

            </div>
            @endif
         </form>
      </div>
   </div>
</div>
@endif