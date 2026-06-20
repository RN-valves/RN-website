@extends('users.master')
@section('seo_tags')
<title>Contact Us | For Customers and Dealers | RN Valves & Faucets </title>
<meta name="description" content="RN Valves gives complete bath solutions with products such as bathroom accessories, showers, valves, and sanitaryware. Book your RN Valves product today!"/>
<meta name="keywords" content="Faucets, Sanitaryware, Sensor Faucets, Taps, Valves, Overhead Showers, Bathroom Accessories, Diverter, Shower Panels, Hoses & Connections, Luxury Faucets, Single Lever Basin Mixer">
<meta property="og:title" content="Contact Us | For Customers and Dealers | RN Valves & Faucets ">
<meta property="og:image" content="{{asset('public/images/dealer.jpg')}}">
<meta name="og:description" content="RN Valves gives complete bath solutions with products such as bathroom accessories, showers, valves, and sanitaryware. Book your RN Valves product today!">
<meta property=twitter:title content="Contact Us | For Customers and Dealers | RN Valves & Faucets ">
<meta property=twitter:description content="RN Valves gives complete bath solutions with products such as bathroom accessories, showers, valves, and sanitaryware. Book your RN Valves product today!">
<meta property=twitter:image content="{{asset('public/images/dealer.jpg')}}">
@endsection
@php 
$qr = App\Models\Catalogue::where('id',102)->first();
@endphp
@section('content')
<?php $url= url()->full(); ?>
<!--Page-->
<div class="cstm_page_section" style="background:#f0f4f8;">
   <div class="card">
   <div class="card-body">
   <div class="about_page_content">
      <div class="container-fluid">
         <div class="cntct_top_secn">
            <h1 class="text-center" style="
    font-size: 30px;
    font-weight: 600;
    margin-bottom: 40px;
     ">Contact Us</h1>
            <div class="row txt_agn_cntr">
               <div class="col-lg-5">
                  <div class="head_office">
                     <h5>Head Office</h5>
                     <div class="addrssess">
                        <div class="ttlees">{{ frontPage()->name??'' }}</div>
                        {{ frontPage()->address??'' }}
                     </div>
                     <div class="cll_sctn_nmbr">
                        <a href="mailto:{{ frontPage()->email??'' }}"><i class="icon flaticon-email"></i> {{ frontPage()->email??'' }}</a> <br>
                        <a href="tel:{{ frontPage()->mobile??'' }}">
                        <i class="icon flaticon-phone-call"></i> {{ frontPage()->mobile??'' }} &nbsp;&nbsp;
                        </a>
                        {{-- <a href="tel:011-45788666">
                        <i class="icon flaticon-phone-call"></i> 011-45788666
                        </a><br>
                        <a href="tel:011-45671555">
                        <i class="icon flaticon-phone-call"></i> 011-45671555
                        </a><br> --}}
                     </div>
                     <div class="mt-4">
                     <img src="{{asset($qr->qr_code)}}" alt="Plumber Enquiry" width="130">
                      <p> Scan QR for Plumber Enquiry</p>
                     </div>
                  </div>
               </div>
               <div class="col-lg-7">
                  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14003.724647276968!2d77.33477174685295!3d28.66177976849932!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfae9c5758a57%3A0xd35ecac368edf317!2sSahibabad%20Industrial%20Area%20Site%204%2C%20Sahibabad%2C%20Ghaziabad%2C%20Uttar%20Pradesh!5e0!3m2!1sen!2sin!4v1655725215120!5m2!1sen!2sin" width="100%"  style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
               </div>
            </div>
         </div>
      </div>
      <!--// Container-->
   </div>
   </div>
   </div>
