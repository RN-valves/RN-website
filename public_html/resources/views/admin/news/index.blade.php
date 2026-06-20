@extends('admin.layout')
@section('seo_title')
<title>News Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">News</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h2>
               <div class="float-end">
                  @can('blog-create')
                     <a class="btn btn-success btn-sm" href="{{ route('news.create') }}"> <i class="bx bx-add-to-queue"></i> Create New News</a>
                  @endcan
               </div>
            </h2>
         </div>
      </div>
      <livewire:news-index/>
   </div>
</div>
@endsection
@section('scripts')
@endsection