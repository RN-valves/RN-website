@extends('admin.layout')
@section('seo_title')
<title>Category Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Action Category</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="row">
         <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
               <h2>
                  Action Category
                  <div class="float-end">
                     @can('content-list')
                     <a class="btn btn-warning" href="{{ route('categories.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>
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
      <form class="row" method="POST" action="@if(!empty($category)) {{ route('categories.update', $category) }} @else {{ route('categories.store') }} @endif" enctype="multipart/form-data">
         @csrf
         @if(!empty($category))
         @method('PUT')
         @endif
         <div class="col-md-3 form-group mt-3">
            <x-input-label class="mb-1" for="password_confirmation" :value="__('Select Content (Opt)')" />
            <select class="form-control shadow-none @error('content_id') is-invalid @enderror" name="content_id" id="content_id">
               <option value="">Select Content</option>
               @foreach($contents ?? '' as $content)
               <option value="{{ $content->id }}" @selected(old('content_id', @$category->content_id)==$content->id)>{{ $content->title??'NA' }}</option>
               @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('content_id')" />
         </div>
         <div class="col-md-3 form-group mt-3">
            <x-input-label class="mb-1" for="password_confirmation" :value="__('Enter Name')" />
            <input type="text" name="name" class="form-control shadow-none @error('name') is-invalid @enderror" placeholder="Enter Name" value="{{ old('name', @$category->name) }}">
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
         </div>
         <div class="col-md-3 form-group mt-3">
            <x-input-label class="mb-1" for="is_visible_website" :value="__('Select Visible Web')" />
            <select class="form-control shadow-none @error('is_visible_website') is-invalid @enderror" name="is_visible_website" id="is_visible_website">
               <option value="">Select Visible Web</option>
               <option value="1" @selected(old('is_visible_website',@$category->is_visible_website)==1)>Visible</option>
               <option value="0" @selected(old('is_visible_website',@$category->is_visible_website)==0)>InVisible</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('is_visible_website')" />
         </div>
         <div class="col-md-3 form-group mt-3">
            <x-input-label class="mb-1" for="discount" :value="__('Category Discount %')" />
            <input type="number" name="discount" class="form-control shadow-none @error('discount') is-invalid @enderror" value="{{ old('discount', @$category->discount) }}">
            <x-input-error class="mt-2" :messages="$errors->get('discount')" />
         </div>
         <div class="col-md-3 form-group mt-3">
            <x-input-label class="mb-1" for="tax" :value="__('Category Tax %')" />
            <input type="number" name="tax" class="form-control shadow-none @error('tax') is-invalid @enderror" value="{{ old('tax', @$category->tax) }}">
            <x-input-error class="mt-2" :messages="$errors->get('tax')" />
         </div>
         <div class="col-md-3 form-group mt-3">
            <x-input-label class="mb-1" for="image" :value="__('Select Image - size:500*500px')" />
            <input type="file" name="image" class="form-control shadow-none @error('image') is-invalid @enderror">
            <x-input-error class="mt-2" :messages="$errors->get('image')" />
         </div>
         <div class="col-md-3 form-group mt-3">
            <x-input-label class="mb-1" for="banner" :value="__('Select Banner (Opt) - size:1900*400px')" />
            <input type="file" name="banner" class="form-control shadow-none @error('banner') is-invalid @enderror">
            <x-input-error class="mt-2" :messages="$errors->get('banner')" />
         </div>
         <div class="col-md-3 form-group mt-3">
            <x-input-label class="mb-1" for="mobile_banner" :value="__('Select Mobile Banner (Opt) - size:414*200px')" />
            <input type="file" name="mobile_banner" class="form-control shadow-none @error('mobile_banner') is-invalid @enderror">
            <x-input-error class="mt-2" :messages="$errors->get('mobile_banner')" />
         </div>
         <div class="col-md-3 form-group mt-3">
            <x-input-label class="mb-1" for="icon" :value="__('Select Icon  (Opt) - size:100*100px')" />
            <input type="file" name="icon" class="form-control shadow-none @error('icon') is-invalid @enderror">
            <x-input-error class="mt-2" :messages="$errors->get('icon')" />
         </div>
         <div class="col-md-3 form-group mt-3">
            <x-input-label class="mb-1" for="pdf_catalogue" :value="__('PDF Catalogues URL() (Opt)')" />
            <input type="text" name="pdf_catalogue" class="form-control shadow-none @error('pdf_catalogue') is-invalid @enderror" value="{{ old('pdf_catalogue', @$category->pdf_catalogue) }}">
            <x-input-error class="mt-2" :messages="$errors->get('pdf_catalogue')" />
         </div>
         <div class="col-md-3 form-group mt-3">
            <x-input-label class="mb-1" for="password_confirmation" :value="__('Select Status')" />
            <select class="form-control shadow-none @error('status') is-invalid @enderror" name="status" id="status">
               <option value="">Select Status</option>
               <option value="Active" @selected(old('status',@$category->status)=="Active")>Active</option>
               <option value="InActive" @selected(old('status',@$category->status)=="InActive")>InActive</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('status')" />
         </div>
         <div class="col-md-6 form-group mt-3">
            <x-input-label class="mb-1" for="password_confirmation" :value="__('SEO Title')" />
            <input type="text" name="title" class="form-control shadow-none @error('title') is-invalid @enderror" placeholder="Enter title" value="{{ old('title', @$category->title) }}">
            <x-input-error class="mt-2" :messages="$errors->get('title')" />
         </div>
         <div class="col-md-12 form-group mt-3">
            <x-input-label class="mb-1" for="password_confirmation" :value="__('SEO Keywords')" />
            <input type="text" name="keywords" class="form-control shadow-none @error('keywords') is-invalid @enderror" placeholder="Enter keywords" value="{{ old('keywords', @$category->keywords) }}">
            <x-input-error class="mt-2" :messages="$errors->get('keywords')" />
         </div>
         <div class="col-md-12 form-group mt-3">
            <x-input-label class="mb-1" for="password_confirmation" :value="__('SEO Description')" />
            <input type="text" name="description" class="form-control shadow-none @error('description') is-invalid @enderror" placeholder="Enter description" value="{{ old('description', @$category->description) }}">
            <x-input-error class="mt-2" :messages="$errors->get('description')" />
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
   $("#parent_id").select2({
     theme: "classic"
   });
</script>
<script type="text/javascript">
   $("#content_id").select2({
     theme: "classic"
   });
</script>
@endsection