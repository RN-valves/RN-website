@extends('admin.layout')
@section('seo_title')
<title>SubCategory Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">SubCategories</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h2>
               <div class="float-end">
                  @can('subcategory-create')
                     <a class="btn btn-success btn-sm" href="{{ route('subcategories.create') }}"> <i class="bx bx-add-to-queue"></i> Create New SubCategory</a>
                  @endcan
               </div>
            </h2>
         </div>
      </div>
      <livewire:subcategory-index/>
   </div>
</div>
@endsection
@section('scripts')
@endsection