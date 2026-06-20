@extends('admin.layout')
@section('seo_title')
<title>Remark Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Remarks</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h2>
               <div class="float-end">
                  @can('remark-create')
                     <a class="btn btn-success btn-sm" href="{{ route('remarks.create') }}"> <i class="bx bx-add-to-queue"></i> Create New Remark</a>
                  @endcan
               </div>
            </h2>
         </div>
      </div>
      <div class="clearfix"></div>
      <div class="table-responsive">
         <table class="table table-striped table-hover table-bordered table-sm border">
            <thead>
               <tr>
                  <th>Id</th>
                  <th>Type</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>CreatedAt</th>
                  <th>Actions</th>
               </tr>
            </thead>
            
            <tbody>
               @foreach($remarks??'' as $remark)
               <tr>
                  <td>{{ $remark->id??0 }}</td>
                  <td>{{ $remark->type??'' }}</td>
                  <td>{{ $remark->name??'' }}</td>
                  <td>{{ $remark->description??'' }}</td>
                  <td>{{ $remark->created_at->format('d M Y, H:i:s')??'' }}</td>
                  <td>
                     <form action="{{ route('remarks.destroy', $remark->id) }}" method="POST">
                        <a class="btn btn-info btn-sm" href="{{ route('remarks.show', $remark->id) }}"><i class="bx bx-detail"></i> Show</a>
                        @can('remark-edit')
                        <a class="btn btn-primary btn-sm" href="{{ route('remarks.edit', $remark->id) }}"><i class="bx bx-edit-alt"></i> Edit</a>
                        @endcan
                        @csrf
                        @method('DELETE')
                        @can('remark-delete')
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
@endsection
@section('scripts')
@endsection