@extends('admin.layout')
@section('seo_title')
<title>Size</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Size</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h2>
               <div class="card-title">
                  <small>Size Details - SZ{{ $size->id??'' }}</small>
                  
                  <div class="float-end">
                     <div class="">
                        {{-- @can('size-edit')
                        <a class="btn btn-primary btn-sm" href="{{ route('sizes.edit', $size) }}"> <i class="bx bx-edit-alt"></i> Edit size</a>
                        @endcan --}}
                        @can('size-list')
                        <a class="btn btn-warning btn-sm" href="{{ route('sizes.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>
                        @endcan
                     </div>
                  </div>
               </div>
            </h2>
         </div>
         <div class="clearfix"></div>
         <div class="row">
            <div class="col-lg-3">
               <div class="card-title">
                  <h4 class="mb-0">{{ $size->name??'' }}</h4>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
$("#remark").select2({
  theme: "classic"
});
</script>
@endsection