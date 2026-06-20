@extends('users.master')
@section('seo_tags')
<!-- SEO Meta Tags-->
<meta name="description" content="RN Valves & Faucets - Login"/>
<meta name="keywords" content="RN Valves & Faucets - Login">
<meta property="og:title" content="RN Valves & Faucets - Login">
<meta property="og:image" content="{{url('users/assets/images/login.jpg')}}">
<meta name="og:description" content="RN Valves & Faucets - Login">
<script src="https://www.google.com/recaptcha/api.js?render={{ env('GOOGLE_RECAPTCHA_KEY') }}"></script>
@endsection
@section('content')
<!--Sign Up Page-->
<div class="sign cstm_page_padding">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-6">
            <div class="sign-in-area form_bxxxx">
               <h2 class="frm_h2">Existing User</h2>
               <p class="frmtexxt" style="margin-bottom: 15px;">Use your credentials to access your account.</p>
               <button type="button"  data-toggle="modal" data-target="#loginModal" class="btn btn-sm btn-warning">Login With OTP</button>
               <form method="POST" action="{{ route('login') }}" enctype="multipart/form-data" id="LoginForm">
                  @csrf
                  <div class="hr-border">OR</div>
                  <!--// Border-->
                  <x-auth-session-status class="alert alert-danger" :status="session('status')" />

                  <label for="email">Enter Registered Mobile Number</label>
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text">
                        <i class="icon flaticon-call-answer"></i>
                        </span>
                     </div>
                     <x-text-input id="mobile" class="form-control" type="number" name="mobile" :value="old('mobile')" required autofocus autocomplete="off" placeholder="Enter Mobile"/>
                  </div>

                  <x-input-error :messages="$errors->get('mobile')" class="mt-2 text-danger" />
                  <!--// Email-->
                  <label for="password" class="padding-top-15">Password</label>
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text">
                        <i class="icon flaticon-lock"></i>
                        </span>
                     </div>
                     <x-text-input id="password" class="form-control"
                        type="password"
                        name="password"
                        required autocomplete="current-password" placeholder="Enter Password"/>
                  </div>
                  <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                  @if ($errors->has('g-recaptcha-response'))
                  <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                  @endif
                  <!--// Password-->

                  <!-- Remember Me -->
                  <div class="block mt-4">
                     <label for="remember_me" class="inline-flex items-center">
                     <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                     <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                     </label>
                  </div>
                  <!-- Remember Me -->

                  <div class="main-btn-wrap text-left padding-top-10">
                     <input type="submit" class="main-btn black uppercase" value="LOG IN">
                     @if (Route::has('password.request'))
                     <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                     {{ __('Forgot your password?') }}
                     </a>
                     @endif
                  </div>
               </form>
            </div>
            <!--// Sign In Area-->
         </div>
         <div class="col-md-6">
            <div class="sign-register-area" style="background-image: url({{url('users/assets/images/login.jpg')}})">
               <div class="sign-register-area-inner">
                  <h4 class="title">Create Account</h4>
                  <p>Welcome to the world of RN Valves & Faucets. Join us for better service experience.</p>
                  <div class="main-btn-wrap text-center">
                     <a href="{{route('register')}}" class="main-btn uppercase">Register now</a>
                  </div>
               </div>
            </div>
            <!--// Register Area-->
         </div>
      </div>
   </div>
</div>
<!--// Sign Up Page-->
@endsection
@section('scripts')
<!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> -->
<script type="text/javascript">
   $('#LoginForm').submit(function(event) {
       event.preventDefault();
       grecaptcha.ready(function() {
           grecaptcha.execute("{{ env('GOOGLE_RECAPTCHA_KEY') }}", {action: 'subscribe_newsletter'}).then(function(token) {
               $('#LoginForm').prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
               $('#LoginForm').unbind('submit').submit();
           });;
       });
   });
</script>
@endsection