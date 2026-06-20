@extends('admin.layout')
@section('seo_title')
<title>Cities Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Users</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12">
         <div class="pull-left">
            <h2>
               <div class="float-end">
                  @can('city-create')
                  <a class="btn btn-success btn-sm" href="{{ route('cities.create') }}"> <i class="bx bx-add-to-queue"></i> Create New City</a>
                  @endcan
                  @can('city-excel-upload')
                  <a class="btn btn-warning btn-sm" href="{{ route('cities.import_cities') }}"> <i class="bx bx-add-to-queue"></i> Import Cities</a>
                  @endcan
               </div>
            </h2>
         </div>
      </div>
      <livewire:city-table/>
   </div>
</div>
@endsection