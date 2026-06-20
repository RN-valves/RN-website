@extends('admin.layout')
@section('seo_title')
<title>Role Edit - {{ $role->name??'' }}</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Create User</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      @if (count($errors) > 0)
      <div class="alert alert-danger">
         <strong>Whoops!</strong> There were some problems with your input.<br><br>
         <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
         </ul>
      </div>
      @endif
      <form action="{{ route('roles.update', $role->id) }}" method="POST">
         @csrf
         @method('PATCH')
         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
               <div class="card-body">
                  <div class="pull-left">
                     <h4>
                        Edit Role/Designation - <strong>{{ $role->name }}</strong>
                        <div class="float-end">
                           <a class="btn btn-warning" href="{{ route('roles.index') }}"> <i class="bx bx-arrow-to-left"></i>  Back</a>
                        </div>
                     </h4>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12 py-3 g-3">
                     <div class="form-group">
                        <strong>Enter Name:</strong>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{ $role->name }}">
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                     </div>
                     <div class="form-group pt-2">
                        <button type="submit" class="btn btn-success">Submit with Atleast 1 Permission Selected</button>
                     </div>
                  </div>
                  <div class="table-responsive">
                     <table class="table table-striped table-bordered">
                        <tr>
                           <th>Name</th>
                           <th>Created Date</th>
                        </tr>
                        @foreach ($permission as $permission)
                        <tr>
                           <td>
                              <label class="text-uppercase">
                              <input type="checkbox" name="permission[]" @if (in_array($permission->id, $rolePermissions)) checked @endif  value="{{ $permission->id }}" class="name">
                              {{ $permission->name }}
                              </label>
                           </td>
                           <td>{{ $permission->created_at->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                     </table>
                  </div>
                  <button type="submit" class="btn btn-success">Submit</button>
               </div>
            </div>
         </div>
      </form>
   </div>
</div>
@endsection