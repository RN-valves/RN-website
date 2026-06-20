@extends('admin.layout')
@section('seo_title')
<title>Pincodes Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Pincodes</li>
@endsection
@section('content')
<div class="card pt-3">
   <div class="card-body">
      <div class="row">
         {{-- @can('pincode-excel-upload')
         @livewire('import')
         @endcan --}}
         @livewire('export')
         <div class="col-lg-3">
            <a href="{{ route('pincodes.import_pincodes', ['download'=>'download']) }}" class="btn btn-sm btn-primary">Download Pincode List</a>
         </div>
      </div>
   </div>
</div>

<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h2>
               <div class="float-end">
                  @can('pincode-create')
                  <a class="btn btn-success btn-sm" href="{{ route('pincodes.create') }}"> <i class="bx bx-add-to-queue"></i> Create New Pincode</a>
                  @endcan
                  @can('pincode-excel-upload')
                  <a class="btn btn-warning btn-sm" href="{{ route('pincodes.import_pincodes') }}"> <i class="bx bx-add-to-queue"></i> Import Pincodes</a>
                  @endcan
               </div>
            </h2>
         </div>
      </div>
      <livewire:pincode-table/>
   </div>
</div>
@endsection