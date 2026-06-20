@extends('admin.layout')
@section('seo_title')
<title>Enquiry</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Enquiry</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h2>
               <div class="float-end mb-1">
                  @can('enquiry-create')
                     <a class="btn btn-success btn-sm" href="{{ route('enquiries.create') }}"> <i class="bx bx-add-to-queue"></i> Create New Enquiry</a>
                  @endcan
                  @can('enquiry-excel-upload')
                  <a class="btn btn-warning btn-sm" href="{{ route('enquiries.import_enquiries') }}"> <i class="bx bx-add-to-queue"></i> Import Enquiries</a>
                  @endcan
               </div>
            </h2>
         </div>
         <div class="clearfix"></div>
         <livewire:enquiry-index/>
      </div>
   </div>
</div>
@endsection
@section('scripts')
@endsection