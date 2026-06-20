@extends('admin.layout')
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/42.0.1/ckeditor5.css">
@section('seo_title')
<title>Content Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Create New Content</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="row">
         <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
               <h2>
                  Create New Content
                  <div class="float-end">
                     @can('content-list')
                     <a class="btn btn-warning" href="{{ route('contents.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>
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
      <form class="row" method="POST" action="@if(!empty($content)) {{ route('contents.update', $content) }} @else {{ route('contents.store') }} @endif" enctype="multipart/form-data">
         @csrf
         @if(!empty($content))
         @method('PUT')
         @endif
         <div class="col-md-12 form-group mt-3">
            <x-input-label for="password_confirmation" :value="__('Enter Title')" />
            <input type="text" name="title" class="form-control shadow-none @error('title') is-invalid @enderror" placeholder="Enter title" value="{{ old('title', @$content->title) }}">
            <x-input-error class="mt-2" :messages="$errors->get('title')" />
         </div>
         <div class="col-md-12 form-group mt-3">
            <x-input-label for="password_confirmation" :value="__('content')" />
            <textarea class="form-control shadow-none editor @error('content') is-invalid @enderror" id="editor" name="content"> {{ old('content', @$content['content']) }} </textarea>
            <x-input-error class="mt-2" :messages="$errors->get('content')" />
         </div>
         <div class="col-md-3 form-group mt-3">
            <x-input-label for="password_confirmation" :value="__('Is Visible Website')" />
            <select class="form-control shadow-none" name="is_visible_website">
            <option value="1" @selected(old('is_visible_website', @$content->is_visible_website)==1)>Visible</option>
            <option value="0" @selected(old('is_visible_website', @$content->is_visible_website)==0)>Unvisible</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('is_visible_website')" />
         </div>
         <div class="col-md-3 form-group mt-3">
            <x-input-label for="password_confirmation" :value="__('Select Status (Active - InActive )')" />
            <select class="form-control shadow-none @error('status') is-invalid @enderror" name="status" id="status">
               <option value="">Select Status</option>
               <option value="Active" @selected(old('status', @$content->status)=="Active")>Active</option>
               <option value="InActive" @selected(old('status', @$content->status)=="InActive")>InActive</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('status')" />
         </div>
         <div class="col-md-12"></div>
         <div class="col-md-3 form-group mt-3">
            <button type="submit" class="btn btn-primary btn-block">{{ $title }}</button>
         </div>
      </form>
   </div>
</div>
@endsection
@section('scripts')
<script type="importmap">
   {
       "imports": {
           "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/42.0.1/ckeditor5.js",
           "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/42.0.1/"
       }
   }
</script>
<script type="module">
   import {
       ClassicEditor,
       Essentials,
       Paragraph,
       Bold,
       Italic,
       Font
   } from 'ckeditor5';
   
   ClassicEditor
       .create( document.querySelector( '#editor' ), {
           plugins: [ Essentials, Paragraph, Bold, Italic, Font ],
           toolbar: [
         'undo', 'redo', '|', 'bold', 'italic', '|',
         'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
           ]
       } )
       .then( editor => {
           window.editor = editor;
       } )
       .catch( error => {
           console.error( error );
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