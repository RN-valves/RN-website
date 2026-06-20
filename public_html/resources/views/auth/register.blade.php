@extends('users.master')
@section('seo_tags')
<!-- SEO Meta Tags-->
<meta name="description" content="RN Valves & Faucets - Register"/>
<meta name="keywords" content="RN Valves & Faucets - Register">
<meta property="og:title" content="RN Valves & Faucets - Register">
<meta property="og:image" content="{{url('users/assets/images/login.jpg')}}">
<meta name="og:description" content="RN Valves & Faucets - Register">
<script src="https://www.google.com/recaptcha/api.js?render={{ env('GOOGLE_RECAPTCHA_KEY') }}"></script>
@endsection
@section('content')
<!--Sign Up Page-->
<div class="sign cstm_page_padding">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12 col-lg-12">
            <div class="card">
               <div class="card-body">
                  <div class="sign-in-area form_bxxxx">
                     <p>Join us now to be a part of <b>RN Valves & Faucets</b>® family.</p>
                  {{-- <h2 class="frm_h2">Register</h2> --}}
                  @if (session('status') == 'verification-link-sent')
                       <div class="mb-4 font-medium text-sm alert alert-success">
                           {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                       </div>
                   @endif
                  <form method="post" action="{{ route('register') }}" class="mt-6 space-y-6" id="userRegister">
                     @csrf
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
                     @if ($errors->has('g-recaptcha-response'))
                     <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                     @endif
                     <div class="">
                        <div class="row">
                           <div class="col-sm-12 mt-3">
                              <h5>Personal Details</h5> <hr>
                           </div>
                           <div class="col-sm-6">
                              <div class="form-group">
                                 <x-input-label for="name" :value="__('Name')" />
                                 <x-text-input id="name" name="name" type="text" class="mt-1 block w-full form-control border" :value="old('name')" required autofocus autocomplete="name"  placeholder="Name" />
                                 <x-input-error class="mt-2 text-danger" :messages="$errors->get('name')" />
                              </div>
                           </div>
                           <div class="col-sm-6">
                              <div class="form-group">
                                 <x-input-label for="email" :value="__('Email')" />
                                 <x-text-input id="email" name="email" type="email" class="mt-1 block w-full form-control border" :value="old('email')" required autofocus autocomplete="email"  placeholder="email" />
                                 <x-input-error class="mt-2 text-danger" :messages="$errors->get('email')" />
                              </div>
                           </div>
                           <div class="col-sm-4">
                              <div class="form-group">
                                 <x-input-label for="mobile" :value="__('10 Digits Mobile Number')" />
                                 <x-text-input id="mobile" name="mobile" type="number" class="mt-1 block w-full form-control border" :value="old('mobile')" required autofocus autocomplete="mobile" placeholder="Mobile Number" />
                                 <x-input-error class="mt-2 text-danger" :messages="$errors->get('mobile')" />
                              </div>
                           </div>
                           <div class="col-sm-12 mt-3">
                              <h5>Business Details</h5> <hr>
                           </div>
                           <div class="col-sm-4">
                              <div class="form-group">
                                 <x-input-label for="profession" :value="__('Select Profession')" />
                                 <select class="form-control" name="profession" id="profession">
                                    <option value="">Select</option>
                                    @php
                                    $professions = App\Models\User::professions();
                                    @endphp
                                    @foreach($professions??'' as $profession)
                                    <option value="{{ $profession }}" @selected(old('profession', @$user->profession)==$profession)>{{ $profession }}</option>
                                    @endforeach
                                 </select>
                                 <x-input-error class="mt-2 text-danger" :messages="$errors->get('profession')" />
                              </div>
                           </div>
                           <div class="col-sm-4" id="gst_number">
                              <div class="form-group">
                                 <x-input-label for="gst_number" :value="__('GST Number')" />
                                 <x-text-input id="gst_number_val" name="gst_number" type="text" class="mt-1 block w-full form-control border" :value="old('gst_number')" autofocus autocomplete="gst_number" placeholder="GST Number" />
                                 <x-input-error class="mt-2 text-danger" :messages="$errors->get('gst_number')" />
                              </div>
                           </div>
                           <div class="col-sm-12 mt-3">
                              <h5>Address Details</h5> <hr>
                           </div>
                           <div class="col-sm-4">
                              <div class="form-group">
                                 <x-input-label for="zipcode" :value="__('Pincode')" />
                                 <x-text-input id="zipcode" name="zipcode" type="text" class="mt-1 block w-full form-control border zipcode" :value="old('zipcode')" required autofocus autocomplete="zipcode" placeholder="Pincode"/>
                                 <x-input-error class="mt-2 text-danger" :messages="$errors->get('zipcode')" />
                                 <small class="text-danger pinError" id="pinError">Invalid Pincode or not Deliverable</small>
                              </div>
                           </div>
                           <div class="col-sm-4">
                              <div class="form-group">
                                 <x-input-label for="city" :value="__('City')" />
                                 <x-text-input id="city_id" name="city" type="text" class="mt-1 block w-full form-control border" :value="old('city')" required autofocus autocomplete="city" disabled/>
                              </div>
                           </div>
                           <div class="col-sm-4">
                              <div class="form-group">
                                 <x-input-label for="state" :value="__('State')" />
                                 <x-text-input id="state_id" name="state" type="text" class="mt-1 block w-full form-control border" :value="old('state')" required autofocus autocomplete="state" disabled/>
                              </div>
                           </div>
                           <div class="col-sm-12">
                              <div class="form-group">
                                 <x-input-label for="address" :value="__('Enter Complete Address')" />
                                 <textarea rows="3" style="height: 100px;" id="address" name="address" class="mt-1 block w-full form-control shadow-none border" required autofocus autocomplete="address" placeholder="Complete Address">{{ old('address') }}</textarea>
                                 <x-input-error class="mt-2 text-danger" :messages="$errors->get('address')" />
                              </div>
                           </div>
                           <div class="col-sm-6">
                              <div class="form-group">
                                 <x-input-label for="password" :value="__('Password')" />
                                 <x-text-input id="password" name="password" type="password" class="mt-1 block w-full form-control border" :value="old('password')" required autofocus autocomplete="password"  placeholder="password" />
                                 <x-input-error class="mt-2 text-danger" :messages="$errors->get('password')" />
                              </div>
                           </div>
                           <div class="col-sm-6">
                              <div class="form-group">
                                 <x-input-label for="password_confirmation" :value="__('Password Confirmation')" />
                                 <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full form-control border" :value="old('password_confirmation')" required autofocus autocomplete="password_confirmation" placeholder="Confirm password" />
                                 <x-input-error class="mt-2 text-danger" :messages="$errors->get('password_confirmation')" />
                              </div>
                           </div>
                        </div>
                        <div class="flex items-center gap-4">
                           <button class="btn btn-dark rounded-0 disable_btn">Register</button>
                        </div>
                        <p class="mt-2 pl-2">If Already Existing User <a href="{{ route('login') }}" class="text-primary"><strong>Login</strong></a></p>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!--// Sign Up Page-->
@endsection
@section('scripts')
<script type="text/javascript">
   $('#userRegister').submit(function(event) {
       event.preventDefault();
       grecaptcha.ready(function() {
           grecaptcha.execute("{{ env('GOOGLE_RECAPTCHA_KEY') }}", {action: 'subscribe_newsletter'}).then(function(token) {
               $('#userRegister').prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
               $('#userRegister').unbind('submit').submit();
           });;
       });
   });
</script>
<script type="text/javascript">
$(document).ready(function () {
   $("#userRegister").submit(function (e) {
      $(".disable_btn").attr("disabled", true);
      return true;
   });
});
</script>
<!-- <script type="text/javascript">
   $(document).ready(function(){
      $("#gst_number").hide();
      $("#profession").on('change', function(){
         var profession = this.value;
         if(profession=="Distributor" || profession=="Contractor" || profession=="Dealer" || profession=="Architect"){
            $("#gst_number").show();
         }else{
            $("#gst_number").hide();
         }
      });
   });
</script> -->

<script type="text/javascript">
$(document).ready(function(){
    $("#gst_number").hide();

    $("#profession").on('change', function(){
        var profession = this.value;

        if (profession !== "Select") {
            $("#gst_number").show();
        } else {
            $("#gst_number").hide();
        }
    });
});
</script>

@endsection