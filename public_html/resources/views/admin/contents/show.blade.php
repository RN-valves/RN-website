@extends('admin.layout')
@section('seo_title')
<title>Content Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Contents</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h2>
               <div class="float-end">
                  @can('content-edit')
                  <a class="btn btn-info btn-sm" href="{{ route('contents.edit', $content) }}"> <i class="bx bx-edit-alt"></i> Edit Content</a>
                  @endcan
                  @can('content-list')
                  <a class="btn btn-warning btn-sm" href="{{ route('contents.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>
                  @endcan
               </div>
            </h2>
         </div>
      </div>
      <div class="clearfix"></div>
      <div class="row">
         <div class="col-lg-12">
            <div class="card-header">
               <h5 class="mb-0 text-dark">CT{{ $content->id }} : {{ $content->title??'' }}</h5>
               <p class="mb-0">{{ $content->uuid??'' }}</p>
            </div>
            <div class="card-body">
               <p>{!! $content->content??'' !!}</p>
            </div>
         </div>
         <div class="col-lg-12">
            <div class="card-header">
               <h5 class="mb-0 px-2"><strong>Attached Categories</strong></h5>
            </div>
            <div class="card-body">
               @foreach($content->categories??'' as $category_content)
               <span class="badge badge-sm bg-info">{{ $category_content->name??'' }}</span>
               @endforeach
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('scripts')
@endsection