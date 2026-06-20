@extends('admin.layout')
@section('seo_title')
<title>Discount</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Discount</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h2>
               <small>Discount Details - #DS{{ $discount->id??'' }}</small>
               <div class="float-end">
                  <div class="">
                     @can('discount-edit')
                     <a class="btn btn-primary btn-sm" href="{{ route('discounts.edit', $discount) }}"> <i class="bx bx-edit-alt"></i> Edit discount</a>
                     @endcan
                     @can('discount-list')
                     <a class="btn btn-warning btn-sm" href="{{ route('discounts.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>
                     @endcan
                  </div>
               </div>
            </h2>
         </div>
         <div class="clearfix"></div>
         <div class="row">
            <div class="col-lg-6">
               <div class="card">
                  <div class="card-header py-2">
                     <p class="mb-0">{{ $discount->name??'' }}</p>
                  </div>
                  <div class="card-body">
                     <table class="table table-bordered table-striped">
                        <tr>
                           <th>Discount Name</th>
                           <td>{{ $discount->name??'' }}</td>
                        </tr>
                        <tr>
                           <th>Discount Type</th>
                           <td class="bg-warning">{{ $discount->type??'' }}</td>
                        </tr>
                        <tr>
                           <th>Discount Status</th>
                           <td>{{ $discount->status??'' }}</td>
                        </tr>
                        <tr>
                           <th>Discount Start At</th>
                           <td>₹{{ $discount->start_value??0 }}</td>
                        </tr>
                        <tr>
                           <th>Discount End At</th>
                           <td>₹{{ $discount->end_value??0 }}</td>
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
<style type="text/css">
   th{
      font-size:20px;
      font-weight:700;
   }
   td{
      font-size:20px;
   }
</style>
@endsection