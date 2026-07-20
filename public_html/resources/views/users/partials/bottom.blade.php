<?php 
   $url = url()->full(); 
   $types = App\Models\Enquiry::enquiryTypes();
?>

@if (request()->routeIs('register') || request()->routeIs('cart')  || request()->routeIs('CartCheckout') || request()->routeIs('login') || request()->routeIs('direct_payment'))
@else
@include('users.partials.landing_form')
@endif

<section class="catsectn">
   <div class="container">
      <div class="row">
         <div class="col-md-3 col-sm-6 col-6">
            <div class="ctainformn">
               <img src="{{asset('icons/rn1.png')}}" class="ctaicon" alt="RN Valves & Faucets" title="RN Valves & Faucets" loading="lazy" width="64" height="64">                               
               <a href="{{route('register')}}" class="ctatexts">Dealer Locator </a>
               <p>Become an RN Valves & Faucets Dealer – Where Quality and Reliability Flow Together.</p>
            </div>
         </div>
         <div class="col-md-3 col-sm-6 col-6">
            <div class="ctainformn nobdr">
               <img src="{{asset('icons/rn4.png')}}" class="ctaicon" alt="RN Valves & Faucets" title="RN Valves & Faucets" loading="lazy" width="64" height="64">                               
               <a href="javascript:void();" class="ctatexts actn_enquiry">Talk to an Expert</a>
               <p>Need Expert Advice? Talk to an RN Valves & Faucets Specialist Today!</p>
            </div>
         </div>
         <div class="col-md-3 col-sm-6 col-6">
            <div class="ctainformn">
               <img src="{{asset('icons/rn3.png')}}" class="ctaicon" alt="RN Valves & Faucets" title="RN Valves & Faucets" loading="lazy" width="64" height="64">                               
               <a href="{{route('catalogue')}}" class="ctatexts">Download Catalogue</a>
               <p>Explore Our Products – Download the RN Valves & Faucets Catalogue Today!</p>
            </div>
         </div>
         <div class="col-md-3 col-sm-6 col-6">
            <div class="ctainformn nobdr">
               <img src="{{asset('icons/rn2.png')}}" class="ctaicon" alt="RN Valves & Faucets" title="RN Valves & Faucets" loading="lazy" width="64" height="64">                               
               <a href="{{route('contactUs')}}" class="ctatexts">Customer Service Request</a>
               <p>Your Satisfaction, Our Priority – Contact RN Valves & Faucets Customer Service Today!</p>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- footer area start -->
