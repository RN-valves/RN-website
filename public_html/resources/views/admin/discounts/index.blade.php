@extends('admin.layout')
@section('seo_title')
<title>Discount Code Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Discount Codes</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h2>
               <div class="float-end">
                  @can('discount-create')
                     <a class="btn btn-success btn-sm" href="{{ route('discounts.create') }}"> <i class="bx bx-add-to-queue"></i> Create New discount</a>
                  @endcan
               </div>
            </h2>
         </div>
      </div>
      <livewire:discount-index/>
   </div>
</div>
@endsection
@section('scripts')
@endsection