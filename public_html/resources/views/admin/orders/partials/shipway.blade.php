
@if(($order->is_payment == 1 || $order->is_payment == 'Complete') && !$order->skipsShipway())
<div class="col-lg-12">
   <div class="card-title border px-2 d-flex justify-content-between align-items-center">
      <h5 class="mb-0">
         <strong class="text-dark">Process Order Shipping (Shiprocket &amp; Shipway)</strong>
      </h5>
      @if($order->delivery_charge > 0 && !empty($order->orderTransort->attachment))
      <a target="_blank" href="{{ url($order->orderTransort->attachment) }}" class="btn btn-sm btn-success">
         <i class="fa fa-download"></i> Download Shipping Label
      </a>
      @endif
   </div>
   <div class="card">
      <div class="card-body p-3">
         <form class="row confirm-form" method="POST" action="{{route('orders.carrier.assign')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="order_id" value="{{@$order->id}}">

            @if($order->delivery_charge == 0)
            <div class="col-lg-12 mb-3">
               <label class="mb-2 d-block"><strong>Choose Shipping Gateway:</strong></label>
               <div class="form-check form-check-inline me-4">
                  <input class="form-check-input shipping-provider-radio" type="radio" name="shipping_provider" id="provider_shiprocket" value="shiprocket" checked>
                  <label class="form-check-label fw-bold text-primary" for="provider_shiprocket" style="cursor:pointer; font-size:15px;">
                     <strong>Shiprocket</strong>
                  </label>
               </div>
               <div class="form-check form-check-inline">
                  <input class="form-check-input shipping-provider-radio" type="radio" name="shipping_provider" id="provider_shipway" value="shipway">
                  <label class="form-check-label fw-bold text-success" for="provider_shipway" style="cursor:pointer; font-size:15px;">
                     <strong>Shipway</strong>
                  </label>
               </div>
            </div>
            @endif

            <div class="col-lg-2 form-group">
               <label class="mb-2">Package Length (CM)</label>
               <input type="text" class="form-control shadow-none" id="box_length" oninput="validateNumber(this)" name="box_length" {{$order->package_length > 0 ? 'disabled':''}} value="{{ old('box_length', @$order->package_length ?: 10) }}">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('box_length')" />
            </div>
            <div class="col-lg-2 form-group">
               <label class="mb-2">Package Breadth (CM)</label>
               <input type="text" class="form-control shadow-none" id="box_breadth" oninput="validateNumber(this)" name="box_breadth" {{$order->package_breadth > 0 ? 'disabled':''}} value="{{ old('box_breadth', @$order->package_breadth ?: 10) }}">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('box_breadth')" />
            </div>
            <div class="col-lg-2 form-group">
               <label class="mb-2">Package Height (CM)</label>
               <input type="text" class="form-control shadow-none" id="box_height" oninput="validateNumber(this)" name="box_height" {{$order->package_height > 0 ? 'disabled':''}} value="{{ old('box_height', @$order->package_height ?: 10) }}">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('box_height')" />
            </div>
            <div class="col-lg-2 form-group">
               <label class="mb-2">Package Weight (Kg)</label>
               <input type="text" class="form-control shadow-none" id="box_weight" oninput="validateNumber(this)" name="box_weight" {{$order->package_weight > 0 ? 'disabled':''}} value="{{ old('box_weight', @$order->package_weight ?: 0.5) }}">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('box_weight')" />
            </div>
      
            @if($order->delivery_charge == 0)
            <div class="col-lg-2 form-group mt-4">
                <button type="button" class="btn btn-sm btn-warning w-100" id="calculate_btn">
                   <span id="calc_text">Calculate Rates</span>
                   <span id="calc_spinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                </button>
            </div>
            <div class="col-lg-4 form-group">
               <label class="mb-2">Courier Partner</label>
               <select class="form-control" id="carrier_id" name="carrier_id" required >
                   <option value="">Select Courier (Click Calculate)</option>
               </select>
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('carrier_id')" />
            </div>
            <input type="hidden" name="courier_name" id="courier_name">
            <input type="hidden" name="delivery_charge" id="delivery_charge">
            <input type="hidden" name="cod_charge" id="cod_charge">
        
            <div class="col-md-12 form-group mt-3">
               <button type="submit" class="btn btn-primary btn-block" id="btn-submit">Generate Shipping Label</button>
            </div>
           @else
            <div class="col-lg-8 col-md-12">
                <div class="table-responsive mt-3">
                   <table class="table table-bordered">
                      <tr>
                         <th width="200">Gateway</th>
                         <td>
                            @if(str_contains(strtolower(@$order->orderTransort->transport_name ?? ''), 'shiprocket') || str_contains(strtolower(@$order->orderTransort->transport_url ?? ''), 'shiprocket'))
                               <span class="badge bg-primary text-white" style="font-size:13px;">Shiprocket</span>
                            @else
                               <span class="badge bg-success text-white" style="font-size:13px;">Shipway</span>
                            @endif
                         </td>
                      </tr>
                      <tr>
                         <th>Carrier ID / Code</th>
                         <td>{{ $order->orderTransort->carrier_id??'' }}</td>
                      </tr>
                      <tr>
                         <th>Courier Name</th>
                         <td><strong>{{ @$order->orderTransort->transport_name??'' }}</strong></td>
                      </tr>
                      <tr>
                         <th>AWB / Tracking Number</th>
                         <td>
                            <strong>{{ @$order->orderTransort->order_tracking_id??'' }}</strong>
                            @if(!empty($order->orderTransort->transport_url))
                               &nbsp;|&nbsp;<a target="_blank" href="{{ $order->orderTransort->transport_url }}" class="text-info font-weight-bold">Track Parcel</a>
                            @endif
                         </td>
                      </tr>
                      <tr>
                         <th>Delivery Charge</th>
                         <td>₹{{ $order->delivery_charge??'' }}</td>
                      </tr>
                      <tr>
                         <th>GST Charge (18%)</th>
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
                        <td><span class="bold-span text-primary">₹{{ $order->total_delivery_charge }}</span></td>
                     </tr>
                     @if(!empty($order->orderTransort->attachment))
                     <tr>
                        <th>Shipping Label PDF</th>
                        <td>
                           <a target="_blank" href="{{ url($order->orderTransort->attachment) }}" class="btn btn-sm btn-outline-success">
                              Download Label PDF
                           </a>
                        </td>
                     </tr>
                     @endif
                   </table>
                </div>
            </div>
            @endif
         </form>
      </div>
   </div>
</div>
@endif