@extends('admin.layout')
@section('seo_title')
<title>State Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Edit State</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="row">
         <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
               <h2>
                  {{ $title??'' }}
                  <div class="float-end">
                     @can('state-list')
                     <a class="btn btn-warning" href="{{ route('states.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>
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
      <form action="{{ route('states.update',$state) }}" method="POST" class="row g-3">
         @csrf
         @method('PATCH')
         <div class="col-lg-12 mb-3">
            <label for="id_label_single" style="width:100%">
               Select Country
               <select class="js-example-basic-single js-states form-control" id="id_label_single" name="country_id">
                  <option value="">Select Country</option>
                  @foreach ($countries as $country)
                  <option value="{{ $country->id }}" @selected(old('country_id', @$state->country_id)==$country->id)>{{ $country->code }} {{ $country->name }}</option>
                  @endforeach
               </select>
            </label>
            <x-input-error class="mt-2" :messages="$errors->get('country_id')" />
         </div>
         <div class="col-md-6">
            <div class="form-floating">
               <input type="text" name="name" id="name" class="form-control shadow-none @error('name') is-invalid @enderror" autocomplete="off" placeholder="Delhi" value="{{ old('name', @$state->name) }}">
               <x-input-error class="mt-2" :messages="$errors->get('name')" />
               <label for="name">State Name</label>
            </div>
         </div>
         <div class="col-md-6">
            <div class="form-floating">
               <input type="text" name="code" id="code" class="form-control shadow-none @error('code') is-invalid @enderror" autocomplete="off" placeholder="07" value="{{ old('code',@$state->code??'') }}">
               <x-input-error class="mt-2" :messages="$errors->get('code')" />
               <label for="code">State Code</label>
            </div>
         </div>
         <div class="">
            <button type="submit" id="btnId" class="btn btn-success">Update</button>
         </div>
      </form>
   </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
   $("#id_label_single").select2({
         placeholder: "Select a data",
         allowClear: true
     });
</script>
<script type="text/javascript">
   $(function () {
       $('#date').datetimepicker();
   });
</script>
<script type="text/javascript">
    $("#btnId").click(function(e){
     e.preventDefault();
     //show loading gif
     $(this).closest('form').submit();
});
</script>
@endsection