</div>
{{-- <div class="sign cstm_page_padding cntct_bttmm_secn">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-6">
            <div class="sign-in-area form_bxxxx">
               <h2 class="frm_h2">Contact Us</h2>
               <p class="frmtexxt">Write us with your queries, we will be happy to help you!</p>
               <form action="{{ route('contactUs') }}" method="POST" id="contactUSForm" class="contactUSForm">
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
                  @if(Session::has('success'))
                  <div class="alert alert-success">
                     {{Session::get('success')}}
                  </div>
                  @endif
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text">
                        <i class="icon flaticon-man-user"></i>
                        </span>
                     </div>
                     <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Full Name" value="{{old('name')}}">
                     <div class="col-lg-12">
                        <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('name')" />
                     </div>
                  </div>
                  <div class="input-group padding-top-20">
                     <div class="input-group-prepend">
                        <span class="input-group-text">
                        <i class="icon flaticon-man-user"></i>
                        </span>
                     </div>
                     <input type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" id="company_name" placeholder="Full Company Name" value="{{old('company_name')}}">
                     <div class="col-lg-12">
                        <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('company_name')" />
                     </div>
                  </div>
                  <!--// Email-->
                  <div class="input-group padding-top-20">
                     <div class="input-group-prepend">
                        <span class="input-group-text">
                        <i class="icon flaticon-black-back-closed-envelope-shape"></i>
                        </span>
                     </div>
                     <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}" placeholder="Email Address">
                     <div class="col-lg-12">
                        <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('email')" />
                     </div>
                  </div>
                  <div class="input-group padding-top-20">
                     <div class="input-group-prepend">
                        <span class="input-group-text">
                        <i class="icon flaticon-call-answer"></i>
                        </span>
                     </div>
                     <input type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{old('mobile')}}" placeholder="Contact Number">
                     <div class="col-lg-12">
                        <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('mobile')" />
                     </div>
                  </div>
                  <div class="input-group padding-top-20">
                     <div class="input-group-prepend">
                        <span class="input-group-text">
                        <i class="fas fa-handshake"></i>
                        </span>
                     </div>
                     <select class="form-control @error('enquiry_type') is-invalid @enderror" name="enquiry_type">
                        <option value="">Select Profession</option>
                        @foreach($types??'' as $type)
                        <option value="{{ $type }}" @selected(old('enquiry_type'))>{{ $type }}</option>
                        @endforeach
                     </select>
                     <div class="col-lg-12">
                        <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('enquiry_type')" />
                     </div>
                  </div>
                  <div class="input-group padding-top-20">
                     <div class="input-group-prepend">
                        <span class="input-group-text">
                        <i class="icon flaticon-placeholder"></i>
                        </span>
                     </div>
                     <input type="number" name="zipcode" id="zipcode" class="form-control @error('zipcode') is-invalid @enderror" value="{{ old('zipcode') }}" placeholder="zipcode" maxlength="6" autocomplete="off">
                     <div class="col-lg-12">
                        <x-input-error class="mt-2 error_ipt text-danger" id="pinError" :messages="$errors->get('zipcode')" />
                     </div>
                  </div>
                  <div class="input-group padding-top-20">
                     <div class="input-group-prepend">
                        <span class="input-group-text">
                        <i class="icon flaticon-placeholder"></i>
                        </span>
                     </div>
                     <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{old('address')}}" placeholder="address">
                     <div class="col-lg-12">
                        <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('address')" />
                     </div>
                  </div>
                  <!--// Email-->
                  <div class="input-group padding-top-20">
                     <div class="input-group-prepend">
                        <span class="input-group-text" style="align-items: initial; padding-top: 12px;">
                        <i class="icon flaticon-email"></i>
                        </span>
                     </div>
                     <textarea class="form-control @error('purpose') is-invalid @enderror" name="purpose" style="height: 120px;" placeholder="purpose" >
                        {{old('purpose')}}
                     </textarea>
                     <div class="col-lg-12">
                        <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('purpose')" />
                     </div>
                  </div>
                  @if ($errors->has('g-recaptcha-response'))
                  <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                  @endif
                  <div class="main-btn-wrap text-left padding-top-40">
                     <button type="submit" class="btn btn-dark enquiryDisable">Send Enquiry</button>
                  </div>
               </form>
               <!--// Form-->
            </div>
         </div>
         <div class="col-md-6">
            <div class="twnbxxx">
               <div class="contact__thumb"><a href="#">
                  <img src="{{url('users/images/20_years.jpeg')}}" alt="RN - 20 Years">
                  </a>
               </div>
               <div class="contact__thumb">
                  <a href="#"><img src="{{url('users/images/about.jpg')}}" alt="RN Valves & Faucets"></a>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</div> --}}
@endsection
@section('scripts')
<script type="text/javascript">
   $('#contactUSForm').submit(function(event) {
       event.preventDefault();
       grecaptcha.ready(function() {
           grecaptcha.execute("{{ env('GOOGLE_RECAPTCHA_KEY') }}", {action: 'subscribe_newsletter'}).then(function(token) {
               $('#contactUSForm').prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
               $('#contactUSForm').unbind('submit').submit();
           });;
       });
   });
</script>
<script type="text/javascript">
$(document).ready(function () {
   $(".contactUSForm").submit(function (e) {
      $(".enquiryDisable").attr("disabled", true);
      return true;
   });
});
</script>
@endsection