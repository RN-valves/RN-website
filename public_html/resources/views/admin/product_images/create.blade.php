@extends('admin.layout')
@section('seo_title')
<title>Product Images</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Product Images</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="row">
         <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
               <h2>
                  Product Images
                  <div class="float-end">
                     @can('productImage-list')
                     <a class="btn btn-warning" href="{{ route('productImages.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>
                     @endcan
                  </div>
               </h2>
            </div>
         </div>
      </div>
      <form action="@if(!empty($productImage)) {{ route('productImages.update', $productImage) }} @else {{ route('productImages.store') }} @endif" method="POST" class="row g-3">
         @csrf
         @if(!empty($productImage))
         @method('PATCH')
         @endif
         <div class="col-lg-12 clearfix"></div>
         <div class="col-lg-6 form-group">
            <label class="mb-1">Enter Product Sku Code</label>
            <input type="text" name="sku_code" value="{{ old('sku_code', @$productImage->sku_code??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
            <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('sku_code')" />
         </div>
         <div class="col-lg-5 form-group">
            <label class="mb-1">Enter Image URL</label>
            <input type="text" name="image" value="{{ old('image', @$productImage->image??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
            <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('image')" />
         </div>
         <div class="">
            <button type="submit" id="btnId" class="btn btn-success">Submit</button>
         </div>
      </form>
   </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
   $("#product_id").select2({
         placeholder: "Select a data",
         allowClear: true
     });
</script>
@endsection