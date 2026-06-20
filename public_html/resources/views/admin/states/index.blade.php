@extends('admin.layout')
@section('seo_title')
<title>States Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">States</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="row">
         <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
               <h2>
                  <div class="float-end">
                     @can('state-create')
                     <a class="btn btn-success btn-sm" href="{{ route('states.create') }}"> <i class="bx bx-add-to-queue"></i> Create New State</a>
                     @endcan
                  </div>
               </h2>
            </div>
         </div>
      </div>
      <table class="table table-striped table-hover table-bordered table-sm datatable border">
         <thead>
         <tr>
            <th>#</th>
            <th>Country</th>
            <th>Name</th>
            <th>Code</th>
            <th>Cities</th>
            <th>Pincodes</th>
            <th width="280px">Action</th>
         </tr>
         </thead>
         @foreach($states??'' as $state)
         <tr>
            <td>{{ $state->id??'' }}</td>
            <td>{{ $state->country->name??'' }}</td>
            <td>{{ $state->name??'' }}</td>
            <td>{{ $state->code??'' }}</td>
            <td>{{ $state->cities->count()??'' }}</td>
            <td>{{ $state->pincodes->count()??'' }}</td>
            <td>
               @can('state-edit')
               <a class="btn btn-primary btn-sm" href="{{ route('states.edit', $state) }}">
                  <i class="bx bx-edit-alt"></i> Edit
               </a>
               @endcan
            </td>
         </tr>
         @endforeach
      </table>
   </div>
</div>
@endsection