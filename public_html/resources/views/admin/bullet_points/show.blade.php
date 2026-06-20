@extends('admin.layout')
@section('seo_title')
<title>Bullet Point</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Bullet Point</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h2>
               <div class="card-title">
                  <small>Bullet Point Details - BPNT{{ $bPoint->id??'' }}</small>
                  
                  <div class="float-end">
                     <div class="">
                        @can('bullet-point-list')
                        <a class="btn btn-warning btn-sm" href="{{ route('bPoints.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>
                        @endcan
                     </div>
                  </div>
               </div>
            </h2>
         </div>
         <div class="clearfix"></div>
         <div class="row">
            <div class="col-lg-3">
               <div class="card-body">
                  <p class="mb-0"><strong>Name</strong></p>
                  <h4 class="">{{ $bPoint->name??'' }}</h4><hr>
                  <p class="mb-0"><strong>Model Type</strong></p>
                  <h4 class="">{{ $bPoint->model_type??'' }}</h4><hr>
                  <p class="mb-0"><strong>Model Id</strong></p>
                  <h4 class="">{{ $bPoint->model_id??'' }}</h4><hr>
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