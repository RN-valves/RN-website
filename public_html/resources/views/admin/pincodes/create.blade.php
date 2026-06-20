@extends('admin.layout')
@section('seo_title')
<title>Pincode Create</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Create New Pincode</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="row">
         <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
               <h2>
                  {{ $title }}
                  <div class="float-end">
                     @can('pincode-list')
                     <a class="btn btn-warning" href="{{ route('pincodes.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>
                     @endcan
                  </div>
               </h2>
            </div>
         </div>
      </div>
      {{-- @if (count($errors) > 0)
      <div class="alert alert-danger">
         <strong>Whoops! </strong> There were some problems with your input.<br><br>
         <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
         </ul>
      </div>
      @endif --}}
      <form action="@if(!empty($pincode)) {{ route('pincodes.update', $pincode) }} @else {{ route('pincodes.store') }} @endif" method="POST" class="row g-3">
         @csrf
         @if(!empty($pincode))
         @method('PATCH')
         @endif
         <div class="col-lg-4 mb-3">
            <label for="country_id" style="width: 100%">
               Select Country for  Add/Edit to Pincode <strong class="text-danger">{{ @$pincode->country->name??'' }}</strong>
               <select class="js-example-basic-single js-states form-control" id="country_id" name="country_id" style="width:100%;">
                  <option value="">Select Country</option>
                  @foreach ($countries as $country)
                  <option value="{{ $country->id }}" @selected(old('country_id'))>{{ $country->name }}</option>
                  @endforeach
               </select>
            </label>
            <x-input-error class="mt-2" :messages="$errors->get('country_id')" />
         </div>
         <div class="col-lg-4 mb-3" id="state_group">
            <label for="state_id" style="width: 100%">
               Select State for  Add/Edit to Pincode  <strong class="text-danger">{{ @$pincode->state->name??'' }}</strong>
               <select class="js-example-basic-single js-states form-control" id="state_id" name="state_id" style="width:100%;">
                  
               </select>
            </label>
            <x-input-error class="mt-2" :messages="$errors->get('state_id')" />
         </div>
         <div class="col-lg-4 mb-3" id="city_group">
            <label for="city_id" style="width: 100%">
               Select City for  Add/Edit to Pincode  <strong class="text-danger">{{ @$pincode->city->name??'' }}</strong>
               <select class="js-example-basic-single js-states form-control" id="city_id" name="city_id" style="width:100%;">
                  
               </select>
            </label>
            <x-input-error class="mt-2" :messages="$errors->get('city_id')" />
         </div>
         <div class="col-lg-12 clearfix"></div>
         <div class="col-md-6">
            <div class="form-floating">
               <input type="text" name="name" id="name" class="form-control shadow-none @error('name') is-invalid @enderror" autocomplete="off" placeholder="New Delhi" value="{{ old('name',@$pincode->name) }}">
               <x-input-error class="mt-2" :messages="$errors->get('name')" />
               <label for="name">Pincode Area Name</label>
            </div>
         </div>
         <div class="col-md-6">
            <div class="form-floating">
               <input type="text" name="code" id="code" class="form-control shadow-none @error('code') is-invalid @enderror" autocomplete="off" placeholder="07" value="{{ old('code',@$pincode->code) }}">
               <x-input-error class="mt-2" :messages="$errors->get('code')" />
               <label for="code">Pin Code</label>
            </div>
         </div>
         <div class="">
            <button type="submit" id="btnId" class="btn btn-success">Submit</button>
         </div>
      </form>
   </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
   $("#country_id").select2({
         placeholder: "Select a data",
         allowClear: true
     });
</script>
<script type="text/javascript">
   $("#state_id").select2({
         placeholder: "Select a data",
         allowClear: true
     });
</script>
<script type="text/javascript">
   $("#city_id").select2({
         placeholder: "Select a data",
         allowClear: true
     });
</script>
<script type="text/javascript">
   $(document).ready(function(){
      $("#state_group").hide();
      $("#city_group").hide();
      $("#country_id").on('click', function(){
         var countryId = this.value;
         $("#state_id").html();
         $.ajax({
            url: '{{ route('states.getCountryStates') }}',
            type: 'POST',
            data: {
               countryId: countryId,
               _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function(result){
               if(result){
                  $("#state_group").show();
                  $("#state_id").html('<option value="">Select State</option>');
                  $.each(result.state, function (key, value) {
                     $("#state_id").append('<option value="' + value
                     .id + '">' + value.name + ' - ' + value.code + '</option>');
                  });
               }else{
                  alert('error');
               }
               
            }
         });
      });
   });
</script>
<script type="text/javascript">
   $(document).ready(function(){
      $("#state_id").on('click', function(){
         var stateId = this.value;
         $("#city_id").html();
         $.ajax({
            url: '{{ route('states.get_json_state_city') }}',
            type: 'POST',
            data: {
               stateId: stateId,
               _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function(result){
               if(result){
                  $("#city_group").show();
                  $("#city_id").html('<option value="">Select City</option>');
                  $.each(result.cities, function (key, value) {
                     $("#city_id").append('<option value="' + value
                     .id + '">' + value.name + ' - ' + value.code + '</option>');
                  });
               }else{
                  alert('error');
               }
               
            }
         });
      });
   });
</script>
@endsection