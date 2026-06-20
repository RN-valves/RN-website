@extends('admin.layout')
@section('seo_title')
<title>Careers/Jobs Descriptions</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Careers/Jobs Descriptions</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h2>
               <small>Careers/Jobs Descriptions Details - CR{{ $career->id??'' }}</small>
               <div class="float-end">
                  <div class="asdasd">
                     @can('career-edit')
                     <a class="btn btn-primary btn-sm" href="{{ route('careers.edit', $career) }}"> <i class="bx bx-edit-alt"></i> Edit</a>
                     @endcan
                     @can('career-list')
                     <a class="btn btn-warning btn-sm" href="{{ route('careers.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>
                     @endcan
                  </div>
               </div>
            </h2>
         </div>
         <div class="clearfix"></div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="table-responsive">
               <table class="table table-bordered">
                  <thead>
                     <tr>
                        <th style="width:100px!important;">Title</th>
                        <td>{{ $career->title??'' }}</td>
                     </tr>
                     <tr>
                        <th style="width:100px!important;">Designation</th>
                        <td>{{ $career->designation??'' }}</td>
                     </tr>
                     <tr>
                        <th style="width:100px!important;">Country</th>
                        <td>{{ $career->country??'' }}</td>
                     </tr>
                     <tr>
                        <th style="width:100px!important;">State</th>
                        <td>{{ $career->state??'' }}</td>
                     </tr>
                     <tr>
                        <th style="width:100px!important;">City</th>
                        <td>{{ $career->city??'' }}</td>
                     </tr>
                     <tr>
                        <th style="width:100px!important;">Zipcode</th>
                        <td>{{ $career->zipcode??'' }}</td>
                     </tr>
                     <tr>
                        <th style="width:100px!important;">Created By</th>
                        <td>{{ $career->created_by??'' }} - {{ $career->created_at->format('d M Y, H:i:s')??'' }}</td>
                     </tr>
                     <tr>
                        <th style="width:100px!important;">Updated By</th>
                        <td>{{ $career->edit_by??'' }} - {{ $career->updated_at->format('d M Y, H:i:s')??'' }}</td>
                     </tr>
                     <tr>
                        <th style="width:100px!important;">Published At</th>
                        <td>{{ $career->published_at->format('d M Y, H:i:s')??'' }}</td>
                     </tr>
                     <tr>
                        <th style="width:100px!important;">Content</th>
                        <td>{!! $career->content??'' !!}</td>
                     </tr>
                     @if(!empty($career->attachment))
                     <tr>
                        <th style="width:100px!important;">Attachment</th>
                        <td>
                           <a target="_blank" href="{{ url($career->attachment??'') }}">Click to Document</a>
                        </td>
                     </tr>
                     @endif
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