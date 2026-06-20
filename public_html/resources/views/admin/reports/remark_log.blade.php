@extends('admin.layout')
@section('seo_title')
<title>Remark Log Report</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Remark Log Report</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h5>Remark Log Report</h5>
         </div>
      </div>
      <div class="col-lg-12 py-2">
         <form class="row" method="GET" action="{{ route('remarkLogs.index') }}">
            @csrf
            <div class="col-lg-3">
               <select class="form-control" name="user_id" id="user_id">
                  @foreach($employees??'' as $user)
                  <option value="{{ $user->id }}">{{ $user->name??'' }}</option>
                  @endforeach
               </select>
            </div>
            <div class="col-lg-3">
               <input type="text" name="from_date" id="datepicker" class="form-control" placeholder="From Date">
            </div>
            <div class="col-lg-3">
               <input type="text" name="end_date" id="end_date" class="form-control" placeholder="End Date">
            </div>
            <div class="col-lg-3">
               <button class="btn btn-info bt-sm w-100" type="submit"> <i class="bx bx-filter-alt"></i> Filter</button>
            </div>
         </form>
      </div>
      <livewire:remark-log-table/>
   </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
$("#user_id").select2({
  theme: "classic"
});
</script>
<script type="text/javascript">
   $('#end_date').datepicker({
        weekStart: 1,
        daysOfWeekHighlighted: "6,0",
        autoclose: true,
        todayHighlight: true,
   });
$('#end_date').datepicker("setDate", new Date());
</script>
@endsection
