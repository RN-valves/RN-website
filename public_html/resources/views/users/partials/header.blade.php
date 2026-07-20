@php
$isProductDetail = request()->routeIs('productList.view');
$isWelcome = request()->routeIs('welcome');
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, viewport-fit=cover">
      <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <link rel="canonical" href="{{url()->full()}}" />
      <meta property="og:url" content="{{url()->full()}}">
      <meta property=twitter:url content="{{url()->full()}}">
      <meta property=og:site_name content="RN Valves & Faucets">
      <meta property=twitter:card content=summary>
      <meta property=twitter:site content="RN Valves & Faucets">
      <meta property=og:site_name content="RN Valves & Faucets">
      <!-- Latest compiled and minified CSS -->
      <meta name="author" content="RN Valves & Faucets">
      <!-- Favicon and Touch Icons-->

      <link rel="apple-touch-icon" sizes="180x180" href="{{url('users/assets/images/logo.png')}}">
      <link rel="icon" type="image/png" sizes="32x32" href="{{ url('users/assets/images/logo.png') }}">
      <link rel="icon" type="image/png" sizes="16x16" href="{{ url('users/assets/images/logo.png') }}">

      {{-- Preconnect to external origins for faster DNS resolution --}}
      <link rel="preconnect" href="https://ajax.googleapis.com" crossorigin>
      <link rel="dns-prefetch" href="https://ajax.googleapis.com">
      <link rel="dns-prefetch" href="https://maxcdn.bootstrapcdn.com">
      <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
      <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
      <link rel="preconnect" href="https://www.googletagmanager.com">
      <link rel="dns-prefetch" href="https://www.googletagmanager.com">
      <link rel="preconnect" href="https://connect.facebook.net">
      <link rel="dns-prefetch" href="https://connect.facebook.net">
      <link rel="preconnect" href="https://rnvalves.media">
      <link rel="dns-prefetch" href="https://rnvalves.media">
      <link rel="preconnect" href="https://www.google.com">
      <link rel="dns-prefetch" href="https://www.google.com">

      @if($isWelcome)
      {{-- Preload hero poster for faster LCP on homepage --}}
      <link rel="preload" as="image" href="https://rnvalves.media/Catalogue/Banner/5.jpg" fetchpriority="high">
      @endif

      {{-- Preload only the primary body font --}}
      <link rel="preload" href="{{ url('users/assets/fonts/NeoSansStd-Regular.woff2') }}" as="font" type="font/woff2" crossorigin>

      {{-- Critical CSS: load synchronously (above-fold styles) --}}
      <link rel="stylesheet" type="text/css" href="{{url('users/assets/css/flaticon.css')}}">
      <link rel="stylesheet" type="text/css" href="{{url('users/assets/css/fontawesome.min.css')}}">
      <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <link rel="stylesheet" type="text/css" href="{{url('users/assets/css/style.css?100')}}">
      <link rel="stylesheet" type="text/css" href="{{url('users/assets/css/responsive.css?12')}}">

      {{-- Non-critical CSS: load asynchronously (below-fold / animation styles) --}}
      <link rel="preload" href="{{url('users/assets/css/animate.css')}}" as="style" onload="this.onload=null;this.rel='stylesheet'">
      <noscript><link rel="stylesheet" href="{{url('users/assets/css/animate.css')}}"></noscript>

      @if($isProductDetail)
      <link rel="preload" href="{{url('users/assets/css/slick.css')}}" as="style" onload="this.onload=null;this.rel='stylesheet'">
      <noscript><link rel="stylesheet" href="{{url('users/assets/css/slick.css')}}"></noscript>

      <link rel="preload" href="{{url('users/asr_zoom/jqzoom.css')}}" as="style" onload="this.onload=null;this.rel='stylesheet'">
      <noscript><link rel="stylesheet" href="{{url('users/asr_zoom/jqzoom.css')}}"></noscript>
      @endif

      <link rel="preload" href="{{ url('users/assets/css/custom.css?111') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
      <noscript><link rel="stylesheet" href="{{ url('users/assets/css/custom.css?111') }}"></noscript>

      <link rel="preload" href="{{ url('admin/assets/css/toastr.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
      <noscript><link rel="stylesheet" href="{{ url('admin/assets/css/toastr.min.css') }}"></noscript>

      {{-- reCAPTCHA: load after page is interactive --}}
      <script>
      window.addEventListener('load', function() {
         setTimeout(function() {
            var s = document.createElement('script');
            s.src = 'https://www.google.com/recaptcha/api.js?render={{ env('GOOGLE_RECAPTCHA_KEY') }}';
            s.async = true;
            s.defer = true;
            document.head.appendChild(s);
         }, 2500);
      });
      </script>

      {{-- Desktop Navbar Visibility Fix --}}
      <style>
         @media (min-width: 992px) {
             .navbar-expand-lg .navbar-collapse {
                 display: flex !important;
                 flex-basis: auto;
                 visibility: visible !important;
                 opacity: 1 !important;
             }
             .navbar-expand-lg .navbar-nav {
                 flex-direction: row;
                 display: flex !important;
             }
             .navbar-area .nav-container .navbar-collapse .navbar-nav {
                 display: flex !important;
             }
             .navbar-area .nav-container .navbar-collapse .navbar-nav > li {
                 color: #181818 !important;
             }
             .navbar-area .nav-container .navbar-collapse .navbar-nav > li > a {
                 color: #181818 !important;
             }
         }
      </style>

      {{-- ajax form submit alert popup  --}}
      <link rel="preload" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
      <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css"></noscript>
      {{-- ajax form submit alert popup  --}}

      
      <!-- preloader area start -->
      <!-- <div class="preloader" id="preloader">
         <div class="preloader-inner">
             <div class="spinner">
                 <div class="dot1"></div>
                 <div class="dot2"></div>
             </div>
         </div>
         </div> -->
      <!-- preloader area end -->
      <!--Search Console-->
      <meta name="google-site-verification" content="tPKmwkwZ-WkpT3KzqghZpgpUY7o6ZBKumLQ6m3zEqyI" />
      <!-- Global site tag (gtag.js) - Google Analytics -->
      <!-- <script defer src="https://www.googletagmanager.com/gtag/js?id=UA-199650608-1"></script> -->
      <!-- Google tag (gtag.js): deferred to avoid blocking render -->
      <script>
      window.addEventListener('load', function() {
         setTimeout(function() {
            var g = document.createElement('script');
            g.async = true;
            g.src = 'https://www.googletagmanager.com/gtag/js?id=G-WHNJBR6EKF';
            document.head.appendChild(g);
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            window.gtag = gtag;
            gtag('js', new Date());
            gtag('config', 'G-WHNJBR6EKF');
         }, 2000);
      });
      </script>
    

      <!-- Meta Pixel Code: deferred so it does not block page rendering -->
      <script>
      window.addEventListener('load', function() {
         setTimeout(function() {
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '7247974241981487');
            fbq('track', 'PageView');
         }, 3000);
      });
      </script>
      <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=7247974241981487&ev=PageView&noscript=1"/></noscript>
      <!-- End Meta Pixel Code -->



      <!-- Google Tag Manager: deferred to avoid blocking render -->
      <script>
      window.addEventListener('load', function() {
         setTimeout(function() {
            (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-PQBC3DT');
         }, 2000);
      });
      </script>
      <!-- End Google Tag Manager -->