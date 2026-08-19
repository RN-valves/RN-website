@extends('admin.layout')
@section('seo_title')
<title>Products Imports</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">File Uplaod</li>
@endsection
@section('content')


<div class="col-md-12">
   <div class="row" style="max-height:200px;overflow-y:scroll; margin: 0;">
      @if(Session::has('failures'))
      @foreach(Session::get('failures') as $failure)
      <div class="col-3 order-0 p-0" style="border:2px solid #ccc">
         <div class="alert alert-danger mb-0 rounded-0">
            {{$failure->errors()[0]}} at line number {{$failure->row()}}
         </div>
      </div>
      @endforeach
      @endif
   </div>
</div>

@if(Session::has('skipped_rows') && !empty(Session::get('skipped_rows')))
<div class="col-md-12 mb-3">
   <div class="card border-warning">
      <div class="card-header bg-warning text-dark py-2">
         <h6 class="mb-0 fw-bold"><i class="bx bx-error-circle"></i> Import Skipped Rows Log ({{ count(Session::get('skipped_rows')) }} Rows Skipped)</h6>
      </div>
      <div class="card-body p-2" style="max-height: 220px; overflow-y: auto;">
         <table class="table table-bordered table-striped table-sm mb-0">
            <thead>
               <tr>
                  <th>Row #</th>
                  <th>SKU Code</th>
                  <th>Product Name</th>
                  <th>Reason / Error</th>
               </tr>
            </thead>
            <tbody>
               @foreach(Session::get('skipped_rows') as $err)
               <tr>
                  <td class="text-danger fw-bold">Line {{ $err['row'] }}</td>
                  <td><code>{{ $err['sku_code'] }}</code></td>
                  <td>{{ $err['name'] }}</td>
                  <td class="text-danger"><i class="bx bx-x-circle"></i> {{ $err['reason'] }}</td>
               </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>
</div>
@endif

@if(isset($previewData))
<div class="col-lg-12 mb-4 order-0">
   <div class="card border border-primary shadow-sm">
      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
         <h5 class="mb-0 text-white"><i class="bx bx-search-alt"></i> Step 1: Upload Preview & Pre-Check Result</h5>
         <span class="badge bg-white text-primary fw-bold">{{ $previewData['original_name'] }}</span>
      </div>
      <div class="card-body pt-3">
         <div class="row text-center mb-3">
            <div class="col">
               <div class="card bg-light p-2 border">
                  <h6 class="text-muted mb-1 small">Total Rows</h6>
                  <h4 class="mb-0 text-primary fw-bold">{{ $previewData['total_rows'] }}</h4>
               </div>
            </div>
            <div class="col">
               <div class="card bg-light p-2 border border-success">
                  <h6 class="text-muted mb-1 small">Price/Data Changes</h6>
                  <h4 class="mb-0 text-success fw-bold">{{ $previewData['modified_rows'] ?? $previewData['update_rows'] }}</h4>
               </div>
            </div>
            <div class="col">
               <div class="card bg-light p-2 border border-secondary">
                  <h6 class="text-muted mb-1 small">Unchanged Rows</h6>
                  <h4 class="mb-0 text-secondary fw-bold">{{ $previewData['unchanged_rows'] ?? 0 }}</h4>
               </div>
            </div>
            <div class="col">
               <div class="card bg-light p-2 border border-info">
                  <h6 class="text-muted mb-1 small">New Products</h6>
                  <h4 class="mb-0 text-info fw-bold">{{ $previewData['new_rows'] }}</h4>
               </div>
            </div>
            <div class="col">
               <div class="card bg-light p-2 border border-danger">
                  <h6 class="text-muted mb-1 small">Skipped / Errors</h6>
                  <h4 class="mb-0 text-danger fw-bold">{{ count($previewData['skipped_rows']) }}</h4>
               </div>
            </div>
         </div>

         @if(!empty($previewData['skipped_rows']))
         <div class="alert alert-danger py-2 mb-2">
            <strong><i class="bx bx-error-circle"></i> Warning: {{ count($previewData['skipped_rows']) }} row(s) contain errors and will be skipped during import:</strong>
         </div>
         <div class="table-responsive mb-3" style="max-height: 220px; overflow-y: auto;">
            <table class="table table-bordered table-striped table-sm mb-0">
               <thead class="table-dark sticky-top">
                  <tr>
                     <th>Row #</th>
                     <th>SKU Code</th>
                     <th>Product Name</th>
                     <th>Error / Reason</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($previewData['skipped_rows'] as $err)
                  <tr>
                     <td class="text-danger fw-bold">Line {{ $err['row'] }}</td>
                     <td><code>{{ $err['sku_code'] }}</code></td>
                     <td>{{ $err['name'] }}</td>
                     <td class="text-danger"><i class="bx bx-x-circle"></i> {{ $err['reason'] }}</td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
         @else
         <div class="alert alert-success py-2 mb-3">
            <strong><i class="bx bx-check-circle"></i> Pre-Check Passed: All {{ $previewData['total_rows'] }} rows are valid and ready to import!</strong>
         </div>
         @endif

         <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
            <a href="{{ route('products.import_products') }}" class="btn btn-outline-secondary btn-sm">
               <i class="bx bx-x"></i> Cancel / Re-upload File
            </a>
            <form method="POST" action="{{ route('products.import_products') }}">
               @csrf
               <input type="hidden" name="confirm_file_path" value="{{ $previewData['file_path'] }}">
               <button type="submit" class="btn btn-success btn-md fw-bold">
                  <i class="bx bx-check-circle"></i> Step 2: Confirm & Apply Import ({{ $previewData['total_rows'] - count($previewData['skipped_rows']) }} Valid Rows)
               </button>
            </form>
         </div>
      </div>
   </div>
</div>
@endif

<div class="col-lg-12 mb-4 order-0">
   <div class="card">
      <div class="d-flex align-items-end row">
         <div class="col-lg-6">
            <div class="card-body text-center">
               <h5 class="card-title text-primary">File Uplaod</h5>
               <ul style="list-style-type:none;">
                  <li>1. Download Latest template</li>
                  {{-- <li>2. Update Product Information</li> --}}
                  <li></li>
               </ul>
               <a href="{{ route('products.import_products', ['export'=>'export']) }}" class="btn btn-sm btn-info border"> <i class="bx bx-cloud-download"></i> Add New Template</a>
               <a href="{{ route('products.import_products', ['update'=>'update', 'rebuild'=>1]) }}" class="btn btn-sm btn-warning border"> <i class="bx bx-download"></i> Update Template</a>
               @if(!empty($updateTemplatePending ?? false))
                  <div class="mt-2 text-warning small">Preparing Update Template… refresh in 2–3 minutes.</div>
               @elseif(!empty($updateTemplateReady ?? false))
                  <a href="{{ route('products.import_products', ['update'=>'update', 'download'=>1]) }}" class="btn btn-sm btn-success border mt-2"> <i class="bx bx-check"></i> Download Ready</a>
               @endif
            </div>
         </div>
         <div class="col-lg-6 text-center text-sm-left">
            <div class="card-body text-center">
               <h5 class="card-title text-primary">Ready To submit a completed file ?  </h5>
               <ul style="list-style-type:none;">
                  <li>1. Upload updated template & Preview Pre-Check</li>
                  {{-- <li>2. Wait for validation Process</li> --}}
                  <li></li>
               </ul>
               <form method="POST" action="{{ route('products.import_products') }}" enctype="multipart/form-data">
                  @csrf
                  <span class="label text-dark" id="upload-file-info"></span>
                  <label class="btn btn-sm btn-primary mb-0" for="my-file-selector">
                  <input id="my-file-selector" type="file" name="import_file" style="display:none" class="@error('import_file') is-invalid @enderror" onchange="$('#upload-file-info').text(this.files[0].name)">
                  Choose File
                  </label>
                  @error('import_file')
                  <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                  @enderror
                  <button type="submit" class="btn btn-success btn-sm">Preview & Check Sheet</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
@include('admin.commons.imports')
@endsection
@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
   $(".confirmDelete").click(function(){
      var title  = $(this).attr("title");
      if(confirm("Are you sure to delete this "+title+"?")){
         return true;
      }else{
         return false;
      }
   });
});
</script>
<script type="text/javascript">
    $("#state_id").select2({
          placeholder: "Select a category",
          allowClear: true
      });
</script>
@endsection