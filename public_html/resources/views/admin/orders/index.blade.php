@extends('admin.layout')
@section('seo_title')
<title>Orders Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Orders</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <livewire:order-index/>
   </div>
</div>
@endsection
@section('scripts')
@endsection