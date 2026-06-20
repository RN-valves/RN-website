@extends('admin.layout')
@section('seo_title')
<title>Materials</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Materials</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h2>
               <div class="float-end mb-1">
                  @can('material-create')
                     <a class="btn btn-success btn-sm" href="{{ route('materials.create') }}"> <i class="bx bx-add-to-queue"></i> Create New Material</a>
                  @endcan
               </div>
            </h2>
         </div>
         <div class="clearfix"></div>
         <livewire:material-index/>
      </div>
   </div>
</div>
@endsection
@section('scripts')
@endsection