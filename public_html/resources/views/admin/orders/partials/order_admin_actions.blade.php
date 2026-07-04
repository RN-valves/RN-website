@can('order-edit')
@if(!in_array($order->status, ['Completed', 'Cancelled']))
<div class="col-lg-12">
   <div class="card-title border px-2">
      <h5 class="mb-0">
         <strong class="text-dark">Payment &amp; Fulfillment</strong>
      </h5>
   </div>
   <div class="card">
      <div class="card-body p-2">
         <div class="table-responsive">
            <table class="table table-bordered mb-0">
               <tr>
                  <th width="200">Payment</th>
                  <td>
                     @if($order->isPaid())
                     <span class="badge bg-success">Received</span>
                     @else
                     <span class="badge bg-danger">Pending</span>
                     @endif
                  </td>
                  <th width="200">Fulfillment</th>
                  <td>{{ $order->fulfillment_type ?? 'Delivery' }}</td>
               </tr>
               @if(!$order->isPaid())
               <tr>
                  <th>Confirm Payment</th>
                  <td colspan="3">
                     <form method="POST" action="{{ route('orders.markPaymentReceived', $order) }}" class="row g-2 confirm-form">
                        @csrf
                        <div class="col-md-8">
                           <input type="text" name="payment_note" class="form-control form-control-sm" placeholder="Payment note (Cash / UPI / bank ref)" maxlength="500">
                        </div>
                        <div class="col-md-4">
                           <button type="submit" class="btn btn-success btn-sm w-100" onclick="return confirm('Confirm payment received?');">
                              Mark Payment Received
                           </button>
                        </div>
                     </form>
                     <small class="text-muted">Use when payment done but Razorpay link was not created.</small>
                  </td>
               </tr>
               @endif
               <tr>
                  <th>Store Pickup</th>
                  <td colspan="3">
                     <form method="POST" action="{{ route('orders.completeStorePickup', $order) }}" class="d-inline confirm-form">
                        @csrf
                        <button type="submit" class="btn btn-info btn-sm" onclick="return confirm('Customer collected from shop?');">
                           Complete — Picked Up from Shop
                        </button>
                     </form>
                     <small class="text-muted ms-2">Paid online, customer collects at shop. No Shipway.</small>
                  </td>
               </tr>
               <tr>
                  <th>Without Shipway</th>
                  <td colspan="3">
                     <form method="POST" action="{{ route('orders.completeWithoutShipway', $order) }}" class="row g-2 confirm-form">
                        @csrf
                        @if(!$order->isPaid())
                        <div class="col-md-4">
                           <input type="text" name="payment_note" class="form-control form-control-sm" placeholder="Payment note" maxlength="500">
                        </div>
                        @endif
                        <div class="col-md-{{ $order->isPaid() ? '8' : '4' }}">
                           <input type="text" name="status_note" class="form-control form-control-sm" placeholder="Delivery note (optional)" maxlength="500">
                        </div>
                        <div class="col-md-4">
                           <button type="submit" class="btn btn-primary btn-sm w-100" onclick="return confirm('Complete order without Shipway?');">
                              Complete — No Shipway
                           </button>
                        </div>
                     </form>
                     <small class="text-muted">Hand delivery / own courier. No Shipway label needed.</small>
                  </td>
               </tr>
            </table>
         </div>
      </div>
   </div>
</div>
@endif
@endcan
