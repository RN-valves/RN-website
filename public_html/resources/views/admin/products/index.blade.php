@extends('admin.layout')
@section('seo_title')
<title>Product Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Products</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h2>
               <div class="float-end">
                  @can('product-create')
                     <a class="btn btn-success btn-sm" href="{{ route('products.create') }}"> <i class="bx bx-add-to-queue"></i> Create New Product</a>
                  @endcan
                  @can('product-excel-upload')
                  <a class="btn btn-warning btn-sm" href="{{ route('products.import_products') }}"> <i class="bx bx-add-to-queue"></i> Import Products</a>
                  @endcan
                  @can('product-excel-upload')
                  <a class="btn btn-warning btn-sm" href="{{ route('products.import.qty') }}"> <i class="bx bx-add-to-queue"></i> Import Products Stocks Qty</a>
                  @endcan
               </div>
            </h2>
         </div>
      </div>
      <livewire:product-index/>
   </div>
</div>
@endsection
@section('scripts')
@endsection