@extends('users.master')
@section('seo_tags')
<title>Privacy Policy - RN Valves & Faucets</title>
<meta name="description" content="This Privacy Policy explains how we collect and use information that you give via our websites or when you register for our services. Please review this Policy before you give us any data."/>
<meta name="keywords" content="RN Valves Privacy Policy, RN Valves Policy, RN Valves Disclaimer, Privacy Policy">
<meta property=og:type content="Privacy Policy">
<meta property="og:title" content="Privacy Policy - RN Valves & Faucets">
<meta property="og:image" content="{{url('users/images/assured.png')}}">
<meta name="og:description" content="This Privacy Policy explains how we collect and use information that you give via our websites or when you register for our services. Please review this Policy before you give us any data.">
<meta property=og:image:url content="{{url('users/images/assured.png')}}">
<meta property=twitter:title content="Privacy Policy - RN Valves & Faucets">
<meta property=twitter:description content="This Privacy Policy explains how we collect and use information that you give via our websites or when you register for our services. Please review this Policy before you give us any data.">
<meta property=twitter:image content="{{url('users/images/assured.png')}}">
@endsection
@section('ccs_links')
<link rel="stylesheet" href="{{url('users/assets/css/custom.css')}}" type="text/css">
@endsection
@section('content')
<!--Page-->
<style>
   .image>img{
      width: 100px!important;
      height: 82px!important;
   }
