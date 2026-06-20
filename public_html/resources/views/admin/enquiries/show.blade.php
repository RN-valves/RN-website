@extends('admin.layout')
@section('seo_title')
<title>Enquiry</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Enquiry</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h2>
               <small>Enquiry Details - ENQ{{ $enquiry->id??'' }}</small>
               <div class="float-end">
                  <div class="">
                     @can('enquiry-edit')
                     <a class="btn btn-primary btn-sm" href="{{ route('enquiries.edit', $enquiry) }}"> <i class="bx bx-edit-alt"></i> Edit Enquiry</a>
                     @endcan
                     @can('enquiry-list')
                     <a class="btn btn-warning btn-sm" href="{{ route('enquiries.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>
                     @endcan
                  </div>
               </div>
            </h2>
         </div>
         <div class="clearfix"></div>
      </div>
      <div class="row">
         <div class="col-md-9">
            <div class="table-responsive">
               <table class="table table-bordered">
                  <thead>
                     <tr>
                        <th>Name</th>
                        <td>{{ $enquiry->name??'' }}</td>
                        <th>Company Name</th>
                        <td>{{ $enquiry->company_name??'' }}</td>
                     </tr>
                     <tr>
                        <th>Mobile</th>
                        <td>{{ $enquiry->mobile??'' }}</td>
                        <th>Email</th>
                        <td>{{ $enquiry->email??'' }}</td>
                     </tr>
                     <tr>
                        <th class="bg-light">Enquiry Type</th>
                        <td class="bg-light">{{ $enquiry->enquiry_type??'' }}</td>
                        <th class="bg-light">Scource</th>
                        <td class="bg-light">{{ $enquiry->scource_type??'' }}</td>
                     </tr>
                     <tr>
                        <th>Country</th>
                        <td>{{ $enquiry->country->name??'' }}</td>
                        <th>State</th>
                        <td>{{ $enquiry->state->name??'' }}</td>
                     </tr>
                     <tr>
                        <th>City</th>
                        <td>{{ $enquiry->city->name??'' }}</td>
                        <th>State</th>
                        <td>{{ $enquiry->zipcode??'' }}</td>
                     </tr>
                     <tr>
                        <th>Address</th>
                        <td>{{ $enquiry->address??'' }}</td>
                        <th>Status</th>
                        <td class="bg-warning">{{ $enquiry->status??'' }}</td>
                     </tr>
                     <tr>
                        <th>Message/Purpose</th>
                        <td>{{ $enquiry->purpose??'' }}</td>
                        <th>Published At</th>
                        <td>{{ $enquiry->published_at->format('d M Y, H:i:s')??'' }}</td>
                     </tr>
                     <tr>
                        <th>Scource Url</th>
                        <td>
                           <a target="_blank" href="{{ url($enquiry->page_url??'') }}">@if(!empty($enquiry->page_url)) Click to Page Link @endif</a>
                        </td>
                        <th>Updated By</th>
                        <td>{{ $enquiry->created_by??'' }} - {{ $enquiry->created_at->format('d M Y, H:i:s')??'' }}</td>
                     </tr>
                     <tr>
                        <th>IP Address</th>
                        <td>{{ $enquiry->ip_address??'' }}</td>
                        <th>CreatedAt</th>
                        <td>{{ $enquiry->created_at->format('d M Y, H:i:s')??'' }}</td>
                     </tr>
                  </thead>
               </table>
            </div>
         </div>
         <div class="col-md-3 border">
            <form method="POST" action="{{ route('remarkLogs.store') }}" class="row">
               @csrf
               <input type="hidden" name="en_type" value="Enquiry">
               <input type="hidden" name="logable_id" value="{{ $enquiry->id }}">
               <x-input-error class="mb-2 text-danger" :messages="$errors->get('logable_id')" />
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
               <h4 class="text-center bg-secondary text-white py-2">Log Report</h4>
            </div>
            <div class="table-responsive pt-2" style="max-height: 400px; overflow: scroll;">
               <table class="table table-bordered">
                  <thead>
                     @foreach($enquiry->logables->sortByDesc('id')->take(20)??'' as $log)
                     <tr>
                        <td>
                           <strong>{{ $log->user_name??'' }}</strong> : {{ $log->created_at->format('d M Y, H:i:s') }} <br>
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
@endsection