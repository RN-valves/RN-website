@extends('admin.layout')
@section('seo_title')
<title>Customer Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Customers</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h2>
               <div class="float-end">
                  @can('customer-create')
                     <a class="btn btn-success btn-sm" href="{{ route('customers.create') }}"> <i class="bx bx-add-to-queue"></i> Create New Customer</a>
                  @endcan
                  @can('customer-excel-upload')
                  <a class="btn btn-warning btn-sm" href="{{ route('customers.import_customers') }}"> <i class="bx bx-add-to-queue"></i> Import Customers</a>
                  @endcan
               </div>
            </h2>
         </div>
      </div>
      <div class="clearfix"></div>
      <livewire:user-customer/>
   </div>
</div>
@endsection
@section('scripts')
@endsection