@extends('admin.layout')
@section('seo_title')
<title>Website Banners Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Website Banners</li>
@endsection
@section('content')
<div class="card pt-3">
   <div class="card-body">
      <div class="row">
         {{-- @can('pincode-excel-upload')
         @livewire('import')
         @endcan --}}
         @livewire('export')
      </div>
   </div>
</div>

<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h2>
               <div class="float-end">
                  @can('slider-create')
                  <a class="btn btn-success btn-sm" href="{{ route('sliders.create') }}"> <i class="bx bx-add-to-queue"></i> Add New Banner</a>
                  @endcan
               </div>
            </h2>
         </div>
      </div>
      <div class="clearfix"></div>
      <div class="table-responsive">
         <table class="table table-striped table-hover table-bordered table-sm">
            <tr>
               <th>#</th>
               <th>Image</th>
               <th>Title</th>
               <th>Banner URL</th>
               <th>CreatedBy</th>
               <th>Status</th>
               <th>CreatedDate</th>
               <th>UpdateDate</th>
               <th width="280px">Action</th>
            </tr>
            @foreach($sliders->sortByDesc('id')??'' as $slider)
            <tr>
               <td>{{ $slider->id??'' }}</td>
               <td>
                  <img src="{{ url($slider->image??'') }}" width="80px">
               </td>
               <td>{{ $slider->title??'' }}</td>
               <td>{{ $slider->banner_url??'' }}</td>
               <td>{{ $slider->created_by??'' }}</td>
               <td>{{ $slider->status??'' }}</td>
               <td>{{ $slider->created_at->format('d M Y, H:i:s')??'' }}</td>
               <td>{{ $slider->updated_at->format('d M Y, H:i:s')??'' }}</td>
               <td>
                  @can('slider-edit')
                  <a class="btn btn-primary btn-sm" href="{{ route('sliders.edit', $slider) }}">
                  <i class="bx bx-edit-alt"></i> 
                  </a>
                  @endcan
               </td>
            </tr>
            @endforeach
         </table>
      </div>
   </div>
</div>
@endsection