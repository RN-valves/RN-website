@extends('admin.layout')
@section('seo_title')
<title>User Details - {{ $user->name??'' }}</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Users</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body">
      <div class="card-header">
         User Details - {{ $user->user_code }}
         <div class="float-end">
            @can('user-edit')
            <a class="btn-sm btn btn-primary" href="{{ route('users.edit',$user) }}"><i class="bx bx-edit-alt"></i> Edit</a>
            @endcan
            @can('user-list')
            <a class="btn-sm btn btn-warning" href="{{ route('users.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>
            @endcan
         </div>
      </div>
      <div class="row">
         @include('admin.users.partials.menu')
         <!-- User Details Section -->
         <div class="col-md-9">
            <table class="table table-hover table-bordered">
               <tr>
                  <th>Name</th>
                  <td>{{ $user->name }} ({{ $user->user_type??'' }})</td>
               </tr>
               <tr>
                  <th>Email</th>
                  <td>{{ $user->email }}</td>
               </tr>
               <tr>
                  <th>Phone</th>
                  <td>{{ $user->country->code }}-{{ $user->mobile }}</td>
               </tr>
               <tr>
                  <th>Address</th>
                  <td>{{ $user->address }} <br>
                     {{ $user->zipcode??'NA' }} - {{ $user->city->name??'NA' }}, {{ $user->state->name??'NA' }}, {{ $user->country->name??'NA' }}
                  </td>
               </tr>
               <tr>
                  <th>Created Date</th>
                  <td>{{ $user->created_at->format('d M Y, H:i:s') }}</td>
               </tr>
               <tr>
                  <th>Code</th>
                  <td>{{ $user->user_code }}</td>
               </tr>
               <tr>
                  <th>Password</th>
                  <td>{{ $user->local_password??'' }}</td>
               </tr>
               <tr>
                  <th>AssignedTo/Reporting</th>
                  <td>
                     @foreach($user->reporting_users??'' as $reporting_user)
                     <span class="bg-light border bg-sm px-3">{{ $reporting_user->reporting_user->name??'' }}</span>
                     @endforeach
                  </td>
               </tr>
               <tr>
                  <th>Assigned Roles</th>
                  <td>
                     @foreach($user->getRoleNames()??'' as $role)
                     <small class="p-1 bg-light border text-success"><b>{{ $role }}</b></small>
                     @endforeach
                  </td>
               </tr>
               <tr>
                  <th>Account Status</th>
                  <td>{{ $user->status??'' }}</td>
               </tr>
            </table>

            <div class="row">
               <div class="col-lg-5">
                  <div class="card-title bg-light border py-2">
                     <p class="mb-0 px-2"><i class="bx bx-edit-alt"></i> Edit Assigned Users</p>
                  </div>
                  <table class="table table-bordered">
                     <tr>
                        <th class="text-center" colspan="2">Assigned Users</th>
                     </tr>
                     @foreach($user->reporting_users??'' as $reporting_user)
                     <tr>
                        <td>{{ $reporting_user->reporting_user->name??'' }}</td>
                        <td>{{ $reporting_user->reporting_user->user_code??'' }}</td>
                     </tr>
                     @endforeach
                  </table>
                  <form method="POST" action="{{ route('editLogs.store') }}">
                     @csrf
                     <input type="hidden" name="customer_id" value="{{ $user->id }}">
                     <input type="hidden" name="remark" value="Change Customer Assigned User">
                     <div class="from-group">
                        <label>Select Users</label>
                        <select class="js-example-basic-multiple js-states form-control" id="select_user" name="reporting_ids[]" multiple="">
                        @foreach ($employees as $employees)
                        <option value="{{ $employees->id }}" @foreach($user->reporting_users as $reporting){{$reporting->reporting_id == $employees->id ? 'selected': ''}}   @endforeach> {{ $employees->name }} ({{ $employees->mobile??'' }})</option>
                        @endforeach
                        </select>
                     </div>
                     <div class="pt-2 form-group">
                        <button class="btn btn-block btn-primary btn-sm" type="submit">Submit</button>
                     </div>
                  </form>
               </div>
               <div class="col-lg-7">
                  <div class="card-title bg-light border py-2">
                     <p class="mb-0 px-2"><i class="bx bx-history"></i> Edit Assigned User Log</p>
                  </div>
                  <div class="table-responsive" style="max-height: 350px;overflow-y: scroll;">
                     <table class="table table-bordered">
                        <thead>
                           @foreach($user->customerEditLogs->sortByDesc('id')->take(20)??'' as $editLog)
                           <tr>
                              <td>
                                 <strong>{{ $editLog->user->name??'' }}</strong> -<small>{{ $editLog->created_at->format('d M Y, H:i:s') }}</small> <br>
                                 <small>{{ $editLog->remark??'' }}</small>
                              </td>
                           </tr>
                           @endforeach
                        </thead>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-3 border">
            <form method="POST" action="{{ route('remarkLogs.store') }}" class="row">
               @csrf
               <input type="hidden" name="en_type" value="User">
               <input type="hidden" name="logable_id" value="{{ $user->id }}">
               <div class="col-lg-12 pt-2 form-group">
                  <label class="mb-2">Select Remark</label>
                  <select class="form-control" name="remark" id="remark">
                     <option value="">Select</option>
                     @foreach($remarks??'' as $remark)
                     <option value="{{ $remark->name??'' }}" @selected(old('remark')==$remark->name??'')>{{ $remark->name??'' }}</option>
                     @endforeach
                  </select>
                  <x-input-error class="mb-2 text-danger" :messages="$errors->get('remark')" />
               </div>
               <div class="col-lg-12 pt-2 form-group">
                  <label class="mb-2">Enter Message</label>
                  <textarea rows="3" name="message" class="form-control" placeholder="Enter Remarks">{{ old('message') }}</textarea>
                  <x-input-error class="mt-2 text-danger" :messages="$errors->get('message')" />
               </div>
               <div class="col-lg-12 pt-2 form-group">
                  <button class="btn btn-block btn-primary btn-sm" type="submit">Submit</button>
               </div>
            </form>
            <div class="pt-3">
               <div class="card-title bg-light border py-2">
                  <p class="mb-0 px-2"><i class="bx bx-history"></i> Remark Log Report</p>
               </div>
            </div>
            <div class="table-responsive pt-2" style="max-height: 400px; overflow: scroll;">
               <table class="table table-bordered">
                  <thead>
                     @foreach($user->logables->sortByDesc('id')->take(20)??'' as $log)
                     <tr>
                        <td>
                           <strong>{{ $log->user->name }}</strong> : {{ $log->created_at->format('d M Y, H:i:s') }} <br>
                           <span class="text-muted">{{ $log->remark??'' }}</span> <br>
                           {{ $log->message??'' }}
                        </td>
                     </tr>
                     @endforeach
                  </thead>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
   $("#remark").select2({
     theme: "classic"
   });
</script>
<script type="text/javascript">
   $("#select_user").select2({
     theme: "classic"
   });
</script>
@endsection