@can('order-edit')
@if($order->status != 'Cancelled' && !$order->isStorePickup())
<div class="col-lg-12">
   <div class="card-title border px-2">
      <h5 class="mb-0">
         <strong class="text-dark">Parcel / Courier Status (Shipway delivery)</strong>
      </h5>
   </div>
   <div class="card">
      <div class="card-body p-3">
         <p class="text-muted mb-3">
            Current status: <strong>{{ $order->status }}</strong>
            @if($order->hasShipwayData())
               &nbsp;|&nbsp; <span class="text-success"><i class="bx bx-check"></i> Shipway label generated</span>
               @if(!empty($order->orderTransort->order_tracking_id))
                  &nbsp;|&nbsp; AWB: <strong>{{ $order->orderTransort->order_tracking_id }}</strong>
               @endif
            @else
               &nbsp;|&nbsp; <span class="text-warning">No Shipway label yet — generate label in Process Order section above</span>
            @endif
         </p>

         <p class="mb-2"><strong>Quick update after sending parcel:</strong></p>
         <div class="d-flex flex-wrap gap-2 mb-3">
            @php
            $parcelSteps = [
               'In-Progress' => ['label' => 'Preparing', 'class' => 'warning'],
               'In-Transit' => ['label' => 'Sent / In-Transit', 'class' => 'info'],
               'Delivered' => ['label' => 'Delivered', 'class' => 'primary'],
               'Completed' => ['label' => 'Completed', 'class' => 'success'],
            ];
            @endphp
            @foreach($parcelSteps as $quickStatus => $meta)
            @if($order->status !== $quickStatus)
            <form method="POST" action="{{ route('orders.updateOrderStatus', $order) }}" class="d-inline confirm-form"
               onsubmit="return confirm('Set parcel status to {{ $meta['label'] }} ({{ $quickStatus }})?');">
               @csrf
               <input type="hidden" name="status" value="{{ $quickStatus }}">
               @if(!$order->hasShipwayData() && in_array($quickStatus, ['In-Transit', 'Delivered', 'Completed']))
               <input type="hidden" name="confirm_shipway" value="1">
               @endif
               <button type="submit" class="btn btn-sm btn-{{ $meta['class'] }}">{{ $meta['label'] }}</button>
            </form>
            @else
            <span class="btn btn-sm btn-{{ $meta['class'] }} disabled">{{ $meta['label'] }} ✓</span>
            @endif
            @endforeach
         </div>

         <form method="POST" action="{{ route('orders.updateOrderStatus', $order) }}" class="confirm-form">
            @csrf
            <div class="row g-3 align-items-end">
               <div class="col-lg-3">
                  <label class="mb-2">Or pick any status</label>
                  <select class="form-control" name="status" required>
                     @foreach(App\Models\Order::orderStatuses() as $status)
                     <option value="{{ $status }}" @selected(old('status', $order->status) == $status)>{{ $status }}</option>
                     @endforeach
                  </select>
               </div>
               <div class="col-lg-5">
                  <label class="mb-2">Note (saved in order log)</label>
                  <input type="text" class="form-control" name="status_note" value="{{ old('status_note') }}" placeholder="e.g. Sent via Delhivery AWB 123456" maxlength="500">
               </div>
               @if(!$order->hasShipwayData())
               <div class="col-lg-4">
                  <div class="form-check mt-4">
                     <input class="form-check-input" type="checkbox" name="confirm_shipway" value="1" id="confirm_shipway">
                     <label class="form-check-label" for="confirm_shipway">
                        Parcel already sent (Shipway used outside panel)
                     </label>
                  </div>
               </div>
               @endif
               <div class="col-lg-12">
                  <button type="submit" class="btn btn-dark btn-sm">Save Parcel Status</button>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
@endif
@endcan
