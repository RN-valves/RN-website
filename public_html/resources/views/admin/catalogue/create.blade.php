@extends('admin.layout')
@section('seo_title')
<title>Catalogue Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">{{$title}}</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="row">
         <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
               <h2>
                  {{$title}} Or Generate Any QR Code
                  <div class="float-end">
             
                     <a class="btn btn-warning" href="{{ route('catalogue.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>
                 
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
      <form class="row" method="POST" action="@if(!empty($content)) {{ route('catalogue.update', $content) }} @else {{ route('catalogue.store') }} @endif" enctype="multipart/form-data">
         @csrf
         @if(!empty($content))
         @method('PUT')
         @endif
         <div class="col-md-6 form-group mt-3">
            <x-input-label for="" :value="__('Enter Name')" />
            <input type="text" name="name" class="form-control shadow-none @error('name') is-invalid @enderror" @if(!empty($content)) readonly @endif placeholder="Enter Name" value="{{ old('name', @$content->name) }}">
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
         </div>
         <div class="col-md-6 form-group mt-3">
            <x-input-label for="" :value="__('Upload Catalogue')" />
            <input type="file" name="pdf_file" class="form-control shadow-none @error('pdf_file') is-invalid @enderror" accept=".pdf" value="{{ old('pdf_file') }}">
            <x-input-error class="mt-2" :messages="$errors->get('pdf_file')" />
         </div>
         <div class="col-md-6 form-group mt-3">
            <x-input-label for="" :value="__('Any Data Url (optional)')" />
            <input type="text" name="pdf_file" class="form-control shadow-none @error('pdf_file') is-invalid @enderror" value="{{ old('pdf_file') }}">
            <x-input-error class="mt-2" :messages="$errors->get('pdf_file')" />
         </div>
         <div class="col-md-3 form-group mt-3">
            <x-input-label for="" :value="__('Select Status (Active - InActive )')" />
            <select class="form-control shadow-none @error('status') is-invalid @enderror" name="status" id="status">
               <option value="" selected>Select Status</option>
               <option value="1" @selected(old('status', @$content->status)==1)>Active</option>
               <option value="0" @selected(old('status', @$content->status)==0)>InActive</option>
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

<!-- A friendly reminder to run on a server, remove this during the integration. -->
<script>
   window.onload = function() {
       if ( window.location.protocol === "file:" ) {
           alert( "This sample requires an HTTP server. Please serve this file with a web server." );
       }
   };
</script>
@endsection