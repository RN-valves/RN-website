@extends('admin.layout')
@section('seo_title')
<title>Sizes</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Sizes</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h2>
               <div class="float-end mb-1">
                  @can('size-create')
                     <a class="btn btn-success btn-sm" href="{{ route('sizes.create') }}"> <i class="bx bx-add-to-queue"></i> Create New Size</a>
                  @endcan
               </div>
            </h2>
         </div>
         <div class="clearfix"></div>
          <livewire:size-index/>
      </div>
   </div>
</div>
@endsection
@section('scripts')
@endsection