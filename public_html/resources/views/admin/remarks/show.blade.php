@extends('admin.layout')
@section('seo_title')
<title>Role Show</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
<li class="breadcrumb-item active">Create User</li>
@endsection

@section('content')

<div class="card">
    <div class="card-body py-3">

      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h2>
               <div class="float-end">
                  <div class="">
                  @can('remark-edit')
                     <a class="btn btn-primary btn-sm" href="{{ route('remarks.edit', $remark) }}"> <i class="bx bx-edit-alt"></i> Edit remark</a>
                  @endcan
                  @can('remark-list')
                  <a class="btn btn-warning btn-sm" href="{{ route('remarks.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>
                  @endcan
                  </div>
               </div>
            </h2>
         </div>
         <div class="clearfix"></div>
      </div>


    <div class="row">
        <div class="col-xs-12 mb-3">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $remark->name }}
                <p>{{ $remark->description??'' }}</p>
            </div>
        </div>
    </div>
    </div>
</div>

@endsection

