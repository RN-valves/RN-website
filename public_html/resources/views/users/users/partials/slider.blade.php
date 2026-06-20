@php
$sliders = App\Models\Slider::where('status','Active')->limit(3)->get();
@endphp
<!--Full Width Sider Start-->
<div class="full-width-slider">
   <div id="wrapper">
      <style>    
         #mobileVideo {
             display: none!important;
         }
         @media screen and (max-width: 768px) {
             #myVideo {
                 display: none!important;
             }
             #mobileVideo {
                 display: block!important;
             } 
             .overlay{
               display: none!important;
             }      
         }
      </style>
      <div class="slider-wrapper theme-default">
         <!---video start ---->
         <div class="rn_home_video">
            <!---replace this code : vjo7o7-znMg  for voice video custom css need to change for it---->
            <video autoplay loop muted playsinline class="vjo7o7-znMg" muted id="myVideo" width="100%">
               <source src="https://rnvalves.media/Catalogue/bannerVideo.webm" type="video/webm" />
            </video>
            <video autoplay loop muted preload="none" playsinline id="mobileVideo">
               <source src="https://rnvalves.media/Catalogue/bannerVideo.mp4" type="video/mp4">
            </video>
            
            <!-- <video autoplay loop muted playsinline id="myVideo" width="100%">
                <source src="https://rnvalves.media/Catalogue/bannerVideo.webm" type="video/webm" />
                Your browser does not support the video tag.
            </video> -->
      
            <!---replace this code : vjo7o7-znMg  for voice video custom css need to change for it end---->

            {{-- youtube video start section --}}
         <!-- <iframe src="https://www.youtube.com/embed/EV7CsqilJzo?autoplay=1&amp;mute=1&amp;controls=0&amp;loop=1&amp;playlist=EV7CsqilJzo&amp;showinfo=0&amp;rel=0" width="560" height="315" frameborder="0" allowfullscreen="allowfullscreen"></iframe> -->
            {{-- youtube video end section --}}

            {{-- commmon section for video start --}}
            <div class="overlay">
               <div class="overlay-col">
                  {{-- <img src="{{ url('icons/rn_white_logo.png') }}" alt="Logo" loading="lazy" title="RN Valves & Faucets" /> --}}
                  <h2>PTMT|High Grade Engineering Polymer Taps: Durable Elegance for Every Flow – RN Valves & Faucets</h2>
                  <a class="explore-btn" href="{{url('/ptmt-taps-or-faucets')}}">Explore Now</a>
               </div>
            </div>
            {{-- commmon section for video end --}}

         </div>
         <!---for voice video custom css need to change for it---->
         {{-- <a id="audio-control" class="muted vbtn">Unmute</a> --}}
         <!---for voice video custom css need to change for it end---->
         <!---video end ---->

         {{-- 
         <div id="slider" class="nivoSlider"> 
            @foreach($sliders??'' as $slider)
            <img src="{{ url($slider->image??'') }}" data-thumb="{{ url($slider->image??'') }}" loading="lazy" alt="{{$slider['title']}}" data-transition="" width="100%" />
            @endforeach
         </div>
         --}}
         
      </div>
   </div>
   <!--//Slider Area End-->
</div>