</style>
<div class="cstm_page_section website-cart addressbxx">
   <div class="container-fluid">
      <div class="brdcrm_menu" style="margin-top: 5px !important;"><a href="{{route('welcome')}}"><i class="fas fa-chevron-left"></i>Back to Home </a></div>
      <div class="row">
         @include('users.websites.policies.menu')
         <div class="col-lg-8">
            <div class="blog-details-wrap">
               <!--Blog Details item-->
               <div class="blog-details-items">
                  <h1 class="acc_page_title">{{@$data->title}}</h1>
                  <div class="blog_content_areaaa">
                     <!-- <p>
                        We, at RN Valves, assure you that your information is safe with us. We are committed to your privacy to the fullest.
                     </p>
                     <div>
                        <b>We may require this personal information for further processing:</b>
                     </div>
                     <li>Name, contact information, telephone number and email address</li>
                     <li>Business address, telephone number and email address</li>
                     <li>other information related to service and product delivery</li>
                     <li>Transaction information for payments and billings</li>
                     <li>Information necessary to provide services or products</li>
                     <br>
                     <div><b>All the data collected through online sources are:</b></div>
                     <li>Data from website <a href="www.rnvalves.com">www.rnvalves.com</a></li>
                     <li>Data from social media such as <a href="{{ frontPage()->fb_link??'' }}">Facebook</a> , <a href="{{ frontPage()->insta_link??'' }}">Instagram</a>, <a href="{{ frontPage()->linkedin_link??'' }}">linkedin</a>, etc. </li>
                     <li>Data from messaging apps such as whatsapp </li>
                     <br>
                     <p>
                        All the information gathered is kept confidential and can only be used by the officials of our company in order to provide better products and services.<br>
                        The distribution or disclosure of any information is done according to these privacy policies and is governed by and operated in accordance with the laws of India.<br>
                        For any future details regarding privacy  policy or any other information, mail us at <a href="mailto:enquiry@rnvalves.com">enquiry@rnvalves.com</a>
                     </p>
                     <h4>Quality Policy</h4>
                     <hr>
                     <p>Quality is the center of the enterprise management, we execute the full
                        implementation of ISO90000 Quality management system from design research,
                        development to manufacturing. The whole process of tracking and inspection
                        ensures that each process is always in a controlled state, to provide a strong
                        guarantee of the excellent quality.<<br><br>
                        Inspection is an important vehicle to control and verify the quality of the products.
                        We rely on advanced technology with excellent equipment support to analyze the
                        characteristics of the control points to achieve the purpose of scientific control of
                        quality.<br><br>
                        <img  src="{{asset('users/images/assured.png')}}" style="float: right; max-width: 120px; margin-left:10px;" alt="Assured RN"> 
                        We ensure quality inspections at the early stages too. All the raw materials,
                        spare parts, and accessories are well checked and all the unnecessary units
                        which failed to pass the quality test get eliminated immediately.
                     </p> -->
                     {!! @$data->description !!}
                  </div>
               </div>
            </div>
            <!-- <div class="blog_right_side">
               <img src="">
            </div>
            <div class="blog-details-wrap">
           
               <div class="blog-details-items">
                  <div class="blog_content_areaaa">
                     <p>
                        This privacy notice for RN Valves & Faucets We describes how and why we might collect, store, use, and/or share ("process") your information when you use our product services such as when you:
                        Visit our website at  Website , or any website of ours that links to this privacy notice
                        Download and use our mobile application (RN Valves & Faucets), or any other application of ours that links to this privacy notice
                        Engage with us in other related ways, including any sales, marketing, or events
                        Questions or concerns? Reading this privacy notice will help you understand your privacy rights and choices. If you do not agree with our policies and practices, please do not use our Services. If you still have any questions or concerns, please contact us at info@rnvalves.com.
                     </p>
                     <h5>SUMMARY OF KEY POINTS</h5>
                     <p> 
                        This summary provides key points from our privacy notice, but you can find out more details about any of these topics by clicking the link following each key point or by using our table of contents below to find the section you are looking for.
                        What personal information do we process? When you visit, use, or navigate our Services, we may process personal information depending on how you interact with us and the Services, the choices you make, and the products and features you use. 
                        Do we process any sensitive personal information? We may process sensitive personal information when necessary with your consent or as otherwise permitted by applicable law. 
                        How do we process your information? We process your information to provide, improve, and administer our Services, communicate with you, for security and fraud prevention, and to comply with law. We may also process your information for other purposes with your consent. We process your information only when we have a valid legal reason to do so.
                     </p>
                     <p>In what situations and with which parties do we share personal information? We may share information in specific situations and with specific third parties. 
                        What are your rights? Depending on where you are located geographically, the applicable privacy law may mean you have certain rights regarding your personal information. 
                        How do you exercise your rights? The easiest way to exercise your rights is by submitting a data subject access request, or by contacting us. We will consider and act upon any request in accordance with applicable data protection laws.
                        Want to learn more about what we do with any information we collect? Review the privacy notice in full.
                     </p>
                     <h5>TABLE OF CONTENTS</h5>
                     <ol>
                        <li><a href="">What Information Do We Collect?</a></li>
                        <li><a href="">How Do We Process Your Information?</a></li>
                        <li><a href="">When And With Whom Do We Share Your Personal Information?</a></li>
                        <li><a href="">How Long Do We Keep Your Information?</a></li>
                        <li><a href="">Do We Collect Information From Minors?</a></li>
                        <li><a href="">What Are Your Privacy Rights?</a></li>
                        <li><a href="">Controls For Do-Not-Track Features</a></li>
                        <li><a href="">Do We Make Updates To This Notice?</a></li>
                        <li><a href="">How Can You Contact Us About This Notice?</a></li>
                     </ol>
                     <h5>1. WHAT INFORMATION DO WE COLLECT?</h5>
                     <div><strong>Personal information you disclose to us</strong></div>
                     <p><i><b>In Short:</b> We collect personal information that you provide to us.</i></p>
                     <p>We collect personal information that you voluntarily provide to us when you register on the Services, express an interest in obtaining information about us or our products and Services, when you participate in activities on the Services, or otherwise when you contact us.</p>
                     <p><strong>Personal Information Provided by You. The personal information that we collect depends on the context of your interactions with us and the Services, the choices you make, and the products and features you use. The personal information we collect may include the following:</strong></p>
                     <ul>
                        <li>Names</li>
                        <li>Phone numbers</li>
                        <li>Email addresses</li>
                        <li>Contact preferences</li>
                        <li>Contact or authentication data</li>
                     </ul>
                     <p>Sensitive Information. When necessary, with your consent or as otherwise permitted by applicable law, we process the following categories of sensitive information:</p>
                     <p>Application Data. If you use our application(s), we also may collect the following information if you choose to provide us with access or permission:
                        Geolocation Information. We may request access or permission to track location-based information from your mobile device, either continuously or while you are using our mobile application(s), to provide certain location-based services. If you wish to change our access or permissions, you may do so in your device's settings.
                        Mobile Device Data. We automatically collect device information (such as your mobile device ID, model, and manufacturer), operating system, version information and system configuration information, hardware model Internet service provider and/or mobile carrier, and Internet Protocol (IP) address (or proxy server). If you are using our application(s), we may also collect information about the phone network associated with your mobile device, your mobile device’s operating system or platform, the type of mobile device you use, your mobile device’s unique device ID, and information about the features of our application(s) you accessed.<br>
                        Push Notifications. We may request to send you push notifications regarding your account or certain features of the application(s). If you wish to opt out from receiving these types of communications, you may turn them off in your device's settings. <br>
                        This information is primarily needed to maintain the security and operation of our application(s), for troubleshooting, and for our internal analytics and reporting purposes.<br>
                        All personal information that you provide to us must be true, complete, and accurate, and you must notify us of any changes to such personal information.
                     </p>
                     <h5>Information automatically collected</h5>
                     <p><i>In Short: Some information — such as your device characteristics — is collected automatically when you visit our Services.</i></p>
                     <p>We automatically collect certain information when you visit, use, or navigate the Services. This information does not reveal your specific identity (like your name or contact information) but may include device and usage information, such as your device characteristics, operating system, language preferences, referring URLs, device name, country, location, information about how and when you use our Services, and other technical information. This information is primarily needed to maintain the security and operation of our Services, and for our internal analytics and reporting purposes.</p>
                     <h5>Background Location Tracking</h5>
                     <p>We are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy explains how we collect, use, disclose, and protect your location data when you use our mobile application RN Valves. By using the App, you consent to the practices described in this Privacy Policy.
                        The App may collect and process your location data, including but not limited to GPS coordinates. We may collect this information when the App is running in the background to provide you with location-based services, improve our App's functionality, and for analytics purposes.
                     </p>
                     <h5>How We Use Your Location Information</h5>
                     <p><strong>We use your location data for the following purposes:</strong></p>
                     <ul>
                        <li>We use your location data to calculate the distance and working hours, after start attendance we track your activities like distributor check-ins and your visits and order collection.</li>
                        <li>Legal Compliance: We may disclose your location data to comply with legal obligations, such as responding to subpoenas or government requests.</li>
                        <li>Business Transfers: In the event of a merger, acquisition, or sale of all or part of our assets, your location data may be transferred as part of the transaction. We will ensure that your data remains protected and subject to the terms of this Privacy Policy.</li>
                        <li>
                           <strong>Your Choices</strong><br>
                           1 Location Settings: You can control the App's access to your location information through your device settings. You may choose to disable location tracking, restrict it to only when the App is in use, or grant full background location access.
                        </li>
                     </ul>
                     <h5>2. HOW DO WE PROCESS YOUR INFORMATION?</h5>
                     <p><i>In Short: We process your information to provide, improve, and administer our Services, communicate with you, for security and fraud prevention, and to comply with law. We may also process your information for other purposes with your consent.</i></p>
                     <h5>3. WHEN AND WITH WHOM DO WE SHARE YOUR PERSONAL INFORMATION?</h5>
                     <p><i>In Short: We may share information in specific situations described in this section and/or with the following third parties. </i></p>
                     <p>We may need to share your personal information <br>
                        When we use Google Maps Platform APIs. We may share your information with certain Google Maps Platform APIs (e.g., Google Maps API, Places API).
                     </p>
                     <h5>4. HOW LONG DO WE KEEP YOUR INFORMATION?</h5>
                     <p><i>In Short: We keep your information for as long as necessary to fulfill the purposes outlined in this privacy notice unless otherwise required by law.</i></p>
                     <p>We will only keep your personal information for as long as it is necessary for the purposes set out in this privacy notice, unless a longer retention period is required or permitted by law (such as tax, accounting, or other legal requirements). No purpose in this notice will require us keeping your personal information for longer than the period of time in which users have an account with us.</p>
                     <p>
                        When we have no ongoing legitimate business need to process your personal information, we will either delete or anonymize such information, or, if this is not possible (for example, because your personal information has been stored in backup archives), then we will securely store your personal information and isolate it from any further processing until deletion is possible.
                     </p>
                     <h5>5. DO WE COLLECT INFORMATION FROM MINORS?</h5>
                     <p><i>In Short: We do not knowingly collect data from or market to children under 18 years of age.</i></p>
                     <p>We do not knowingly solicit data from or market to children under 18 years of age. By using the Services, you represent that you are at least 18 or that you are the parent or guardian of such a minor and consent to such minor dependent’s use of the Services. If we learn that personal information from users less than 18 years of age has been collected, we will deactivate the account and take reasonable measures to promptly delete such data from our records. If you become aware of any data we may have collected from children under age 18, please contact us at info@rnvalves.com</p>
                     <h5>6. WHAT ARE YOUR PRIVACY RIGHTS?</h5>
                     <p><i>In Short:  You may review, change, or terminate your account at any time.</i></p>
                     <p>
                        Withdrawing your consent: If we are relying on your consent to process your personal information, which may be express and/or implied consent depending on the applicable law, you have the right to withdraw your consent at any time. You can withdraw your consent at any time by contacting us by using the contact details provided in the section "HOW CAN YOU CONTACT US ABOUT THIS NOTICE?" below.
                        <br>
                        However, please note that this will not affect the lawfulness of the processing before its withdrawal nor, when applicable law allows, will it affect the processing of your personal information conducted in reliance on lawful processing grounds other than consent.
                     </p>
                     <p><strong>Account Information</strong></p>
                     <p>If you would at any time like to review or change the information in your account or terminate your account, you can:</p>
                     <ul>
                        <li>Log in to your account settings and update your user account.</li>
                        <li>Contact us using the contact information provided.</li>
                     </ul>
                     <p>Upon your request to terminate your account, we will deactivate or delete your account and information from our active databases. However, we may retain some information in our files to prevent fraud, troubleshoot problems, assist with any investigations, enforce our legal terms and/or comply with applicable legal requirements. 
                        If you have questions or comments about your privacy rights, you may email us at info@rnvalves.com.
                     </p>
                     <h5>7. CONTROLS FOR DO-NOT-TRACK FEATURES</h5>
                     <p>Most web browsers and some mobile operating systems and mobile applications include a Do-Not-Track ("DNT") feature or setting you can activate to signal your privacy preference not to have data about your online browsing activities monitored and collected. At this stage no uniform technology standard for recognizing and implementing DNT signals has been finalized. As such, we do not currently respond to DNT browser signals or any other mechanism that automatically communicates your choice not to be tracked online. If a standard for online tracking is adopted that we must follow in the future, we will inform you about that practice in a revised version of this privacy notice.</p>
                     <h5>8. DO WE MAKE UPDATES TO THIS NOTICE?</h5>
                     <p><i>In Short: Yes, we will update this notice as necessary to stay compliant with relevant laws.</i></p>
                     <p> 
                        We may update this privacy notice from time to time. The updated version will be indicated by an updated "Revised" date and the updated version will be effective as soon as it is accessible. If we make material changes to this privacy notice, we may notify you either by prominently posting a notice of such changes or by directly sending you a notification. We encourage you to review this privacy notice frequently to be informed of how we are protecting your information.
                     </p>
                     <h5>9. HOW CAN YOU CONTACT US ABOUT THIS NOTICE?</h5>
                     <p>If you have questions or comments about this notice, you may email us at <a href="mailto:info@rnvalves.com">info@rnvalves.com</a> or contact us by post at:</p>
                     <p>RN Valves & Faucets <br>
                        B-68 SITE-4 SAHIBABAD Ghaziabad <br>
                        Uttar Pradesh 201010<br>
                        India
                     </p>
                  </div>
               </div>
            </div> -->
         </div>
      </div>
   </div>
</div>
@endsection