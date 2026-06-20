@extends('admin.layout')
@section('seo_title')
<title>Enquiry Imports</title>
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
               <a href="{{ route('productImages.import_productImages', ['export'=>'export']) }}" class="btn btn-sm btn-info border"> <i class="bx bx-cloud-download"></i> Add New Template</a>
               <a href="{{ route('productImages.import_productImages', ['update'=>'update']) }}" class="btn btn-sm btn-warning border"> <i class="bx bx-download"></i> Update Template</a>
            </div>
         </div>
         <div class="col-lg-6 text-center text-sm-left">
            <div class="card-body text-center">
               <h5 class="card-title text-primary">Ready To submit a completed file ?  </h5>
               <ul style="list-style-type:none;">
                  <li>1. Upload updated template</li>
                  {{-- <li>2. Wait for validation Process</li> --}}
                  <li></li>
               </ul>
               <form method="POST" action="{{ route('productImages.import_productImages') }}" enctype="multipart/form-data">
                  @csrf
                  <span class="label text-dark" id="upload-file-info"></span>
                  <label class="btn btn-sm btn-primary mb-0" for="my-file-selector">
                  <input id="my-file-selector" type="file" name="import_file" style="display:none" class="@error('import_file') is-invalid @enderror" onchange="$('#upload-file-info').text(this.files[0].name)">
                  Upload File
                  </label>
                  @error('import_file')
                  <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                  @enderror
                  <button type="submit" class="btn btn-success btn-sm">Upload</button>
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