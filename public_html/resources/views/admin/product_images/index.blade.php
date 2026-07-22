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
                  @if(!empty($updateTemplatePending ?? false))
                  <a class="btn btn-info btn-sm disabled" href="javascript:void(0)" aria-disabled="true"> <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Exporting...</a>
                  @else
                  <a class="btn btn-info btn-sm js-product-images-export" href="{{ route('productImages.import_productImages', ['update'=>'update', 'rebuild'=>1]) }}"> <i class="bx bx-download"></i> Export All Images</a>
                  @endif
                  @if(!empty($updateTemplateReady ?? false))
                  <a class="btn btn-success btn-sm" href="{{ route('productImages.import_productImages', ['update'=>'update', 'download'=>1]) }}"> <i class="bx bx-check"></i> Download Ready</a>
                  @else
                  <a class="btn btn-success btn-sm disabled" href="javascript:void(0)" aria-disabled="true"> <i class="bx bx-time"></i> Download Ready</a>
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
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function () {
   var storageKey = 'product-images-export-pending';
   var exportButton = document.querySelector('.js-product-images-export');
   var isPending = @json(!empty($updateTemplatePending ?? false));
   var isReady = @json(!empty($updateTemplateReady ?? false));

   if (exportButton) {
      exportButton.addEventListener('click', function () {
         localStorage.setItem(storageKey, '1');
      });
   }

   if (isPending) {
      localStorage.setItem(storageKey, '1');
      window.setTimeout(function () {
         window.location.reload();
      }, 4000);
      return;
   }

   if (isReady && localStorage.getItem(storageKey) === '1') {
      localStorage.removeItem(storageKey);
      if (typeof toastr !== 'undefined') {
         toastr.options = {
            closeButton: true,
            progressBar: true,
         };
         toastr.success('Product images export is ready for download.');
      }
   }
});
</script>
@endsection
