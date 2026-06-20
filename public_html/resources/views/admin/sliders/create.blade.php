@extends('admin.layout')
@section('seo_title')
<title>Website Banner</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Action Website Banner</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="row">
         <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
               <h2>
                  Action Website Banner
                  <div class="float-end">
                     @can('slider-list')
                     <a class="btn btn-warning" href="{{ route('sliders.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>
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
      <form class="row" method="POST" action="@if(!empty($slider)) {{ route('sliders.update', $slider) }} @else {{ route('sliders.store') }} @endif" enctype="multipart/form-data">
         @csrf
         @if(!empty($slider))
         @method('PUT')
         @endif
         <div class="col-md-4 form-group mt-3">
            <x-input-label class="mb-1" :value="__('SEO Title')" />
            <input type="text" name="title" class="form-control shadow-none @error('title') is-invalid @enderror" placeholder="Enter title" value="{{ old('title', @$slider->title) }}">
            <x-input-error class="mt-2" :messages="$errors->get('title')" />
         </div>
         <div class="col-md-4 form-group mt-3">
            <x-input-label class="mb-1" :value="__('Select Status')" />
            <select class="form-control shadow-none @error('status') is-invalid @enderror" name="status" id="status">
               <option value="">Select Status</option>
               <option value="Active" @selected(old('status',@$slider->status)=="Active")>Active</option>
               <option value="InActive" @selected(old('status',@$slider->status)=="InActive")>InActive</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('status')" />
         </div>
         {{-- <div class="col-md-4 form-group mt-3">
            <x-input-label class="mb-1" for="image" :value="__('Select Image - size:1920*860px')" />
            <input type="file" name="image" class="form-control shadow-none @error('image') is-invalid @enderror">
            <x-input-error class="mt-2" :messages="$errors->get('image')" />
         </div> --}}
         <div class="col-md-12 form-group mt-3">
            <x-input-label class="mb-1" :value="__('Image URL (1920*860px)')" />
            <input type="text" name="image" class="form-control shadow-none @error('image') is-invalid @enderror" placeholder="Enter image" value="{{ old('image', @$slider->image) }}">
            <x-input-error class="mt-2" :messages="$errors->get('image')" />
         </div>
         <div class="col-md-12 form-group mt-3">
            <x-input-label class="mb-1" :value="__('Banner Redirection URL (Optional)')" />
            <input type="text" name="banner_url" class="form-control shadow-none @error('banner_url') is-invalid @enderror" placeholder="Enter banner_url" value="{{ old('banner_url', @$slider->banner_url) }}">
            <x-input-error class="mt-2" :messages="$errors->get('banner_url')" />
         </div>
         <div class="col-md-3 form-group mt-3">
            <button type="submit" class="btn btn-primary btn-block">Submit</button>
         </div>
      </form>
   </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
   $("#category_id").select2({
     theme: "classic"
   });
</script>
<script type="text/javascript">
   $("#content_id").select2({
     theme: "classic"
   });
</script>
@endsection