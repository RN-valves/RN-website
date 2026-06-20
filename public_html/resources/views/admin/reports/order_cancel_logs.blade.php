@extends('admin.layout')
@section('seo_title')
<title>Order Cancel Log Report</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Order Cancel Log Report</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h5>Order Cancel Log Report</h5>
         </div>
      </div>
      <livewire:order-cancel-log-index/>
   </div>
</div>
@endsection
