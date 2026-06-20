@extends('admin.layout')
@section('seo_title')
<title>Color Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Action Color</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="row">
         <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
               <h2>
                  Action Color
                  <div class="float-end">
                     @can('color-list')
                     <a class="btn btn-warning" href="{{ route('colors.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>
                     @endcan
                  </div>
               </h2>
            </div>
         </div>
      </div>
      @if (count($errors) > 0)
      <div class="alert alert-danger">
         <strong>Whoops! </strong> There were some problems with your input.<br><br>
         <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
         </ul>
      </div>
      @endif
      <form class="row" method="POST" action="@if(!empty($color)) {{ route('colors.update', $color) }} @else {{ route('colors.store') }} @endif" enctype="multipart/form-data">
         @csrf
         @if(!empty($color))
         @method('PUT')
         @endif
         <div class="col-md-6 form-group mt-3">
            <x-input-label class="mb-1" for="password_confirmation" :value="__('Enter Name')" />
            <input type="text" name="name" class="form-control shadow-none @error('name') is-invalid @enderror" placeholder="Enter Name" value="{{ old('name', @$color->name) }}">
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
         </div>
         <div class="col-md-6 form-group mt-3">
            <x-input-label class="mb-1" for="password_confirmation" :value="__('Color Icon')" />
            <input type="file" name="icon" class="form-control shadow-none @error('icon') is-invalid @enderror" placeholder="Enter icon" value="{{ old('icon', @$color->icon) }}">
            <x-input-error class="mt-2" :messages="$errors->get('icon')" />
         </div>
         <div class="col-md-3 form-group mt-3">
            <button type="submit" class="btn btn-primary btn-block">Submit</button>
         </div>
      </form>
   </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
   $("#parent_id").select2({
     theme: "classic"
   });
</script>
<script type="text/javascript">
   $("#content_id").select2({
     theme: "classic"
   });
</script>
@endsection