@extends('admin.layout')
@section('seo_title')
<title>Catalogue Index</title>
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
               <div class="float-end">            
                  <a class="btn btn-info btn-sm" href="{{ route('catalogue.edit', $content) }}"> <i class="bx bx-edit-alt"></i> Edit Catalogue</a>              
                  <a class="btn btn-warning btn-sm" href="{{ route('catalogue.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>  
               </div>
            </h2>
         </div>
      </div>
      <div class="clearfix"></div>
      <div class="row">
         <div class="col-lg-12">
            <div class="card-header">
               <h5 class="mb-0 text-dark">CTL{{ $content->id }} : {{ $content->name??'' }}</h5>      
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <a class="btn btn-primary" download href="{{asset($content->pdf)}}">Download PDF</a>                      
                    </div>
                    <div class="col-6">
                        <a class="btn btn-warning" download="{{@$content->name}}QR-Code" href="{{asset($content->qr_code)}}">Download QR Code</a>
                    </div>

                </div>
            </div>
         </div>
       
      </div>
   </div>
</div>
@endsection
@section('scripts')
@endsection