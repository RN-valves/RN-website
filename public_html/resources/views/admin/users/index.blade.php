@extends('admin.layout')
@section('seo_title')
<title>User Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Users</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h2>
               <div class="float-end">
                  @can('user-create')
                     <a class="btn btn-success btn-sm" href="{{ route('users.create') }}"> <i class="bx bx-add-to-queue"></i> Create New User</a>
                  @endcan
               </div>
            </h2>
         </div>
      </div>
      <livewire:user-table/>
   </div>
</div>
@endsection
@section('scripts')
@endsection