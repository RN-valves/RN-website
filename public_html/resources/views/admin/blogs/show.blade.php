@extends('admin.layout')
@section('seo_title')
<title>Blog Index</title>
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
                  @can('blog-edit')
                  <a class="btn btn-info btn-sm" href="{{ route('blogs.edit', $blog) }}"> <i class="bx bx-edit-alt"></i> Edit blog</a>
                  @endcan
                  @can('blog-list')
                  <a class="btn btn-warning btn-sm" href="{{ route('blogs.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>
                  @endcan
               </div>
            </h2>
         </div>
      </div>
      <div class="clearfix"></div>
      <div class="row">
         <div class="col-lg-9">
            <div class="card-header">
               <h5 class="mb-0 text-dark">BL{{ $blog->id }} : {{ $blog->title??'' }}</h5>
               <p class="mb-0">{{ $blog->name??'' }}</p>
            </div>
            <div class="card-body">
               <p><strong>Short Description</strong></p>
               <p>{{ $blog->short_description }}</p>
            </div>
            <div class="card-body">
               <p><strong>SEO Keywords</strong></p>
               <p>{{ $blog->keywords }}</p>
            </div>
            <div class="card-body">
               <p><strong>SEO Description</strong></p>
               <p>{{ $blog->description }}</p>
            </div>
            <div class="card-body">
               <p><strong>Main Content</strong></p>
               <p>{!! $blog->content??'' !!}</p>
            </div>
         </div>
         <div class="col-lg-3 border">
            <div class="card-header py-1">
               <h5 class="mb-0 px-2 text-center"><strong>Main Image</strong></h5>
            </div>
            <div class="card-body">
               <img src="{{ url($blog->image) }}" width="100%">
            </div>

            <div class="card">
               <div class="card-header bg-warning">
                  <h5 class="text-center mb-0">Blog Logs</h5>
               </div>
               @foreach($blog->blog_logs??'' as $log)
               <div class=" px-2">
                  <p><strong>Edit By</strong><br> {{ $log->created_by??'' }} <br> {{ $log->created_at->format('d M Y, H:i:s')??'' }}</p>
                  <p></p>
               </div>
               @endforeach
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('scripts')
@endsection