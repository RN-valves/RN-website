@extends('admin.layout')
@section('seo_title')
<title>Category Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Categories</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <livewire:bullet-point-index/>
   </div>
</div>
@endsection
@section('scripts')
@endsection