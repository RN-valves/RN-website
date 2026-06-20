@extends('admin.layout')
@section('seo_title')
<title>Blogs Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Blogs</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h2>
               <div class="float-end">
                  @can('blog-create')
                     <a class="btn btn-success btn-sm" href="{{ route('blogs.create') }}"> <i class="bx bx-add-to-queue"></i> Create New Blog</a>
                  @endcan
               </div>
            </h2>
         </div>
      </div>
      <livewire:blog-index/>
   </div>
</div>
@endsection
@section('scripts')
@endsection