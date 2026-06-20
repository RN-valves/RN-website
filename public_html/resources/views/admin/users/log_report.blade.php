@extends('admin.layout')
@section('seo_title')
<title>User Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">{{ $user->name??'' }}</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body">
      <div class="row">
         @include('admin.users.partials.menu')
         @include('admin.users.partials.basic_detail')
      </div>
      <div class="col-lg-12">
         <div class="table-responsive">
            <h4>Log Report
               <div class="float-end">
                  @can('user-log-remark-index')
                  
                  @if($user->user_type=="Customer")
                  <a href="{{ route('customers.show', ['customer'=>$user]) }}" class="btn btn-secondary border btn-sm"><i class="bx bx-add-to-queue"></i> Add New Log</a>
                  @else
                  <a href="{{ route('users.show', $user) }}" class="btn btn-secondary border btn-sm"><i class="bx bx-add-to-queue"></i> Add New Log</a>
                  @endif

                  @endcan
               </div>
            </h4>
            <table class="table table-hover table-bordered table-sm">
               <thead>
                  <tr>
                     <th>CreatedAt</th>
                     <th>Name</th>
                     <th>Remarks</th>
                     <th>Message</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($userRemarkLogs??'' as $log)
                  <tr>
                     <td>{{ $log->created_at->format('d M Y, H:i:s')??'' }}</td>
                     <td>{{ $log->user->name??'' }}</td>
                     <td>{{ $log->remark??'' }}</td>
                     <td>{{ $log->message??'' }}</td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
            {{ $userRemarkLogs->links() }}
         </div>
      </div>
   </div>
</div>
@endsection
@section('scripts')
@endsection