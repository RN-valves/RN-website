@extends('admin.layout')
@section('seo_title')
<title>Colors</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Colors</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h2>
               <div class="float-end mb-1">
                  @can('color-create')
                     <a class="btn btn-success btn-sm" href="{{ route('colors.create') }}"> <i class="bx bx-add-to-queue"></i> Create New Color</a>
                  @endcan
               </div>
            </h2>
         </div>
         <div class="clearfix"></div>
         <livewire:color-index/>
      </div>
   </div>
</div>
@endsection
@section('scripts')
@endsection