@extends('admin.layout')
@section('seo_title')
<title>Catalogue</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Catalogue</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h2>
               <div class="float-end mb-1">
                
                     <a class="btn btn-success btn-sm" href="{{ route('catalogue.create') }}"> <i class="bx bx-add-to-queue"></i> Create New Catalogue QR</a>
              
               </div>
            </h2>
         </div>
         <div class="clearfix"></div>
          <livewire:catalogue-index/>
      </div>
   </div>
</div>
@endsection
@section('scripts')
@endsection