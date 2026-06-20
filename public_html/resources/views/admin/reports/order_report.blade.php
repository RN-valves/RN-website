@extends('admin.layout')
@section('seo_title')
<title>Order Report</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Order Report</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h5>Order Report</h5>
         </div>
      </div>
      <div class="col-lg-12 py-2">
         <form class="row" method="GET" action="{{ route('order.reports') }}">
            @csrf
           
            <div class="col-lg-3">
               <label for="">Select Status</label>
               <select class="js-example-basic-multiple js-states form-control" id="select_status" name="status[]" multiple="">
                  @foreach ($status as $sta)
                  <option value="{{$sta}}" @if(!empty($reqStatus)) @foreach($reqStatus as $req){{$req == $sta ? 'selected': ''}}   @endforeach @endif>{{$sta}}</option>
                  @endforeach
               </select>
            </div>
            <div class="col-lg-3">
               <label for="">Start Date</label>
               <input type="text" name="from_date" value="{{@$_REQUEST['from_date']}}" id="from_date" class="form-control" placeholder="From Date">
            </div>
            <div class="col-lg-3">
            <label for="">End Date</label>
               <input type="text" name="to_date" value="{{@$_REQUEST['to_date']}}" id="to_date" class="form-control" placeholder="End Date">
            </div>
            <div class="col-lg-3">
               <button class="btn btn-info bt-sm mt-4" type="submit"> <i class="bx bx-filter-alt"></i> Filter</button>
            </div>
         </form>
      </div>
      <table class="table table-striped table-bordered">
      @if(!empty($orders))
         <tr>
            <th colspan="6" class="text-right"><h5>Total</h5></th>
            <th colspan="6" class="text-right"><h5>₹{{$orders->sum('total_amount')}} <a href="{{ route('order.reports.export', ['from_date' => request('from_date'), 'to_date' => request('to_date'), 'status' => $reqStatus ?? '']) }}" 
               class="btn btn-sm btn-success">
                Export XLS
            </a></h5> </th>
            
         </tr>
         @endif
         <tr>
            <th>ID</th>
            <th>Created Date</th>
            <th>Delivered Date</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>State</th>
            <th>City</th>
            <th>Total Amount</th>
            <th>Is Payment</th>
            <th>Discount Code</th>
            <th>Discount</th>
            <th>Status</th>
            <th>Payment Term</th>
         </tr>
         @if(empty($orders))
         <tr>
            <td colspan="12" class="text-center">No orders found</td>
         </tr>
         @else
         @forelse($orders as $order)
            <tr>
                <td><b>RNOD{{$order->id}}</b></td>
                <td>{{$order->created_at->format('d-m-Y h:i A')}}</td>
                <td>{{$order->orderLogs->where('change_value', 'Delivered')->first()?->created_at}}</td>
                <td>{{$order->name}}</td>
                <td>{{$order->mobile}}</td>
                <td>{{$order->state}}</td>
                <td>{{$order->city}}</td>
                <td>₹{{$order->total_amount}}</td>
                <td>{{$order->is_payment == 1 ? 'Yes' : 'No'}}</td>
                <td>{{$order->discount_code}}</td>
                <td>₹{{$order->discount_amount}}</td>
                <td>{{$order->status}}</td>
                <td>{{$order->payment_term}}</td>
            </tr>
         @empty
            <tr>
                <td colspan="12" class="text-center">No orders found</td>
            </tr>
         @endforelse
         @endif
      </table>
     
   </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
$("#user_id").select2({
  theme: "classic"
});
</script>
<script type="text/javascript">
   $('#to_date').datepicker({
        weekStart: 1,
        daysOfWeekHighlighted: "6,0",
        autoclose: true,
        todayHighlight: true,
        format: "dd/mm/yyyy"
   });
   $('#from_date').datepicker({
        weekStart: 1,
        daysOfWeekHighlighted: "6,0",
        autoclose: true,
        todayHighlight: true,
        format: "dd/mm/yyyy"
   });


$("#select_status").select2({
     theme: "classic"
   });
</script>

@endsection

