@extends('admin.layout')
@section('seo_title')
<title>Page Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Pages</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      
      <livewire:page-index/>
   </div>
</div>
@endsection
@section('scripts')
@endsection