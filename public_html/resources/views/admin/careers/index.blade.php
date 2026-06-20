@extends('admin.layout')
@section('seo_title')
<title>Careers/Job Description Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Careers/Job Description</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h2>
               <div class="float-end">
                  @can('career-create')
                     <a class="btn btn-success btn-sm" href="{{ route('careers.create') }}"> <i class="bx bx-add-to-queue"></i> Create New</a>
                  @endcan
               </div>
            </h2>
         </div>
      </div>
      <livewire:career-index/>
   </div>
</div>
@endsection
@section('scripts')
@endsection