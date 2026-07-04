@can('order-edit')
@if(!in_array($order->status, ['Completed', 'Cancelled']))
<div class="col-lg-12">
   <div class="card-title border px-2 bg-warning bg-opacity-10">
      <h5 class="mb-0">
         <strong class="text-dark">Admin — Handle This Order (choose your situation)</strong>
      </h5>
   </div>
   <div class="card border-warning">
      <div class="card-body p-3">

         <div class="row mb-3 small">
            <div class="col-md-4"><strong>Payment:</strong>
               <span class="badge @if($order->isPaid()) bg-success @else bg-danger @endif">{{ $order->isPaid() ? 'Received' : 'NOT received in system' }}</span>
            </div>
            <div class="col-md-4"><strong>Status:</strong> <span class="badge bg-dark">{{ $order->status }}</span></div>
            <div class="col-md-4"><strong>Type:</strong> {{ $order->fulfillment_type ?? 'Delivery' }}</div>
         </div>

         {{-- SCENARIO 1 --}}
         <div class="border rounded p-3 mb-3 @if(!$order->isPaid()) border-danger @else border-secondary opacity-75 @endif">
            <h6 class="mb-1">
               <span class="badge bg-danger me-1">1</span>
               Payment done but payment link not created
            </h6>
            <p class="text-muted small mb-2">
               Customer paid (cash / UPI / bank) but Razorpay link missing in system.
               Click below to confirm payment. After this you can use Shipway below OR use option 2 or 3.
            </p>
            @if(!$order->isPaid())
            <form method="POST" action="{{ route('orders.markPaymentReceived', $order) }}" class="row g-2 align-items-end confirm-form">
               @csrf
               <div class="col-md-8">
                  <input type="text" name="payment_note" class="form-control form-control-sm" placeholder="How paid? e.g. Cash, UPI ref 123456" maxlength="500">
               </div>
               <div class="col-md-4">
                  <button type="submit" class="btn btn-success btn-sm w-100" onclick="return confirm('Confirm payment is received?');">
                     Confirm Payment Received
                  </button>
               </div>
            </form>
            @else
            <p class="text-success small mb-0"><i class="bx bx-check"></i> Payment already confirmed in system.</p>
            @endif
         </div>

         {{-- SCENARIO 2 --}}
         <div class="border rounded p-3 mb-3 border-info">
            <h6 class="mb-1">
               <span class="badge bg-info me-1">2</span>
               Customer paid online — but comes to collect from shop
            </h6>
            <p class="text-muted small mb-2">
               Customer already paid on website. They come to your shop to take the order.
               One click → order <strong>Completed</strong>. No Shipway needed.
            </p>
            <form method="POST" action="{{ route('orders.completeStorePickup', $order) }}" class="confirm-form">
               @csrf
               <button type="submit" class="btn btn-info btn-sm"
                  onclick="return confirm('Customer collected order from shop? Order will be marked Completed.');">
                  <i class="bx bx-store"></i> Complete — Customer Picked Up from Shop
               </button>
            </form>
         </div>

         {{-- SCENARIO 3 --}}
         <div class="border rounded p-3 border-primary">
            <h6 class="mb-1">
               <span class="badge bg-primary me-1">3</span>
               Customer paid — but we do NOT use Shipway
            </h6>
            <p class="text-muted small mb-2">
               Payment received (or mark below). You deliver yourself / hand over / own courier — no Shipway label.
               One click → order <strong>Completed</strong>.
            </p>
            <form method="POST" action="{{ route('orders.completeWithoutShipway', $order) }}" class="row g-2 align-items-end confirm-form">
               @csrf
               @if(!$order->isPaid())
               <div class="col-md-4">
                  <input type="text" name="payment_note" class="form-control form-control-sm" placeholder="Payment note (if not paid in system)" maxlength="500">
               </div>
               @endif
               <div class="col-md-{{ $order->isPaid() ? '8' : '4' }}">
                  <input type="text" name="status_note" class="form-control form-control-sm" placeholder="How delivered? e.g. Hand delivered, own driver" maxlength="500">
               </div>
               <div class="col-md-4">
                  <button type="submit" class="btn btn-primary btn-sm w-100"
                     onclick="return confirm('Complete order without Shipway?');">
                     <i class="bx bx-check-double"></i> Complete — No Shipway
                  </button>
               </div>
            </form>
         </div>

         <p class="text-muted small mt-3 mb-0">
            <strong>Normal courier via Shipway?</strong> Use option 1 first if payment missing, then scroll to <em>Process Order</em> section below to generate label.
         </p>

      </div>
   </div>
</div>
@endif
@endcan
