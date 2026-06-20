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
                  @can('blog-edit')
                  <a class="btn btn-info btn-sm" href="{{ route('news.edit', $news) }}"> <i class="bx bx-edit-alt"></i> Edit News</a>
                  @endcan
                  @can('blog-list')
                  <a class="btn btn-warning btn-sm" href="{{ route('news.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>
                  @endcan
               </div>
            </h2>
         </div>
      </div>
      <div class="clearfix"></div>
      <div class="row">
         <div class="col-lg-9">
            <div class="card-header">
               <h5 class="mb-0 text-dark">NW{{ $news->id }} : {{ $news->title??'' }}</h5>
               <p class="mb-0">{{ $news->name??'' }}</p>
            </div>
            <div class="card-body">
               <p><strong>Short Description</strong></p>
               <p>{{ $news->short_description }}</p>
            </div>
            <div class="card-body">
               <p><strong>SEO Keywords</strong></p>
               <p>{{ $news->keywords }}</p>
            </div>
            <div class="card-body">
               <p><strong>SEO Description</strong></p>
               <p>{{ $news->description }}</p>
            </div>
            <div class="card-body">
               <p><strong>Main Content</strong></p>
               <p>{!! $news->content??'' !!}</p>
            </div>
         </div>
         <div class="col-lg-3 border">
            <div class="card-header py-1">
               <h5 class="mb-0 px-2 text-center"><strong>Main Image</strong></h5>
            </div>
            <div class="card-body">
               <img src="{{ url($news->image) }}" width="100%">
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('scripts')
@endsection