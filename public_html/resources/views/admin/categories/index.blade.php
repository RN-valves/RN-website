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
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h2>
               <div class="float-end">
                  @can('category-create')
                     <a class="btn btn-success btn-sm" href="{{ route('categories.create') }}"> <i class="bx bx-add-to-queue"></i> Create New Category</a>
                  @endcan
               </div>
            </h2>
         </div>
      </div>
      <livewire:category-index/>
   </div>
</div>
@endsection
@section('scripts')
@endsection