@can('order-edit')
@if(!in_array($order->status, ['Completed', 'Cancelled']))
<div class="col-lg-12">
   <div class="card-title border px-2 bg-light">
      <h5 class="mb-0">
         <strong class="text-dark">How was this order fulfilled?</strong>
      </h5>
   </div>
   <div class="card">
      <div class="card-body p-3">
         <div class="row mb-3">
            <div class="col-md-3">
               <strong>Type:</strong>
               <span class="badge @if($order->isStorePickup()) bg-info @else bg-secondary @endif ms-1">
                  {{ $order->fulfillment_type ?? 'Delivery (Parcel)' }}
               </span>
            </div>
            <div class="col-md-3">
               <strong>Payment:</strong>
               <span class="badge @if($order->isPaid()) bg-success @else bg-danger @endif ms-1">
                  {{ $order->isPaid() ? 'Received' : 'Pending' }}
               </span>
            </div>
            <div class="col-md-3">
               <strong>Status:</strong>
               <span class="badge bg-dark ms-1">{{ $order->status }}</span>
            </div>
            @if(!empty($order->payment_note))
            <div class="col-md-3">
               <strong>Note:</strong> {{ $order->payment_note }}
            </div>
            @endif
         </div>

         <div class="row g-4">
            {{-- OPTION 1: Customer collected from shop --}}
            <div class="col-lg-6">
               <div class="border rounded p-3 h-100">
                  <h6 class="text-info"><i class="bx bx-store"></i> Option 1 — Customer collected from shop</h6>
                  <p class="text-muted small mb-2">One click: marks pickup + payment (if needed) + <strong>Completed</strong>. No Shipway.</p>
                  <form method="POST" action="{{ route('orders.completeStorePickup', $order) }}" class="confirm-form">
                     @csrf
                     @if(!$order->isPaid())
                     <input type="text" name="payment_note" class="form-control form-control-sm mb-2" placeholder="Payment note if paid at shop (Cash/UPI)" maxlength="500">
                     @endif
                     <button type="submit" class="btn btn-info btn-sm w-100"
                        onclick="return confirm('Customer collected order from shop? This will mark order as Completed.');">
                        <i class="bx bx-check-double"></i> Customer Collected from Shop
                     </button>
                  </form>
               </div>
            </div>

            {{-- OPTION 2: Sent by parcel / Shipway --}}
            <div class="col-lg-6">
               <div class="border rounded p-3 h-100">
                  <h6 class="text-primary"><i class="bx bx-package"></i> Option 2 — Sent by parcel (Shipway / courier)</h6>
                  <p class="text-muted small mb-2">
                     @if(!$order->isPaid())
                        <strong>Step 1:</strong> Mark payment received first (if paid offline).<br>
                     @endif
                     <strong>@if(!$order->isPaid()) Step 2 @else Step 1 @endif:</strong> Use <em>Process Order</em> section below to add box size &amp; generate Shipway label.<br>
                     <strong>@if(!$order->isPaid()) Step 3 @else Step 2 @endif:</strong> Update status using parcel buttons below (In-Transit → Delivered → Completed).
                  </p>
                  @if(!$order->isPaid())
                  <form method="POST" action="{{ route('orders.markPaymentReceived', $order) }}" class="confirm-form">
                     @csrf
                     <input type="text" name="payment_note" class="form-control form-control-sm mb-2" placeholder="Payment note (Cash/UPI/bank)" maxlength="500">
                     <button type="submit" class="btn btn-success btn-sm w-100 mb-2"
                        onclick="return confirm('Confirm payment received?');">
                        <i class="bx bx-check-circle"></i> Mark Payment Received
                     </button>
                  </form>
                  @else
                  <p class="small text-success mb-0"><i class="bx bx-check"></i> Payment done — use Shipway section below, then update parcel status.</p>
                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endif
@endcan
