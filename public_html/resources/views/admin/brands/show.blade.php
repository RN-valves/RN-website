@extends('admin.layout')
@section('seo_title')
<title>Brand Details - {{ $brand->name??'' }}</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Brands</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body">
      <div class="card-header">
         Brand Details - {{ $brand->name??'' }} 
      </div>
   </div>
</div>
@endsection
@section('scripts')
@endsection