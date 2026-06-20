@extends('admin.layout')
@section('seo_title')
<title>Payment Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Payments</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <livewire:payment-index/>
   </div>
</div>
@endsection
@section('scripts')
@endsection