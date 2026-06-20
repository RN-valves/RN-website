@extends('admin.layout')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@section('seo_title')
<title>User Create</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Create User</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body bg-light py-3">
      <div class="row">
         <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
               <h2>
                  Create New User
                  <div class="float-end">
                     @can('user-list')
                     <a class="btn btn-warning" href="{{ route('users.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>
                     @endcan
                  </div>
               </h2>
            </div>
         </div>
      </div>

      <form action="{{ route('users.store') }}" method="POST" class="row g-3">
         @csrf
         <div class="col-lg-6 mb-3">
            <label for="roles_select" style="width:100%;">
              Select the Role
              <select class="js-example-basic-multiple js-states form-control" id="roles_select" name="roles">
                  @foreach ($roles as $role)
                  <option value="{{ $role }}" @selected(old('roles'))>{{ $role }}</option>
                  @endforeach
              </select>
            </label>
         </div>
         <div class="col-lg-6 mb-3">
            <label for="select_user" style="width:100%;">
              Select Reporting User
              <select class="js-example-basic-multiple js-states form-control" id="select_user" name="reporting_ids[]" multiple="">
                  @foreach ($employees as $employees)
                  <option value="{{ $employees->id }}" {{ (collect(old('reporting_ids'))->contains($employees->id)) ? 'selected':'' }}>{{ $employees->name??'' }}</option>
                  @endforeach
              </select>
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('reporting_ids')" />
            </label>
         </div>
         <div class="col-md-6">
            <div class="form-group">
               <label for="name">Name</label>
               <input type="text" name="name" id="name" class="form-control shadow-none @error('name') is-invalid @enderror" autocomplete="off" placeholder="Name" value="{{ old('name') }}">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('name')" />
            </div>
         </div>
         <div class="col-md-6">
            <div class="form-group">
               <label for="email">Email</label>
               <input type="text" name="email" id="email" class="form-control shadow-none @error('email') is-invalid @enderror" autocomplete="off" placeholder="email" value="{{ old('email') }}">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('email')" />
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label for="mobile">Mobile</label>
               <input type="text" name="mobile" id="mobile" class="form-control shadow-none @error('mobile') is-invalid @enderror" autocomplete="off" placeholder="mobile" value="{{ old('mobile') }}">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('mobile')" />
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label for="user_code">User Code</label>
               <input type="text" name="user_code" id="user_code" class="form-control shadow-none @error('user_code') is-invalid @enderror" autocomplete="off" placeholder="user_code" value="{{ old('user_code') }}">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('user_code')" />
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label for="zipcode">Zip/PIN Code</label>
               <input type="text" name="zipcode" id="zipcode" class="form-control shadow-none @error('zipcode') is-invalid @enderror" autocomplete="off" placeholder="zipcode" value="{{ old('zipcode') }}">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('zipcode')" />
               <span id="pinError" class="text-danger">Pincode is invalid or not match our records</span>
            </div>
         </div>
         <div class="col-lg-4 mb-3" id="city_group">
            <label for="city_id" style="width: 100%">
               Select City
               <select class="js-example-basic-single js-states form-control" id="city_id" name="city_id">
                  
               </select>
            </label>
            <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('city_id')" />
         </div>
         <div class="col-lg-4 mb-3" id="city_group">
            <label for="city_id" style="width: 100%">
               Select State
               <select class="js-example-basic-single js-states form-control" id="state_id" name="state_id">
                  
               </select>
            </label>
            <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('state_id')" />
         </div>
         <div class="col-lg-4 mb-3" id="city_group">
            <label for="city_id" style="width: 100%">
               Select Country
               <select class="js-example-basic-single js-states form-control" id="country_id" name="country_id">
                  
               </select>
            </label>
            <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('country_id')" />
         </div>
         <div class="col-12">
            <div class="form-group">
               <label for="floatingTextarea">Address</label>
               <textarea class="form-control shadow-none @error('address') is-invalid @enderror" autocomplete="off" placeholder="Address" name="address" id="floatingTextarea" style="height: 100px;">{{ old('address') }}</textarea>
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('address')" />
            </div>
         </div>
         <div class="col-md-3 form-group mt-3">
            <x-input-label class="mb-1" for="status" :value="__('Status')" />
            <select class="form-control shadow-none @error('status') is-invalid @enderror" name="status" id="status">
               <option value="Active" @selected(old('status',@$user->status)=='Active')>Active</option>
               <option value="InActive" @selected(old('status',@$user->status)=='InActive')>InActive</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('status')" />
         </div>
         <div class="form-group">
            <button type="submit" id="btnId" class="btn btn-success">Submit</button>
         </div>
      </form>
      <!-- End floating Labels Form -->
   </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
$("#roles_select").select2({
  theme: "classic"
});
</script>
<script type="text/javascript">
$("#select_user").select2({
  theme: "classic"
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

<script type="text/javascript">
   $(document).ready(function(){
      $("#pinError").hide();
      $("#zipcode").on('keyup', function(){
         var pincode = this.value;

         var zipRegex = /^\d{5}$/;

         if (!zipRegex.test(pincode))
         {
            $("#pinError").show();
         } 

         $("#city_id").html();
         $("#state_id").html();
         $("#country_id").html();
         $.ajax({
            url: '{{ route('pincodes.get_pincode_city_state') }}',
            type: 'POST',
            data: {
               pincode: pincode,
               _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function(result){
               if(result){
                  $("#pinError").hide();
                  $("#city_id").append('<option value="' + result.city
                     .id + '">' + result.city.name + ' - ' + result.city.code + '</option>');
                  $("#state_id").append('<option value="' + result.state
                     .id + '">' + result.state.name + ' - ' + result.state.code + '</option>');
                  $("#country_id").append('<option value="' + result.country
                     .id + '">' + result.country.name + ' - ' + result.country.code + '</option>');
               }else{
                  alert('error');
               }
               
            }
         });
      });
   });
</script>
@endsection