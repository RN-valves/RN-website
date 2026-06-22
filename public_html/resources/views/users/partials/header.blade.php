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

      <link rel="apple-touch-icon" sizes="180x180" href="{{url('users/images/android-chrome-192x192.png')}}">
      <link rel="icon" type="image/png" sizes="32x32" href="{{ url('users/images/favicon-32x32.png') }}">
      <link rel="icon" type="image/png" sizes="16x16" href="{{ url('users/images/favicon.ico') }}">
      <link rel="stylesheet" type="text/css" href="{{url('users/assets/css/flaticon.css')}}">
      <link rel="stylesheet" type="text/css" href="{{url('users/assets/css/fontawesome.min.css')}}">
      <link rel="stylesheet" type="text/css" href="{{url('users/assets/css/animate.css')}}">
      <link rel="stylesheet" href="{{url('users/assets/css/slick.css')}}">
      <link rel="stylesheet" type="text/css" href="{{url('users/assets/css/responsive.css?12')}}">
      <link rel="stylesheet" href="{{url('users/asr_zoom/jqzoom.css')}}" type="text/css">
      <link rel="stylesheet" type="text/css" href="{{url('users/rnsldr/default.css')}}">
      <link rel="stylesheet" type="text/css" href="{{url('users/rnsldr/asr-slider.css')}}">
      <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <link rel="stylesheet" type="text/css"  href="{{url('users/assets/css/style.css?100')}}">
      <link rel="stylesheet" type="text/css" href="{{ url('admin/assets/css/toastr.min.css') }}">
      @vite(['resources/css/app.css', 'resources/js/app.js'])
      <script src="https://www.google.com/recaptcha/api.js?render={{ env('GOOGLE_RECAPTCHA_KEY') }}"></script>

      {{-- Desktop Navbar Visibility Fix --}}
      <style>
         @media (min-width: 992px) {
             .navbar-expand-lg .navbar-collapse {
                 display: flex !important;
                 flex-basis: auto;
             }
             .navbar-expand-lg .navbar-nav {
                 flex-direction: row;
             }
             .navbar-area .nav-container .navbar-collapse .navbar-nav {
                 display: flex;
             }
         }
      </style>

      {{-- ajax form submit alert popup  --}}
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
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
      <!-- Google tag (gtag.js) -->
      <script async src="https://www.googletagmanager.com/gtag/js?id=G-WHNJBR6EKF"></script>
      <script>
         window.dataLayer = window.dataLayer || [];
         function gtag(){dataLayer.push(arguments);}
         gtag('js', new Date());
         
         gtag('config', 'G-WHNJBR6EKF');
      </script>
    

      <!-- Meta Pixel Code -->
      <script>
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
      </script>
      <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=7247974241981487&ev=PageView&noscript=1"/></noscript>
      <!-- End Meta Pixel Code -->



      <!-- Google Tag Manager -->
      <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
      new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
      j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
      'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
      })(window,document,'script','dataLayer','GTM-PQBC3DT');</script>
      <!-- End Google Tag Manager -->