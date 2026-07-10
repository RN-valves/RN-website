@extends('users.master')
@section('seo_tags')
<title>{{ frontPage()->title??'' }}</title>
<!-- SEO Meta Tags-->
<meta name="description" content="{{ frontPage()->description??'' }}"/>
<meta name="keywords" content="{{ frontPage()->keywords??'' }}">
<meta property="og:title" content="{{ frontPage()->title??'' }}">
<meta property="og:image" content="https://rnvalves.media/Catalogue/Banner/5.jpg">
<meta name="og:description" content="{{ frontPage()->title??'' }}">
<meta name="twitter:title" content="{{ frontPage()->title??'' }}">
<meta name="twitter:description" content="{{ frontPage()->description??'' }}">
<meta name="twitter:image" content="https://rnvalves.media/Catalogue/Banner/5.jpg">
<meta name="twitter:card" content="summary_large_image">

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "Organization",
      "@id": "https://rnvalves.com/#organization",
      "name": "RN Valves & Faucets",
      "url": "https://rnvalves.com",
      "logo": "https://rnvalves.com/users/assets/images/logo.png",
      "description": "India's fastest growing modern bathroom solutions company, specializing in Brass & PTMT bath fittings manufacturing with 7000+ products across India.",
      "foundingDate": "2000",
      "founder": {
        "@type": "Person",
        "name": "Rajeev Jain",
        "jobTitle": "Managing Director"
      },
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "B-68, Site-4, Sahibabad Industrial Area",
        "addressLocality": "Ghaziabad",
        "addressRegion": "Uttar Pradesh",
        "postalCode": "201010",
        "addressCountry": "IN"
      },
      "contactPoint": [
        {
          "@type": "ContactPoint",
          "telephone": "+91-1800-1234-0400",
          "contactType": "customer service",
          "areaServed": "IN",
          "availableLanguage": ["Hindi", "English"]
        },
        {
          "@type": "ContactPoint",
          "telephone": "+91-98111-03377",
          "contactType": "sales",
          "areaServed": "IN"
        },
        {
          "@type": "ContactPoint",
          "email": "enquiry@rnvalves.com",
          "contactType": "general enquiry"
        }
      ],
      "sameAs": [
        "https://www.facebook.com/rnvalvesandfaucets/",
        "https://www.instagram.com/rnvalvesandfaucets/",
        "https://www.linkedin.com/company/rn-valves-faucets/",
        "https://x.com/RNValves"
      ],
      "numberOfEmployees": {
        "@type": "QuantitativeValue",
        "value": 200
      },
      "hasOfferCatalog": {
        "@type": "OfferCatalog",
        "name": "RN Valves & Faucets Product Catalogue",
        "url": "https://rnvalves.com/catalogue"
      }
    },
    {
      "@type": "WebSite",
      "@id": "https://rnvalves.com/#website",
      "url": "https://rnvalves.com",
      "name": "RN Valves & Faucets",
      "publisher": {
        "@id": "https://rnvalves.com/#organization"
      },
      "potentialAction": {
        "@type": "SearchAction",
        "target": "https://rnvalves.com/search?q={search_term_string}",
        "query-input": "required name=search_term_string"
      }
    },
    {
      "@type": "WebPage",
      "@id": "https://rnvalves.com/#webpage",
      "url": "https://rnvalves.com",
      "name": "{{ frontPage()->title??'PTMT & CP Tap Manufacturer | Showers & Health Faucets | Bathroom Fittings | RN Valves & Faucets' }}",
      "description": "{{ frontPage()->description??'RN Valves & Faucets – India\'s leading manufacturer of PTMT taps, CP taps, showers, health faucets, expose showers, valves, sensor faucets, and bathroom accessories.' }}",
      "isPartOf": { "@id": "https://rnvalves.com/#website" },
      "about": { "@id": "https://rnvalves.com/#organization" },
      "breadcrumb": {
        "@type": "BreadcrumbList",
        "itemListElement": [
          {
            "@type": "ListItem",
            "position": 1,
            "name": "Home",
            "item": "https://rnvalves.com"
          }
        ]
      }
    },
    {
      "@type": "LocalBusiness",
      "@id": "https://rnvalves.com/#localbusiness",
      "name": "RN Valves & Faucets",
      "image": "https://rnvalves.com/users/assets/images/logo.png",
      "url": "https://rnvalves.com",
      "telephone": "+91-1800-1234-0400",
      "email": "enquiry@rnvalves.com",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "B-68, Site-4, Sahibabad Industrial Area",
        "addressLocality": "Ghaziabad",
        "addressRegion": "Uttar Pradesh",
        "postalCode": "201010",
        "addressCountry": "IN"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 28.6685,
        "longitude": 77.4029
      },
      "openingHoursSpecification": {
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
        "opens": "09:00",
        "closes": "18:00"
      },
      "priceRange": "₹₹",
      "currenciesAccepted": "INR",
      "paymentAccepted": "Cash, Credit Card, Bank Transfer",
      "areaServed": {
        "@type": "Country",
        "name": "India"
      }
    },
    {
      "@type": "Manufacturer",
      "@id": "https://rnvalves.com/#manufacturer",
      "name": "RN Valves & Faucets",
      "brand": {
        "@type": "Brand",
        "name": "RN Valves & Faucets",
        "logo": "https://rnvalves.com/users/assets/images/logo.png",
        "url": "https://rnvalves.com"
      },
      "makesOffer": [
        {
          "@type": "Offer",
          "itemOffered": {
            "@type": "Product",
            "name": "PTMT Taps",
            "description": "High Grade Engineering Polymer taps that are rust-resistant, corrosion-resistant with superior performance and smooth water flow.",
            "category": "Bathroom Fittings",
            "material": "PTMT (Poly Tetra Methylene Terephthalate)",
            "brand": { "@type": "Brand", "name": "RN Valves & Faucets" },
            "url": "https://rnvalves.com"
          }
        },
        {
          "@type": "Offer",
          "itemOffered": {
            "@type": "Product",
            "name": "CP Taps & Faucets",
            "description": "Chrome Plated taps and faucets with luxury finish, corrosion-resistant nickel coating.",
            "category": "Bathroom Fittings",
            "material": "Chrome Plated Brass",
            "brand": { "@type": "Brand", "name": "RN Valves & Faucets" },
            "url": "https://rnvalves.com"
          }
        },
        {
          "@type": "Offer",
          "itemOffered": {
            "@type": "Product",
            "name": "Sensor Faucets",
            "description": "RN Automatic Touchless Sensor Faucets for hygienic, hands-free water flow.",
            "category": "Smart Bathroom Fittings",
            "brand": { "@type": "Brand", "name": "RN Valves & Faucets" },
            "url": "https://rnvalves.com"
          }
        },
        {
          "@type": "Offer",
          "itemOffered": {
            "@type": "Product",
            "name": "Showers & Overhead Showers",
            "description": "Wide range of showers including overhead showers with adjustable water pressure settings.",
            "category": "Bathroom Fittings",
            "brand": { "@type": "Brand", "name": "RN Valves & Faucets" },
            "url": "https://rnvalves.com"
          }
        },
        {
          "@type": "Offer",
          "itemOffered": {
            "@type": "Product",
            "name": "CP Bathroom Accessories",
            "description": "Complete range of bathroom accessories including soap baskets, towel shelves, towel rings, paper holders across collections: Black Beauty, Stone Series, Rose Series, Gold Ceramic, and more.",
            "category": "Bathroom Accessories",
            "brand": { "@type": "Brand", "name": "RN Valves & Faucets" },
            "url": "https://rnvalves.com/cp-accessories"
          }
        },
        {
          "@type": "Offer",
          "itemOffered": {
            "@type": "Product",
            "name": "Valves",
            "description": "Durable plumbing valves for residential and commercial applications.",
            "category": "Plumbing Hardware",
            "brand": { "@type": "Brand", "name": "RN Valves & Faucets" },
            "url": "https://rnvalves.com"
          }
        },
        {
          "@type": "Offer",
          "itemOffered": {
            "@type": "Product",
            "name": "Allied Products",
            "description": "Teflon tape, tap cleaner and other allied plumbing products.",
            "category": "Plumbing Accessories",
            "brand": { "@type": "Brand", "name": "RN Valves & Faucets" },
            "url": "https://rnvalves.com/allied-product"
          }
        }
      ]
    },
    {
      "@type": "FAQPage",
      "url": "https://rnvalves.com",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "What products does RN Valves & Faucets manufacture?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "RN Valves & Faucets manufactures Brass & PTMT bath fittings including PTMT taps, CP taps, health faucets, showers, expose showers, sensor faucets, valves, CP and PTMT bathroom accessories, and allied products. They offer 7000+ products."
          }
        },
        {
          "@type": "Question",
          "name": "Where is RN Valves & Faucets located?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "RN Valves & Faucets is located at B-68, Site-4, Sahibabad Industrial Area, Ghaziabad, Uttar Pradesh – 201010, India."
          }
        },
        {
          "@type": "Question",
          "name": "How can I become a dealer for RN Valves & Faucets?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "You can become an RN Valves & Faucets dealer by visiting https://rnvalves.com/contact-us or calling their toll-free number 1800-1234-0400. They have 4800+ distributors and dealers across India."
          }
        },
        {
          "@type": "Question",
          "name": "Are RN Valves & Faucets products ISO certified?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes, RN Valves & Faucets follows the ISO 9000 Quality Management System across design, research, development, and manufacturing."
          }
        }
      ]
    },
    {
      "@type": "BreadcrumbList",
      "@id": "https://rnvalves.com/#breadcrumbs",
      "itemListElement": [
        { "@type": "ListItem", "position": 1, "name": "Home", "item": "https://rnvalves.com" },
        { "@type": "ListItem", "position": 2, "name": "About Us", "item": "https://rnvalves.com/about-us" },
        { "@type": "ListItem", "position": 3, "name": "CP Accessories", "item": "https://rnvalves.com/cp-accessories" },
        { "@type": "ListItem", "position": 4, "name": "Allied Products", "item": "https://rnvalves.com/allied-product" },
        { "@type": "ListItem", "position": 5, "name": "Health & Hygiene", "item": "https://rnvalves.com/health-hygiene" },
        { "@type": "ListItem", "position": 6, "name": "Catalogue", "item": "https://rnvalves.com/catalogue" },
        { "@type": "ListItem", "position": 7, "name": "Contact Us", "item": "https://rnvalves.com/contact-us" }
      ]
    }
  ]
}
</script>
{{-- <script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="51b58d93-34ff-4faa-999c-e1d11fdc3b4f";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script> --}}
@endsection
@section('content')
@include('users.partials.slider')
<?php $url= url()->full(); ?>
<!--Our Service Section start-->
<section class="padding-bottom-40">
   <!--Container-->
   <style>
      html, body {
         font-family: 'Neo Sans', 'Neo Sans Std', Arial, sans-serif !important;
         background-color: #f4f7f6;
         color: #1a1a1a;
         overflow-x: hidden !important;
         max-width: 100% !important;
      }
      .row { margin-right: 0 !important; margin-left: 0 !important; }
      .container-fluid { padding-right: 15px !important; padding-left: 15px !important; }
      /* === LUXURY CARD GRID === */
      .card-container {
         display: grid;
         grid-template-columns: repeat(3, 1fr);
         gap: 32px;
         max-width: 1700px; /* Increased from 1400px to use more free space */
         margin: 0 auto;
         padding: 20px 40px 80px 40px;
      }
      @media (max-width: 1200px) { .card-container { grid-template-columns: repeat(2, 1fr); padding: 20px; } }
      @media (max-width: 640px)  { .card-container { grid-template-columns: 1fr; gap: 24px; padding: 16px; } }

      /* === CARD BASE === */
      .card {
         position: relative;
         border-radius: 20px;
         overflow: hidden;
         cursor: pointer;
         background: #111;
         aspect-ratio: 3 / 2;
         box-shadow: 0 8px 32px rgba(0,0,0,0.12);
         transition: transform 400ms ease, box-shadow 400ms ease;
         display: block;
         text-decoration: none !important;
      }
      .card:hover {
         transform: scale(1.03);
         box-shadow: 0 24px 60px rgba(0,0,0,0.22);
      }

      /* === CARD IMAGE === */
      .card-img {
         position: absolute;
         inset: 0;
         width: 100%;
         height: 100%;
         object-fit: cover;
         object-position: center;
         transition: transform 400ms ease, filter 400ms ease;
         filter: brightness(0.88);
         display: block;
      }
      .card:hover .card-img {
         transform: scale(1.07);
         filter: brightness(0.45);
      }

      /* === DARK GRADIENT OVERLAY === */
      .card-overlay {
         position: absolute;
         inset: 0;
         background: linear-gradient(
            to top,
            rgba(0,0,0,0.95) 0%,
            rgba(0,0,0,0.50) 45%,
            rgba(0,0,0,0.05) 100%
         );
         opacity: 0.8;
         transition: opacity 400ms ease;
      }
      .card:hover .card-overlay { opacity: 1; }

      /* === BOTTOM LABEL (always visible) === */
      .card-label {
         position: absolute;
         bottom: 0; left: 0; right: 0;
         padding: 20px 20px 18px;
         display: flex;
         flex-direction: column;
         align-items: center;
         gap: 0;
      }
      .card-name {
         font-size: 1rem;
         font-weight: 700;
         color: #ffffff;
         text-transform: uppercase;
         letter-spacing: 2.5px;
         text-align: center;
         text-shadow: 0 2px 12px rgba(0,0,0,0.6);
         transition: transform 400ms ease;
         line-height: 1.2;
      }
      .card:hover .card-name { transform: translateY(-6px); }

      /* === HOVER CONTENT (hidden by default) === */
      .card-hover-content {
         opacity: 0;
         transform: translateY(14px);
         transition: opacity 400ms ease, transform 400ms ease;
         width: 100%;
         text-align: center;
      }
      .card:hover .card-hover-content {
         opacity: 1;
         transform: translateY(0);
         transition-delay: 60ms;
      }
      .card-divider {
         width: 32px;
         height: 1px;
         background: rgba(255,255,255,0.4);
         margin: 8px auto 10px;
      }
      .card-subcat-list {
         list-style: none;
         padding: 0;
         margin: 0 0 12px;
      }
      .card-subcat-list li {
         font-size: 0.75rem;
         color: rgba(255,255,255,0.75);
         letter-spacing: 1px;
         margin: 4px 0;
         text-transform: uppercase;
      }
      .card-cta {
         display: inline-block;
         padding: 7px 22px;
         border: 1px solid rgba(255,255,255,0.65);
         border-radius: 40px;
         color: #fff;
         font-size: 0.72rem;
         font-weight: 600;
         letter-spacing: 1.5px;
         text-transform: uppercase;
         text-decoration: none;
         transition: background 300ms ease, border-color 300ms ease;
      }
      .card-cta:hover { background: #fff; color: #111 !important; border-color: #fff; }

      /* === SHARED BUTTON (glass-banner section) === */
      .shop-now {
         display: inline-flex;
         align-items: center;
         justify-content: center;
         padding: 14px 28px;
         background: #1a1a1a;
         color: white;
         text-decoration: none;
         border-radius: 40px;
         font-weight: 600;
         letter-spacing: 1.5px;
         text-transform: uppercase;
         font-size: 0.85rem;
         transition: all 0.3s ease;
         position: relative;
         overflow: hidden;
         z-index: 2;
      }
      .shop-now::after {
         content: '';
         position: absolute;
         inset: 0;
         background: linear-gradient(135deg, #003366, #00a0e3);
         opacity: 0;
         transition: opacity 0.3s ease;
         z-index: -1;
      }
      .shop-now:hover { color: #fff; transform: translateY(-2px); box-shadow: 0 10px 20px rgba(0,51,102,0.2); }
      .shop-now:hover::after { opacity: 1; }

      /* Text Animations */
      @keyframes fadeInUp {
         from {
            opacity: 0;
            transform: translateY(30px);
         }
         to {
            opacity: 1;
            transform: translateY(0);
         }
      }
      @keyframes gradientShine {
         0% { background-position: 0% 50%; }
         50% { background-position: 100% 50%; }
         100% { background-position: 0% 50%; }
      }

      /* Typographical Sections */
      .premium-hero-text h1 {
         font-weight: 300;
         color: #1a1a1a;
         font-size: 3rem;
         letter-spacing: -1px;
         line-height: 1.2;
         opacity: 0;
         animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
         animation-delay: 0.1s;
      }
      .premium-hero-text h1 strong {
         font-weight: 700;
         background: linear-gradient(135deg, #003366, #00a0e3, #003366);
         background-size: 200% auto;
         -webkit-background-clip: text;
         -webkit-text-fill-color: transparent;
         animation: gradientShine 4s linear infinite;
      }
      .premium-hero-text h2 {
         opacity: 0;
         animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
         animation-delay: 0.3s;
      }
      .premium-hero-text p {
         color: #666666;
         font-size: 1.2rem;
         line-height: 1.8;
         max-width: 800px;
         margin: 20px auto;
         font-weight: 400;
         opacity: 0;
         animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
         animation-delay: 0.5s;
      }

      /* Glass Info Banners */
      .glass-banner {
         background: rgba(255, 255, 255, 0.6);
         backdrop-filter: blur(20px);
         -webkit-backdrop-filter: blur(20px);
         border: 1px solid rgba(255,255,255,0.8);
         border-radius: 30px;
         padding: 60px;
         margin: 80px auto;
         max-width: 1400px;
         box-shadow: 0 20px 50px -20px rgba(0,0,0,0.05);
      }
      
      .popup-overlay {
         position: fixed;
         top: 0;
         left: 0;
         width: 100%;
         height: 100%;
         background: rgba(15, 23, 42, 0.8);
         backdrop-filter: blur(5px);
         display: flex;
         justify-content: center;
         align-items: center;
         visibility: hidden;
         opacity: 0;
         transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
         z-index: 9999;
      }
      .popup-content {
         background: #fff;
         padding: 2px;
         border-radius: 20px;
         text-align: center;
         width: 40%;
         box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
         position: relative;
         transform: scale(0.9) translateY(20px);
         transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      }
      .popup-overlay.active {
         visibility: visible;
         opacity: 1;
      }
      .popup-overlay.active .popup-content {
         transform: scale(1) translateY(0);
      }
      .close-btn {
         position: absolute;
         top: -15px;
         right: -15px;
         background: #ef4444;
         color: white;
         border: none;
         width: 36px;
         height: 36px;
         cursor: pointer;
         border-radius: 50%;
         font-size: 16px;
         font-weight: bold;
         box-shadow: 0 4px 6px rgba(0,0,0,0.1);
         transition: all 0.2s ease;
         display: flex;
         align-items: center;
         justify-content: center;
      }
      .close-btn:hover {
         background: #dc2626;
         transform: scale(1.1);
      }
      @media (max-width: 1024px) {
         .popup-content { width: 90%; }
         .close-btn { top: -10px; right: -10px; }
         .glass-banner { padding: 30px; margin: 40px 20px; border-radius: 20px; }
         .premium-hero-text h1 { font-size: 2.2rem; }
      }
      @media (max-width: 767px) {
         .premium-hero-text h1 { font-size: 1.5rem !important; line-height: 1.3; }
         .premium-hero-text h2 { font-size: 1.1rem !important; }
         .premium-hero-text p { font-size: 0.95rem !important; line-height: 1.6; margin: 15px auto !important; padding: 0 10px; }
      }
   </style>

    <!-- <div class="popup-overlay" id="popup">
        <div class="popup-content">
            <button class="close-btn" onclick="closePopup()">✖</button>
            <img src="https://rnvalves.media/rn-exhibition.png" alt="RN Exhibition" loading="lazy">
        </div>
    </div> -->
<!--Our Service Section start-->
<section class="padding-bottom-40" style="padding-top: 80px; position: relative; background: transparent;">
   <!-- Premium Background Gradient -->
   <div style="position: absolute; top: 0; left: 0; right: 0; height: 100%; z-index: -1; background: linear-gradient(180deg, #ffffff 0%, #f4f7f6 100%);"></div>
   <div style="position: absolute; top: -100px; left: -100px; width: 500px; height: 500px; background: radial-gradient(circle, rgba(0,160,227,0.05) 0%, rgba(255,255,255,0) 70%); border-radius: 50%; z-index: -1;"></div>
   <div style="position: absolute; top: 200px; right: -150px; width: 600px; height: 600px; background: radial-gradient(circle, rgba(0,51,102,0.03) 0%, rgba(255,255,255,0) 70%); border-radius: 50%; z-index: -1;"></div>

   <!--Container-->
   <div class="container-fluid">
      <!--Row-->
      <div class="row">
         <div class="col-lg-10 m-auto">
            <!-- Section Title Wrap -->
            <div class="premium-hero-text text-center" style="margin-bottom: 60px;">
               <h1>PTMT Faucets | CP Faucets | Shower | Health Faucets | CP Accessories | PTMT Accessories | Expose Shower | <strong>High Grade Engineering Polymer Taps</strong></h1>

               {{-- Typewriter line --}}
               <h2 style="font-size: 1.5rem; color: #555; font-weight: 300; margin-top: 18px; letter-spacing: 1px;">
                  Engineered for&nbsp;<span id="typewriter-word" style="
                     color: #003366;
                     font-weight: 700;
                     border-right: 3px solid #003366;
                     padding-right: 2px;
                     display: inline-block;
                     min-width: 2px;
                     letter-spacing: 1px;
                     animation: cursorBlink 0.75s step-end infinite;
                  "></span>
               </h2>
               <style>
               @keyframes cursorBlink {
                 0%, 100% { border-color: #003366; }
                 50% { border-color: transparent; }
               }
               </style>

               <p>From High Grade PTMT & CP Faucets to premium Showers, Health Faucets, and Expose Showers, RN Valves deals with value for money products. Our core vision is to grow our brand in every Indian household and make our complete range of elegant accessories available for every class of our society.</p>

                {{-- Typewriter script moved to bottom scripts section --}}
            </div>
         </div>
      </div>
      <!--// Row-->

      <!--loop-->
      @php
         $categories = ActiveCategories();
         $priorityIndices = [7,8,9,10,6];

         $priorityRows = [];
         $remainingRows = [];
         
         foreach ($categories as $index => $row) {
             if (in_array($index, $priorityIndices)) {
                 $priorityRows[] = $row;
             } else {
                 $remainingRows[] = $row;
             }
         }

         $sortedCategories = array_merge($priorityRows, $remainingRows);
      @endphp
      
      <div class="card-container">
         @foreach($sortedCategories ?? '' as $ACategory)
            {{-- Luxury Card --}}
            <a href="{{ route('productList', $ACategory->url_key) }}" class="card">
               <img class="card-img" src="{{ url($ACategory->image??'') }}" alt="{{ $ACategory->name??'' }}" loading="lazy">
               <div class="card-overlay"></div>
               <div class="card-label">
                  <div class="card-name">{{ $ACategory->name ?? '' }}</div>
                  <div class="card-hover-content">
                     <div class="card-divider"></div>
                     <ul class="card-subcat-list">
                        @foreach(App\Models\Category::getCatSubcategories($ACategory->id)->take(4)??'' as $subCat)
                           <li>{{ $subCat->name??'' }}</li>
                        @endforeach
                     </ul>
                     <span class="card-cta">Explore Range</span>
                  </div>
               </div>
            </a>
         @endforeach
      </div>
      <!--loop end-->

   </div>
   <!--// Container-->
</section>
<!--// Our Service Section end-->
<div class="cstm_page_section" style="background: #ffffff !important; padding-bottom: 0px;">
   <!--Product Details Tab-->
   <div class="product-details-tab">
      @include('users.partials.new_arriwal')
   </div>
</div>
<!-- Premium Info Banner -->
<div class="glass-banner ptmt-3D-section">
   <div class="row align-items-center">
      <div class="img_block col-lg-6 mb-4 mb-lg-0">
          <div style="border-radius: 30px; overflow: hidden; box-shadow: 0 30px 60px -15px rgba(0,0,0,0.15); display: block; background: #fdfdfd; height: 500px; position: relative;" class="model-container">
            <!-- UI UX 360 Indicator -->
            <div style="position: absolute; bottom: 25px; left: 50%; transform: translateX(-50%); background: rgba(255,255,255,0.9); backdrop-filter: blur(10px); padding: 10px 24px; border-radius: 40px; border: 1px solid rgba(0,0,0,0.04); font-weight: 600; font-size: 0.95rem; color: #1a1a1a; display: flex; align-items: center; gap: 10px; box-shadow: 0 8px 20px rgba(0,0,0,0.08); pointer-events: none; z-index: 10;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                Drag to explore 360°
            </div>
            
            <!-- 3D Model Viewer using Google's model-viewer -->
            <script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.4.0/model-viewer.min.js"></script>
            <model-viewer 
                src="{{ url('models/tap.glb') }}" 
                alt="3D model of PTMT Faucet" 
                auto-rotate 
                camera-controls 
                interaction-prompt="hover"
                shadow-intensity="1"
                environment-image="neutral"
                exposure="1"
                style="width: 100%; height: 100%; border-radius: 30px; outline: none;">
                
                <!-- Fallback if JS/WebGL fails or model is missing -->
                <div class="fallback-img" slot="poster" style="width: 100%; height: 100%; background-image: url('{{ url('users/images/faucets.png') }}'); background-size: cover; background-position: center; border-radius: 30px;"></div>
                
                <div slot="progress-bar"></div>
            </model-viewer>
          </div>
      </div>
      <div class="col-lg-6" style="padding: 0 5%;">
         <h2 style="font-weight: 300; color: #1a1a1a; margin-bottom: 30px; font-size: 2.8rem; line-height: 1.1; letter-spacing: -1px;">
            <strong style="color: #003366; font-weight: 700;">Upgrade your space</strong><br/>with CP Chrome Plated Brass Taps
         </h2>
         <p style="color: #666; font-size: 1.15rem; line-height: 1.8; margin-bottom: 40px; font-weight: 400;">CP | Chrome Plated Brass Taps by RN Valves & Faucets bring your bathroom to a new level of luxury and durability. Crafted from high-quality brass with a premium chrome finish, these faucets are designed to deliver long-lasting performance, corrosion resistance, and a mirror-like shine. Built with precision engineering and modern aesthetics, they offer the perfect balance of strength, elegance, and reliability for contemporary bathrooms.</p>
         <div class="d-flex align-items-center gap-3" style="gap: 15px;">
             <a class="shop-now" href="https://rnvalves.com/ptmt-faucets" style="margin: 0;">Discover Excellence</a>
             <span style="font-size: 0.9rem; color: #888; display: inline-flex; align-items: center; gap: 8px;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                Interact with the 3D Model
            </span>
         </div>
      </div>
   </div>
</div>

<!-- About Us Premium Section -->
<section class="padding-bottom-10 pt-5 text-center" style="background: white; padding: 100px 20px;">
   <div class="container" style="max-width: 1000px;">
      <h3 style="font-weight: 700; color: #1a1a1a; font-size: 2.5rem; letter-spacing: -1px; margin-bottom: 30px;">Enter the dream like experience of bathing</h3>
      <p style="color: #666; font-size: 1.25rem; line-height: 1.9; font-weight: 300; margin-bottom: 40px;">
         RN valves came into existence in 2000 in order to provide an Indian alternative for basic to luxury bathroom usage of Indian consumers. With the increasing demand for products and services across India, the company established a workplace in New Delhi with over 200 employees and more than 1000 dealers and distributors across India.<br><br>
         With an experienced development and research team, the products are designed in consideration with the modern-day usage and lifestyle. We constantly work into establishing new and innovative designs that help provide a whole new bathing experience.
      </p>
      <a href="{{ route('aboutUs') }}" class="shop-now" style="background: transparent; color: #1a1a1a; border: 2px solid #1a1a1a; margin: 0; box-shadow: none;">Learn Our Story</a>
   </div>
</section>
{{-- @include('users.partials.enquiry_form') --}}
<div class="cstm_page_section website-cart addressbxx" style="margin-top: 40px;">
   <!--Product Details Tab-->
   <div class="container-fluid">
      @include('users.partials.latest_blogs')
   </div>
</div>
@endsection
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
   var words      = ['Premium Showers.', 'Health Faucets.', 'Durable PTMT.', 'Elegant CP Accessories.', 'Innovation.', 'Reliability.'];
   var el         = document.getElementById('typewriter-word');
   if (!el) return;
   var wi = 0, ci = 0, deleting = false;
   var SPEED_TYPE = 90, SPEED_DEL = 55, PAUSE = 1700;
   function tick() {
      var word = words[wi];
      ci = deleting ? ci - 1 : ci + 1;
      el.textContent = word.slice(0, ci);
      var delay = deleting ? SPEED_DEL : SPEED_TYPE;
      if (!deleting && ci === word.length)  { delay = PAUSE; deleting = true; }
      else if (deleting && ci === 0)        { deleting = false; wi = (wi + 1) % words.length; delay = 380; }
      setTimeout(tick, delay);
   }
   setTimeout(tick, 800);
});
</script>
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
<script type="text/javascript">
   $(document).ready(function(){
      $("#get_name").on('keyup', function(){
         var name = this.value;
         $("#company_name").val(name);
      });
   });

</script>
<!-- <script>
        window.onload = function() {
            setTimeout(() => {
                document.getElementById("popup").classList.add("active");
            }, 1000);
        };

        function closePopup() {
            document.getElementById("popup").classList.remove("active");
        }
    </script> -->
@endsection