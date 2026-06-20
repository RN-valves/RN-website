@extends('admin.layout')
@section('seo_title')
<title>Country Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Countries</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="row">
         <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
               <h2>
                  <div class="float-end">
                     @can('country-create')
                     <a class="btn btn-success btn-sm" href="{{ route('countries.create') }}"> <i class="bx bx-add-to-queue"></i> Create New Country</a>
                     @endcan
                  </div>
               </h2>
            </div>
         </div>
      </div>
      <table class="table table-striped table-hover table-bordered table-sm">
         <tr>
            <th>#</th>
            <th>Name</th>
            <th>Code</th>
            <th>States</th>
            <th width="280px">Action</th>
         </tr>
         @foreach($countries??'' as $country)
         <tr>
            <td>{{ $country->id??'' }}</td>
            <td>{{ $country->name??'' }}</td>
            <td>{{ $country->code??'' }}</td>
            <td>{{ $country->states->count()??'' }}</td>
            <td>
               @can('country-edit')
               <a class="btn btn-primary btn-sm" href="{{ route('countries.edit', $country) }}">
               <i class="bx bx-edit-alt"></i> 
               </a>
               @endcan
            </td>
         </tr>
         @endforeach
      </table>
   </div>
</div>
@endsection