<div class="block" id="carmela247"></div>
<footer class="footer-area style-02" style="background:#0F0F0F !important">
   <div class="footer-top ">
      <div class="container-fluid">
         <div class="row padding-top-60 padding-bottom-45">
            <div class="col-lg-3 col-md-6">
               <div class="footer-widget widget widget_nav_menu">
                  <h5 class="widget-title">Quick Links</h5>
                  <ul>
                     <li><a href="{{ route('policy', ['url_key'=>"privacy"]) }}">Privacy Policy</a></li>
                     <li><a href="{{ route('policy', ['url_key'=>"return"]) }}">Return & Refund Policy</a></li>
                     <li><a href="{{ route('policy', ['url_key'=>"terms-conditions"]) }}">Terms & Conditions</a></li>
                     <li><a href="{{ route('policy', ['url_key'=>"certificates"]) }}">Our Certification</a></li>
                     <li><a href="{{ route('ourCsr') }}">Our CSR</a></li>
                     <li><a href="{{ route('register') }}">Become our Dealer</a></li>
                  </ul>
               </div>
               <div class="banner__header__follow_us" style="display:none;">
                  <div class="banner__header__icon">
                     <ul>
                        <li><a class="icon" href="{{ frontPage()->fb_link??'' }}"
                           target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                        <li>
                           <a class="icon p-1" href="{{ frontPage()->twitter_link??'' }}"
                              target="_blank">
                              <!-- <i class="fa-brands fa-square-x-twitter"></i> -->
                              <svg class="mb-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                 <!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                 <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
                              </svg>
                           </a>
                        </li>
                        <li><a class="icon" href="{{ frontPage()->insta_link??'' }}"
                           target="_blank"><i class="fab fa-instagram"></i></a></li>
                        <li><a class="icon"
                           href="{{ frontPage()->linkedin_link??'' }}"
                           target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                        <li><a class="icon"
                           href="{{ frontPage()->youtube_link??'' }}"
                           target="_blank"><i class="fab fa-youtube"></i></a></li>
                        <li><a class="icon"
                           href="{{ frontPage()->pinterest_link??'' }}"
                           target="_blank"><i class="fab fa-pinterest"></i></a></li>
                     </ul>
                  </div>
               </div>
               <div style="font-size: 13px; color: #ffffff; margin-top:30px;margin-bottom:10px;">Payment Accept :</div>
               <a href="{{ route('direct_payment') }}">
               <img src="{{url('users/images/payments.png')}}" alt="RN Valves & Faucets" title="RN Valves & Faucets" style="height: 23px; margin-bottom: 30px;" loading="lazy" width="200" height="23">
               </a>
            </div>
            <div class="col-lg-3 col-md-6 hide_767">
               <div class="footer-widget widget widget_nav_menu">
                  <h5 class="widget-title">Products</h5>
                  <ul>
                     @foreach(ActiveCategories()??'' as $ACategory)
                     <li><a href="{{ route('productList', $ACategory) }}">{{ $ACategory->name??'' }}</a></li>
                     @endforeach
                  </ul>
               </div>
            </div>
            <div class="col-lg-3 col-md-6 hide_767">
               <div class="footer-widget widget widget_nav_menu">
                  <h5 class="widget-title">Our Company</h5>
                  <ul>
                     <li><a href="{{ route('aboutUs') }}">About RN Valves</a></li>
                     <li><a href="{{ route('career') }}">Career with us</a></li>
                     <li><a href="{{route('blogs', ['url_key'=>'blogs'])}}">Our Blogs</a></li>
                     <li><a href="{{route('contactUs')}}">Contact Us</a></li>
                     {{-- <li><a href="{{ route('sitemap') }}">Sitemap</a></li> --}}
                     <li><a href="{{ route('catalogue') }}">Our Catalogue</a></li>
                  </ul>
               </div>
            </div>
            <div class="col-lg-3 col-md-6">
               <div class="footer-widget widget">
                  <h5 class="widget-title hide_767">Contact us</h5>
                  <div class="contact-area">
                     <ul>
                        <li><i class="icon flaticon-pin"></i><a href="#">{{ frontPage()->address??'' }}</a></li>
                        <li><i class="icon flaticon-email"></i><a href="mailto:{{ frontPage()->email??'' }}">{{ frontPage()->email??'' }}</a></li>
                        <li><i class="icon flaticon-call-answer"></i><a href="tel:{{ frontPage()->mobile??'' }}">{{ frontPage()->mobile??'' }}</a></li>
                        <li><i class="icon flaticon-global"></i><a href="{{ url('/') }}">www.rnvalves.com</a></li>
                     </ul>
                  </div>
                  <div style="margin-top: 30px;">
                     <div style="font-size: 13px; color: #ffffff; margin-bottom:15px;">Available on :</div>
                     <a target="_blank" href="https://play.google.com/store/apps/details?id=com.basiq.rnvalves&hl=en-IN">
                     <img src="{{ url('users/images/google_play.png') }}" alt="RN Valves & Faucets" title="RN Valves & Faucets" class="app_iconnn" loading="lazy" width="120" height="36">
                     </a>
                     <a target="_blank" href="https://apps.apple.com/us/app/rn-valves/id6480268880">
                     <img src="{{ url('users/images/apple_store.png') }}" alt="RN Valves & Faucets" title="RN Valves & Faucets" class="app_iconnn" loading="lazy" width="120" height="36">
                     </a>
                  </div>
                  <img src="{{asset('icons/rn_white_logo_blue.png')}}" alt="RN Valves & Faucets" title="RN Valves & Faucets" class="ftrbglogo" loading="lazy" width="120" height="40">
               </div>
            </div>
         </div>
      </div>
      <div class="asrfootersocial">
         <div class="banner__header__follow_us">
            <div class="banner__header__icon">
               <ul>
                  <li><a class="icon" href="{{ frontPage()->fb_link??'' }}" target="_blank" style="background-color:#118FF3; color:white!important"><i class="fab fa-facebook-f"></i></a></li>
                  <li>
                     <a class="icon p-1" href="{{ frontPage()->twitter_link??'' }}" target="_blank">

                        <svg class="mb-1" style="height: 18px; width:18px; position: relative; top: -2px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                           <!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                           <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"></path>
                        </svg>
                     </a>
                  </li>
                  <li><a class="icon" href="{{ frontPage()->insta_link??'' }}" target="_blank" style="background-color:#FF0C4C; color:white!important"><i class="fab fa-instagram"></i></a></li>
                  <li><a class="icon" href="{{ frontPage()->linkedin_link??'' }}" target="_blank" style="background-color:#2567B3; color:white!important"><i class="fab fa-linkedin-in" ></i></a></li>
                  <li><a class="icon" href="{{ frontPage()->youtube_link??'' }}" target="_blank" style="color:#FE0000!important"><i class="fab fa-youtube"></i></a></li>
                  <li><a class="icon" href="{{ frontPage()->pinterest_link??'' }}" target="_blank" style="color:#E70025!important" ><i class="fab fa-pinterest"></i></a></li>
               </ul>
            </div>
         </div>
      </div>
   </div>
   <div class="copyright-area">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12">
               <div class="copyright-area-inner">
                  &copy; Copyrights {{ frontPage()->name??'' }}. All Rights Reserved.
               </div>
            </div>
         </div>
      </div>
   </div>
