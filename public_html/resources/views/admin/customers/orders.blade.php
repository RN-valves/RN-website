@extends('admin.layout')
@section('seo_title')
<title>Customer Order Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">{{ $user->name??'' }} - Orders</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body">
      <div class="row">
         @include('admin.users.partials.menu')
         @include('admin.users.partials.basic_detail')
      </div>

      <div class="col-lg-12">
         <div class="table-responsive">
            <h4>{{ $user->name??'' }} - Order List</h4>
            <table class="table table-hover table-bordered table-sm">
               <thead>
                  <tr>
                     <th>ID</th>
                     <th>OrderDate</th>
                     <th>discount_code</th>
                     <th>discount_amount</th>
                     <th>shipping_amount</th>
                     <th>total_amount</th>
                     <th>status</th>
                     <th>is_payment</th>
                     <th>payment_key</th>
                     <th>payment_term</th>
                     <th>updated_at</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($user->orders??'' as $order)
                  <tr>
                     <td>
                        @can('order-list')
                        <a href="{{ route('orders.show', $order) }}" class=""> <strong>#OD{{ $order->id??0 }}</strong></a>
                        @endcan
                     </td>
                     <td>{{ $order->created_at->format('d M Y, H:i:s')??'NA' }}</td>
                     <td>{{ $order->discount_code??'NA' }}</td>
                     <td>{{ $order->discount_amount??'NA' }}</td>
                     <td>{{ $order->shipping_amount??'NA' }}</td>
                     <td>{{ $order->total_amount??'NA' }}</td>
                     <td>{{ $order->status??'NA' }}</td>
                     <td class="@if($order->is_payment=="1") bg-success @else bg-danger @endif text-center text-white">{{ $order->is_payment ? 'Yes' : 'No'}}</td>
                     <td>{{ $order->payment_key??'NA' }}</td>
                     <td>{{ $order->payment_term??'NA' }}</td>
                     <td>{{ $order->updated_at->format('d M Y, H:i:s')??'NA' }}</td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>

@can('order-create')
   <div class="btn_btn">
      <a href="{{ route('customers.orderCreate', $user) }}" class="btn btn-success btn-sm" style="font-size: 20px!important;"><i class="bx bx-add-to-queue"></i>  Add New Order</a>
   </div>
@endcan   
<style type="text/css">
   .btn_btn{
      bottom:20px!important;
      right:20px!important;
      position: fixed;
   }
</style>    
@endsection
@section('scripts')
@endsection