@extends('admin.layout')
@section('seo_title')
<title>Payment</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Payment</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h2>
               <div class="card-title">
                  <small>Payment Details - PY{{ $payment->id??'' }}</small>
                  
                  <div class="float-end">
                     <div class="">
                        @can('payment-list')
                        <a class="btn btn-warning btn-sm" href="{{ route('payments.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>
                        @endcan
                     </div>
                  </div>
               </div>
            </h2>
         </div>
         <div class="clearfix"></div>
         <div class="row">
            <div class="col-lg-12">
               <div class="card-body">
                  <form method="POST" class="row" action="{{ route('payments.update', $payment) }}">
                     @csrf
                     @method('PUT')
                     <div class="col-lg-12">
                        <h5>Update API Payment Status</h5>
                     </div>
                     <div class="col-lg-6 form-group">
                        <select class="form-control" name="status">
                           <option value="Resend_TXT">Resend Text Message</option>
                           <option value="Cancel">Cancel</option>
                        </select>
                     </div>
                     <div class="col-lg-6 form-group">
                        <button class="btn btn-dark" type="submit">Update Payment Status</button>
                     </div>
                  </form>
               </div>
            </div>
            <div class="col-lg-12">
               <div class="card-body">
                  <div class="table-responsive">
                     <table class="table table-bordered">
                        <tr>
                           <th>Order Id</th>
                           <td>{{ $payment->order_id??'' }}</td>
                        </tr>
                        <tr>
                           <th>Name</th>
                           <td>{{ $payment->name??'' }}</td>
                        </tr>
                        <tr>
                           <th>Mobile</th>
                           <td>{{ $payment->mobile??'' }}</td>
                        </tr>
                        <tr>
                           <th>Email</th>
                           <td>{{ $payment->email??'' }}</td>
                        </tr>
                        <tr>
                           <th>State</th>
                           <td>{{ $payment->state??'' }}</td>
                        </tr>
                        <tr>
                           <th>City</th>
                           <td>{{ $payment->city??'' }}</td>
                        </tr>
                        <tr>
                           <th>Pincode</th>
                           <td>{{ $payment->zipcode??'' }}</td>
                        </tr>
                        <tr>
                           <th>Amount</th>
                           <th style="font-size:20px;">₹{{ $payment->amount??'' }}</th>
                        </tr>
                        <tr>
                           <th>Gateway</th>
                           <td>{{ $payment->payment_gateway??'' }}</td>
                        </tr>
                        <tr>
                           <th>Payment Key</th>
                           <td>{{ $payment->payment_key??'' }}</td>
                        </tr>
                        <tr>
                           <th>Payment Id</th>
                           <td>{{ $payment->payment_id??'' }}</td>
                        </tr>
                        <tr>
                           <th>Payment Link Id</th>
                           <td>
                              {{ $payment->pay_link_id??'' }}
                           </td>
                        </tr>
                        <tr>
                           <th>Payment Short URL</th>
                           <td>
                              {{ $payment->short_url??'' }}
                              <a target="_blank" href="{{ url($payment->short_url??'') }}">Click for Payment</a>
                           </td>
                        </tr>
                        <tr>
                           <th>Payment Status</th>
                           <td class="bg-danger text-white"><strong>{{ $payment->status??'' }}</strong></td>
                        </tr>
                        <tr>
                           <th>Payment Data</th>
                           <td>{{ $payment->payment_data??'' }}</td>
                        </tr>
                        <tr>
                           <th>Payment Created At</th>
                           <td>{{ $payment->created_at->format('d M Y, H:i:s')??'' }}</td>
                        </tr>
                        <tr>
                           <th>Payment Updated At</th>
                           <td>{{ $payment->updated_at->format('d M Y, H:i:s')??'' }}</td>
                        </tr>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
$("#remark").select2({
  theme: "classic"
});
</script>
@endsection