@extends('admin.layout')
@section('seo_title')
<title>Permissions Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Create Permissions</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="row">
         <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
               <h2>
                  Create Permission
                  <div class="float-end">
                     @can('user-list')
                     <a class="btn btn-warning" href="{{ route('permissions.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>
                     @endcan
                  </div>
               </h2>
            </div>
         </div>
      </div>
      @if (count($errors) > 0)
      <div class="alert alert-danger">
         <strong>Whoops! </strong> There were some problems with your input.<br><br>
         <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
         </ul>
      </div>
      @endif
      <form action="{{ route('permissions.store') }}" method="POST">
         @csrf
         <div class="mb-3">
            <label for="">Permission Name</label>
            <input type="text" name="name" class="form-control" />
         </div>
         <div class="mb-3">
            <button type="submit" class="btn btn-success">Submit</button>
         </div>
      </form>
      <!-- End floating Labels Form -->
   </div>
</div>
@endsection