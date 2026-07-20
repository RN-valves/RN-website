@extends('admin.layout')
@section('seo_title')
<title>SubCategory Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Action SubCategory</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="row">
         <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
               <h2>
                  Action SubCategory
                  <div class="float-end">
                     @can('content-list')
                     <a class="btn btn-warning" href="{{ route('subcategories.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>
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
      <form class="row" method="POST" action="@if(!empty($subcategory)) {{ route('subcategories.update', $subcategory) }} @else {{ route('subcategories.store') }} @endif" enctype="multipart/form-data">
         @csrf
         @if(!empty($subcategory))
         @method('PUT')
         @endif
         <div class="col-md-3 form-group mt-3">
            <x-input-label class="mb-1" for="category_id" :value="__('Select Category')" />
            <select class="form-control shadow-none @error('category_id') is-invalid @enderror" name="category_id" id="category_id">
               <option value="">Select Category</option>
               @foreach($categories ?? '' as $category)
               <option value="{{ $category->id }}" @selected(old('category_id', @$subcategory->category_id)==$category->id)>{{ $category->name??'NA' }}</option>
               @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
         </div>
         <div class="col-md-3 form-group mt-3">
            <x-input-label class="mb-1" for="content_id" :value="__('Select Content (Opt)')" />
            <select class="form-control shadow-none @error('content_id') is-invalid @enderror" name="content_id" id="content_id">
               <option value="">Select Content</option>
               @foreach($contents ?? '' as $content)
               <option value="{{ $content->id }}" @selected(old('content_id', @$subcategory->content_id)==$content->id)>{{ $content->title??'NA' }}</option>
               @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('content_id')" />
         </div>
         <div class="col-md-3 form-group mt-3">
            <x-input-label class="mb-1" for="name" :value="__('Enter Name')" />
            <input type="text" name="name" class="form-control shadow-none @error('name') is-invalid @enderror" placeholder="Enter Name" value="{{ old('name', @$subcategory->name) }}">
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
         </div>
         <div class="col-md-3 form-group mt-3">
            <x-input-label class="mb-1" for="display_order" :value="__('Display Order')" />
            <input type="number" name="display_order" id="display_order" min="0" class="form-control shadow-none @error('display_order') is-invalid @enderror" placeholder="e.g. 1" value="{{ old('display_order', @$subcategory->display_order) }}">
            <small class="text-muted">Lower number = shown first on website</small>
            <x-input-error class="mt-2" :messages="$errors->get('display_order')" />
         </div>
         <div class="col-md-3 form-group mt-3">
            <x-input-label class="mb-1" for="is_visible_website" :value="__('Select Visible Web')" />
            <select class="form-control shadow-none @error('is_visible_website') is-invalid @enderror" name="is_visible_website" id="is_visible_website">
               <option value="">Select Visible Web</option>
               <option value="1" @selected(old('is_visible_website',@$subcategory->is_visible_website)==1)>Visible</option>
               <option value="0" @selected(old('is_visible_website',@$subcategory->is_visible_website)==0)>InVisible</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('is_visible_website')" />
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
            <x-input-label class="mb-1" for="icon" :value="__('Select Icon  (Opt) - size:100*100px')" />
            <input type="file" name="icon" class="form-control shadow-none @error('icon') is-invalid @enderror">
            <x-input-error class="mt-2" :messages="$errors->get('icon')" />
         </div>
         <div class="col-md-3 form-group mt-3">
            <x-input-label class="mb-1" for="pdf_catalogue" :value="__('PDF Catalogues (Opt)')" />
            <input type="text" name="pdf_catalogue" class="form-control shadow-none @error('pdf_catalogue') is-invalid @enderror" value="{{ old('pdf_catalogue', @$subcategory->pdf_catalogue) }}">
            <x-input-error class="mt-2" :messages="$errors->get('pdf_catalogue')" />
         </div>
         <div class="col-md-3 form-group mt-3">
            <x-input-label class="mb-1" for="password_confirmation" :value="__('Select Status')" />
            <select class="form-control shadow-none @error('status') is-invalid @enderror" name="status" id="status">
               <option value="">Select Status</option>
               <option value="Active" @selected(old('status',@$subcategory->status)=="Active")>Active</option>
               <option value="InActive" @selected(old('status',@$subcategory->status)=="InActive")>InActive</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('status')" />
         </div>
         <div class="col-md-6 form-group mt-3">
            <x-input-label class="mb-1" for="password_confirmation" :value="__('SEO Title')" />
            <input type="text" name="title" class="form-control shadow-none @error('title') is-invalid @enderror" placeholder="Enter title" value="{{ old('title', @$subcategory->title) }}">
            <x-input-error class="mt-2" :messages="$errors->get('title')" />
         </div>
         <div class="col-md-12 form-group mt-3">
            <x-input-label class="mb-1" for="password_confirmation" :value="__('SEO Keywords')" />
            <input type="text" name="keywords" class="form-control shadow-none @error('keywords') is-invalid @enderror" placeholder="Enter keywords" value="{{ old('keywords', @$subcategory->keywords) }}">
            <x-input-error class="mt-2" :messages="$errors->get('keywords')" />
         </div>
         <div class="col-md-12 form-group mt-3">
            <x-input-label class="mb-1" for="password_confirmation" :value="__('SEO Description')" />
            <input type="text" name="description" class="form-control shadow-none @error('description') is-invalid @enderror" placeholder="Enter description" value="{{ old('description', @$subcategory->description) }}">
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