@extends('users.master')
@section('seo_tags')
<title>Direct Payment Method - RN Valves</title>
<!-- SEO Meta Tags-->
<meta name="description" content="Direct Payment Method - RN Valves"/>
<meta name="keywords" content="Direct Payment Method - RN Valves">
<meta property=og:type content=Payment>
<meta property="og:title" content="Direct Payment Method - RN Valves">
<meta property="og:image" content="{{url('public/images/logo.png')}}">
<meta name="og:description" content="Direct Payment Method - RN Valves">
<meta property=og:image:url content="{{url('public/images/logo.png')}}">
<meta property=twitter:title content="Direct Payment Method - RN Valves">
<meta property=twitter:description content="Direct Payment Method - RN Valves">
<meta property=twitter:image content="{{url('public/images/logo.png')}}">
<script src="https://www.google.com/recaptcha/api.js?render={{ env('GOOGLE_RECAPTCHA_KEY') }}"></script>
@endsection
@section('content')
<!--Page-->
<div class="cstm_page_section website-cart addressbxx" style="background: #fafafa !important;">
   <div class="container-fluid">
      <div style="max-width:880px; margin: 0px auto;">
         <h3 class="text-center paagettle mt-5">Payment Module</h3>
         <div class="row">
            <div class="col-lg-6">
               <div class="card">
                  <div class="card-body">
                     <form method="POST" action="{{ url('direct-payment-razopay') }}" id="direct_payment">
                        @csrf
                        <div class="addresss_form">
                           <div class="frmhhdng" style="margin-top:0px;">Online Payment</div>
                           <p>Payment Debit Card/Credit Card/Internet Banking (2% Extra Charge)</p>
                           @if ($errors->has('g-recaptcha-response'))
                           <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                           @endif
                           <div class="form-group">
                              <label>Name <span class="text-danger">*</span></label>
                              <input class="form-control border @error('name') is-invalid @enderror" placeholder="Enter Name" type="text" name="name" value="{{old('name')}}" required>
                              <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('name')" />
                           </div>
                           <div class="form-group">
                              <label>Email id <span class="text-danger">*</span></label>
                              <input class="form-control border @error('email') is-invalid @enderror" placeholder="Enter Email id" type="email" value="{{old('email')}}" name="email" required>
                              <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('email')" />
                           </div>
                           <div class="form-group">
                              <label>Mobile Number <span class="text-danger">*</span></label>
                              <input class="form-control border @error('mobile') is-invalid @enderror" placeholder="Enter Contact No." type="text" value="{{old('mobile')}}" name="mobile" required>
                              <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('mobile')" />
                           </div>
                           <div class="form-group">
                              <x-input-label for="zipcode" :value="__('Pincode')" />
                              <x-text-input name="zipcode" type="text" class="mt-1 block w-full form-control border zipcode" :value="old('zipcode', @$userAddress->zipcode)" required autofocus autocomplete="zipcode" placeholder="Pincode" />
                              <x-input-error class="mt-2 text-danger" :messages="$errors->get('zipcode')" />
                              <small class="text-danger pinError" id="pinError">Invalid Pincode or not Deliverable</small>
                           </div>
                           <div class="row">
                              <div class="col-sm-6">
                                 <div class="form-group">
                                    <x-input-label for="city" :value="__('City (opt)')" />
                                    <x-text-input id="city_id" name="city" type="text" class="mt-1 block w-full form-control border" :value="old('city', @$userAddress->city)" required autofocus autocomplete="city" disabled />
                                 </div>
                              </div>
                              <div class="col-sm-6">
                                 <div class="form-group">
                                    <x-input-label for="state" :value="__('State (opt)')" />
                                    <x-text-input id="state_id" name="state" type="text" class="mt-1 block w-full form-control border" :value="old('state', @$userAddress->state)" required autofocus autocomplete="state" disabled />
                                 </div>
                              </div>
                           </div>
                           <div class="form-group">
                              <label>Amount <span class="text-danger">*</span></label>
                              <input class="form-control border @error('amount') is-invalid @enderror" placeholder="Enter Amount" type="number" value="{{old('amount')}}" name="amount" min="100">
                              <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('amount')" />
                           </div>
                           <div class="mt-3">
                              <button type="submit" class="btn btn-dark">Proceed to Pay</button>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
   
            </div>
            <div class="col-lg-6">
               <div class="card">
                  <div class="card-body">
                     <div class="frmhhdng" style="margin-top:0px;">UPI Payment</div>
                     <img src="{{url('users/images/idfc.png')}}" style="max-width: 100%;">
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--end cart section-->
   </div>
</div>
<!--//  Page-->
@endsection
@section('scripts')
<script type="text/javascript">
   $('#direct_payment').submit(function(event) {
       event.preventDefault();
       grecaptcha.ready(function() {
           grecaptcha.execute("{{ env('GOOGLE_RECAPTCHA_KEY') }}", {action: 'subscribe_newsletter'}).then(function(token) {
               $('#direct_payment').prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
               $('#direct_payment').unbind('submit').submit();
           });;
       });
   });
</script>
@endsection