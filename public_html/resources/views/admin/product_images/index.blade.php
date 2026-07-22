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
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h2>
               <div class="float-end mb-1">
                  @can('productImage-create')
                  <a class="btn btn-success btn-sm" href="{{ route('productImages.create') }}"> <i class="bx bx-add-to-queue"></i> Add New Product Image</a>
                  @endcan
                  @can('productImage-excel-upload')
                  <a class="btn btn-info btn-sm" href="{{ route('productImages.import_productImages', ['update'=>'update', 'rebuild'=>1]) }}"> <i class="bx bx-download"></i> Export All Images</a>
                  @if(!empty($updateTemplatePending ?? false))
                  <span class="text-warning small ms-2">Preparing export... refresh in 2-3 minutes.</span>
                  @elseif(!empty($updateTemplateReady ?? false))
                  <a class="btn btn-success btn-sm" href="{{ route('productImages.import_productImages', ['update'=>'update', 'download'=>1]) }}"> <i class="bx bx-check"></i> Download Ready</a>
                  @endif
                  <a class="btn btn-warning btn-sm" href="{{ route('productImages.import_productImages') }}"> <i class="bx bx-add-to-queue"></i> Import Product Images</a>
                  @endcan
               </div>
            </h2>
         </div>
         <div class="clearfix"></div>
         <livewire:product-images-index/>
      </div>
   </div>
</div>
@endsection
@section('scripts')
@endsection
