@php
$reasons = App\Models\OrderCancel::get();
@endphp
<!--cancel order popup form-->
<div class="modal fade" id="cancel_order_popup"  aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog cancel_form">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">ORDER #RNOD00{{$order['id']}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form method="POST" action="{{ route('cancel_order', $order) }}" class="confirm-form">
            @csrf
            <div class="modal-body">
               <div class="cancelsuremsg mb-4">Are you sure you want to cancel this order ?</div>
               <div class="form-group">
                  <label>Reason for cancellation</label>
                  <select class="form-control" name="selected_reason" id="cancelReason" required>
                     <option value="">Select Cancellation Reason</option>
                     @foreach($reasons??'' as $reason)
                     <option value="{{ $reason->name }}">{{ $reason->name }}</option>
                     @endforeach
                  </select>
               </div>
               <div class="form-group">
                  <label>Comment</label>
                  <textarea rows="4" style="height: 100%!important;" placeholder="Enter Reason" class="form-control" name="cancel_reason_text" id="cancel_reason_text" required>{{ old('cancel_reason_text') }}</textarea>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-dark btn-lg btnCancelOrder">Cancel this order</button>
            </div>
         </form>
      </div>
   </div>
</div>
<!--cancel order popup form-->