</footer>
<style>
      .modal-content {
    padding: 20px;
    border-radius: 10px;
}

.modal-header {
    text-align: center;
    justify-content: center;
}

.modal-title {
    text-align: center;
    width: 100%;
}

.modal-body {
    padding: 20px;
    text-align: center;
}

.modal-body form {
    padding: 10px;
}

.btn-block {
    width: 100%;
}

.modal-footer {
    justify-content: center;
    text-align: center;
}
.phone-icon {
    position: fixed;
    bottom: 21px;
    left: 100px;
    z-index: 1000;
    border-radius: 50%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
}

.phone-icon:hover {
    transform: scale(1.1);
}

.phone-icon img {
    width: 50px;
    height: 50px;
    animation: zoomInOut 1.5s infinite;
}
@keyframes zoomInOut {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.2);
    }
    100% {
        transform: scale(1);
    }
}
@media (max-width: 768px) {
    .phone-icon {
        display: none;
    }
}
   </style>
   <a href="https://api.whatsapp.com/send?phone=91{{frontPage()->whatsapp??''}}&amp;text=Hello, I am a visitor from your website and would like to chat with you." target="_blank" class="call_fixed_btn"><i class="fab fa-whatsapp"></i></a>
<a href="tel:{{frontPage()->mobile??''}}" class="phone-icon">
    <img src="{{ asset('icons/phone-icon.png') }}" alt="Phone Icon" title="RN Valves & Faucets" loading="lazy" width="50" height="50">
</a>
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
         <h5 class="modal-title">Login</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
      </div>
      <div class="modal-body">
        <div class="d-flex flex-column text-center">
          <form id="mobileForm">
            <div class="form-group">
               <input type="text" class="form-control" oninput="validateNumber(this)" maxlength="10" id="mobileNumber" name="mobile_number" placeholder="Enter Mobile Number" required>
               <small class="text-danger mobile-error" style="display:none">Please enter correct mobile number</small>
            </div>
            <button type="button" class="btn btn-info btn-block btn-round" id="sendOtpBtn">Login</button>
          </form>
          <form id="otpForm" style="display: none;">
            <div class="form-group">
            <input type="text" class="form-control" oninput="validateNumber(this)" maxlength="4" id="otp" name="otp" placeholder="Enter OTP" required>
            <small class="text-danger otp-error" style="display:none">Please enter 4 digits OTP</small>
            </div>
            <button type="button" class="btn btn-info btn-block btn-round" id="verifyOtpBtn">Verify OTP</button>
          </form>
               <div class="d-flex justify-content-center social-buttons">
          </div>
        </div>
      </div>
       <div class="modal-footer d-flex justify-content-center">
         <p class="mt-2 resendOtp-count" style="display: none;">
            Didn't receive the OTP? 
            <button type="button" class="btn btn-link p-0" id="resendOtpBtn" disabled>Resend OTP (<span id="countdown">30</span>s)</button>
         </p>
      </div>

    </div>
    
  </div>
</div>
<style>

</style>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PQBC3DT"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->



{{-- jQuery UI and Carmela deferred so they don't block rendering --}}
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js" defer></script>
<script src="https://www.carmela24.com/asreffect.js" defer></script>
<script>document.addEventListener('DOMContentLoaded', function(){ if(typeof jQuery !== 'undefined' && jQuery('#carmela247').length){ jQuery('#carmela247').asreffect({color: '#0F0F0F',canvasHeight: 15}); } });</script>
<style>
   #carmela247{overflow: visible !important;}
   .fa.fa-twitter{
   font-family:sans-serif;
   }
   .fa.fa-twitter::before{
   content:"𝕏";
   font-size:1.2em;
   }
   .modal-backdrop.show {
   opacity: 0 !important;
   }
   .review_form {
   border-radius: 0px !important;
   max-width: 389px !important;
   margin-left: 0;
   bottom: 0;
   position: absolute;
   bottom: 50px;
   left: 0;
   }
   /* .close {
   position: absolute;
   right: 0;
   background: #00a0e3 !important;
   opacity: 1;
   width: 30px;
   height: 30px;
   color: #fff;
   z-index: 999;
   cursor: pointer !important;
   } */
</style>
<!-- footer area end -->
<!-- back to top area start -->
<div class="back-to-top">
   <span class="back-top">  </span>
</div>
