@extends('admin.layout')
@section('seo_title')
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/42.0.1/ckeditor5.css">
<title>News Post Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Action News Post</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="row">
         <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
               <h2>
                  Action News Post
                  <div class="float-end">
                     @can('blog-list')
                     <a class="btn btn-warning" href="{{ route('news.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>
                     @endcan
                  </div>
               </h2>
            </div>
         </div>
      </div>
      @if (count($errors) > 0)
      <div class="alert alert-danger">
         <strong>Whoops! </strong> There were some problems with your input.<br><br>
         <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
         </ul>
      </div>
      @endif
      <form class="row" method="POST" id="news_form" action="@if(!empty($news)) {{ route('news.update', $news) }} @else {{ route('news.store') }} @endif" enctype="multipart/form-data">
         @csrf
         @if(!empty($news))
         @method('PUT')
         @endif
         <div class="col-md-6 form-group mt-3">
            <x-input-label class="mb-1" for="name" :value="__('Enter Name')" />
            <input type="text" name="name" class="form-control shadow-none @error('name') is-invalid @enderror" placeholder="Enter Name" value="{{ old('name', @$news->name) }}">
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
         </div>
         <div class="col-md-12 form-group mt-3">
            <x-input-label class="mb-1" for="short_description" :value="__('Enter Short Description')" />
            <input type="text" name="short_description" class="form-control shadow-none @error('short_description') is-invalid @enderror" placeholder="Enter short_description" value="{{ old('short_description', @$news->short_description) }}">
            <x-input-error class="mt-2" :messages="$errors->get('short_description')" />
         </div>
         <div class="col-md-4 form-group mt-3">
            <x-input-label class="mb-1" for="image" :value="__('Select Image - size:,566*679px')" />
            <input type="file" name="image" class="form-control shadow-none @error('image') is-invalid @enderror">
            <x-input-error class="mt-2" :messages="$errors->get('image')" />
         </div>
         <div class="col-md-4 form-group mt-3">
            <x-input-label class="mb-1" for="published_at" :value="__('Enter Published Date')" />
            <input type="text" name="published_at" class="form-control shadow-none @error('published_at') is-invalid @enderror" placeholder="Enter published_at MM/dd/YYYY" value="{{ old('published_at', @$news->published_at) }}">
            <x-input-error class="mt-2" :messages="$errors->get('published_at')" />
         </div>
         <div class="col-md-4 form-group mt-3">
            <x-input-label class="mb-1" for="password_confirmation" :value="__('Select Status')" />
            <select class="form-control shadow-none @error('status') is-invalid @enderror" name="status" id="status">
               <option value="">Select Status</option>
               <option value="Active" @selected(old('status',@$news->status)=="Active")>Active</option>
               <option value="InActive" @selected(old('status',@$news->status)=="InActive")>InActive</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('status')" />
         </div>
         <div class="col-md-12 form-group mt-3">
            <x-input-label class="mb-1" for="password_confirmation" :value="__('SEO Title')" />
            <input type="text" name="title" class="form-control shadow-none @error('title') is-invalid @enderror" placeholder="Enter title" value="{{ old('title', @$news->title) }}">
            <x-input-error class="mt-2" :messages="$errors->get('title')" />
         </div>
         <div class="col-md-12 form-group mt-3">
            <x-input-label class="mb-1" for="password_confirmation" :value="__('SEO Keywords')" />
            <input type="text" name="keywords" class="form-control shadow-none @error('keywords') is-invalid @enderror" placeholder="Enter keywords" value="{{ old('keywords', @$news->keywords) }}">
            <x-input-error class="mt-2" :messages="$errors->get('keywords')" />
         </div>
         <div class="col-md-12 form-group mt-3">
            <x-input-label class="mb-1" for="password_confirmation" :value="__('SEO Description')" />
            <input type="text" name="description" class="form-control shadow-none @error('description') is-invalid @enderror" placeholder="Enter description" value="{{ old('description', @$news->description) }}">
            <x-input-error class="mt-2" :messages="$errors->get('description')" />
         </div>
         <div class="col-md-12 form-group mt-3">
            <x-input-label for="password_confirmation" :value="__('content')" />
            <textarea class="form-control shadow-none editor @error('content') is-invalid @enderror" id="editor" name="content"> {{ old('content', @$news['content']) }} </textarea>
            <x-input-error class="mt-2" :messages="$errors->get('content')" />
         </div>
         <div class="col-md-3 form-group mt-3">
            <button type="submit" class="btn btn-primary btn-block news_form_disabled">Submit</button>
         </div>
      </form>
   </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
$(document).ready(function () {
   $("#news_form").submit(function (e) {
      $(".news_form_disabled").attr("disabled", true);
      return true;
   });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@43.2.0/build/ckeditor.min.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .then( editor => {
            window.editor = editor;
        } )
        .catch( error => {
            console.error( 'There was a problem initializing the editor.', error );
        } );
</script>
<!-- A friendly reminder to run on a server, remove this during the integration. -->
<script>
   window.onload = function() {
       if ( window.location.protocol === "file:" ) {
           alert( "This sample requires an HTTP server. Please serve this file with a web server." );
       }
   };
</script>
@endsection