@extends('admin.layout')
@section('seo_title')
<title>Permissions Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Permissions</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="row">
         <div class="col-md-12">
            <div class="p-1">
               <div class="card-body">
                  <h4>Permissions
                     @can('permissions-create')
                     <a href="{{ route('permissions.create') }}" class="btn btn-success btn-sm float-end"> <i class="bx bx-add-to-queue"></i> Add Permission</a>
                     @endcan
                  </h4>
               </div>
               <div class="card-body table-responsive">
                  <table class="table table-striped table-hover table-bordered table-sm border">
                     <thead>
                        <tr>
                           <th class="text-center">Id</th>
                           <th>Name</th>
                           <th>Created Date</th>
                           <th width="40%">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($permissions as $permission)
                        <tr>
                           <td class="text-center">{{ $permission->id }}</td>
                           <td class="text-uppercase">{{ $permission->name }}</td>
                           <td class="text-uppercase">{{ $permission->created_at->format('d M Y') }}</td>
                           <td>
                              <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST">
                                 @can('permissions-edit')
                                 <a class="btn btn-info btn-sm" href="{{ route('permissions.show', $permission->id) }}"><i class="bx bx-detail"></i> Show</a>
                                 @endcan
                                 @can('permissions-edit')
                                 <a class="btn btn-primary btn-sm" href="{{ route('permissions.edit', $permission->id) }}"><i class="bx bx-edit-alt"></i> Edit</a>
                                 @endcan
                                 @csrf
                                 @method('DELETE')
                                 @can('permissions-delete')
                                 <button type="submit" class="btn btn-danger btn-sm"><i class="bx bx-trash"></i> Delete</button>
                                 @endcan
                              </form>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection