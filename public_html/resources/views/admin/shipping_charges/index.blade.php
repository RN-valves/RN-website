@extends('admin.layout')
@section('seo_title')
<title>Shipping Weight Charges Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Shipping Weight Charges</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3 table-responsive">
      <table class="table table-striped table-hover table-bordered table-sm">
         <tr>
            <th>#</th>
            <th>w_0_100gm</th>
            <th>w_101_200gm</th>
            <th>w_201_400gm</th>
            <th>w_401_600gm</th>
            <th>w_601_1000gm</th>
            <th>w_1001_1500gm</th>
            <th>w_1501_2000gm</th>
            <th>w_2001_2500gm</th>
            <th>w_2501_3000gm</th>
            <th>w_3001_4000gm</th>
            <th>w_4001_5000gm</th>
            <th>w_5001_10000gm</th>
            <th>w_10001_20000gm</th>
            <th>w_20001_40000gm</th>
            <th>Status</th>
            <th width="280px">Action</th>
         </tr>
         @foreach($shippingCharges??'' as $shippingCharge)
         <tr>
            <td>{{ $shippingCharge->id??'' }}</td>
            <td>{{ $shippingCharge->w_0_100gm??0 }}</td>
            <td>{{ $shippingCharge->w_101_200gm??0 }}</td>
            <td>{{ $shippingCharge->w_201_400gm??0 }}</td>
            <td>{{ $shippingCharge->w_401_600gm??0 }}</td>
            <td>{{ $shippingCharge->w_601_1000gm??0 }}</td>
            <td>{{ $shippingCharge->w_1001_1500gm??0 }}</td>
            <td>{{ $shippingCharge->w_1501_2000gm??0 }}</td>
            <td>{{ $shippingCharge->w_2001_2500gm??0 }}</td>
            <td>{{ $shippingCharge->w_2501_3000gm??0 }}</td>
            <td>{{ $shippingCharge->w_3001_4000gm??0 }}</td>
            <td>{{ $shippingCharge->w_4001_5000gm??0 }}</td>
            <td>{{ $shippingCharge->w_5001_10000gm??0 }}</td>
            <td>{{ $shippingCharge->w_10001_20000gm??0 }}</td>
            <td>{{ $shippingCharge->w_20001_40000gm??0 }}</td>
            <td>{{ $shippingCharge->status??'' }}</td>
            <td>
               @can('shipping_charge-edit')
               <a class="btn btn-primary btn-sm" href="{{ route('shippingCharges.edit', $shippingCharge) }}">
               <i class="bx bx-edit-alt"></i> 
               </a>
               @endcan
            </td>
         </tr>
         @endforeach
      </table>
   </div>
</div>
<style type="text/css">
   td{
      font-size:20px;
   }
</style>
@endsection