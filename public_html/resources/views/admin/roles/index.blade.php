@extends('admin.layout')
@section('seo_title')
<title>Roles Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Roles</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="row">
         <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
               <h4>
                  Role/Designation Management
                  <div class="float-end">
                     @can('role-create')
                     <a class="btn btn-success btn-sm" href="{{ route('roles.create') }}"> <i class="bx bx-add-to-queue"></i> Create New Role</a>
                     @endcan
                  </div>
               </h4>
            </div>
         </div>
      </div>
      <table class="table table-striped table-bordered">
         <tr>
            <th>Name</th>
            <th>Created Date</th>
            <th width="280px">Action</th>
         </tr>
         @foreach ($roles as $key => $role)
         <tr>
            <td>{{ $role->name }}</td>
            <td>{{ $role->created_at->format('d M Y') }}</td>
            <td>
               <form action="{{ route('roles.destroy', $role->id) }}" method="POST">
                  <a class="btn btn-info btn-sm" href="{{ route('roles.show', $role->id) }}"><i class="bx bx-detail"></i> Show</a>
                  @can('role-edit')
                  <a class="btn btn-primary btn-sm" href="{{ route('roles.edit', $role->id) }}"><i class="bx bx-edit-alt"></i> Edit</a>
                  @endcan
                  @csrf
                  @method('DELETE')
                  @can('role-delete')
                  <button type="submit" class="btn btn-danger btn-sm"><i class="bx bx-trash"></i> Delete</button>
                  @endcan
               </form>
            </td>
         </tr>
         @endforeach
      </table>
      {!! $roles->render() !!}
   </div>
</div>
@endsection