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
         /* Prevent CLS: reserve space for video container */
         .rn_home_video {
             position: relative;
             width: 100%;
             height: 0;
             padding-top: 56.25%;
             background: #000;
             overflow: hidden;
         }
         .rn_home_video video {
             position: absolute;
             top: 0;
             left: 0;
             width: 100%;
             height: 100%;
             object-fit: cover;
         }
      </style>
      <div class="slider-wrapper theme-default">
         <!---video start ---->
         <div class="rn_home_video">
            
            {{-- Desktop video: poster + lazy load to improve LCP --}}
            <video muted playsinline class="vjo7o7-znMg" id="myVideo" width="1920" height="1080" preload="none" poster="https://rnvalves.media/Catalogue/Banner/5.jpg">
               <source data-src="https://rnvalves.media/Catalogue/bannerVideo1.mp4" type="video/mp4" />
            </video>
            
            {{-- Mobile video: poster + lazy load --}}
            <video muted preload="none" playsinline id="mobileVideo" width="1080" height="1920" poster="https://rnvalves.media/Catalogue/Banner/5.jpg">
               <source id="mobileVideoSrc" data-src="" type="video/mp4">
            </video>

            {{-- Slider Controls (Next / Prev) --}}
            <div class="video-slider-controls">
               <button id="prevBtn" class="slider-btn">&#10094;</button>
               <button id="nextBtn" class="slider-btn">&#10095;</button>
            </div>

            {{-- Video Progress Dots --}}
            <div class="video-dots-container">
               <div class="video-dot active" data-index="0" id="dot0"><div class="dot-progress"></div></div>
               <div class="video-dot" data-index="1" id="dot1"><div class="dot-progress"></div></div>
            </div>

            {{-- Sound Toggle Button --}}
            <button id="videoAudioToggle" class="video-audio-btn" title="Toggle Sound">
               <i id="videoAudioIcon" class="fas fa-volume-mute"></i>
            </button>


            <style>
               .video-slider-controls {
                  position: absolute;
                  top: 50%;
                  width: 100%;
                  display: flex;
                  justify-content: space-between;
                  transform: translateY(-50%);
                  padding: 0 10px;
                  opacity: 0.8;
                  z-index: 10;
                  pointer-events: none;
               }
               .slider-btn {
                  pointer-events: auto;
                  background-color: rgba(255, 255, 255, 0.4);
                  color: #000;
                  border: none;
                  border-radius: 50%;
                  width: 50px;
                  height: 50px;
                  font-size: 24px;
                  font-weight: bold;
                  cursor: pointer;
                  display: flex;
                  align-items: center;
                  justify-content: center;
                  transition: all 0.3s ease;
               }
               .slider-btn:hover {
                  background-color: #00afef;
                  color: #fff;
                  transform: scale(1.1);
               }
               .video-dots-container {
                  position: absolute;
                  bottom: 30px;
                  left: 50%;
                  transform: translateX(-50%);
                  display: flex;
                  gap: 15px;
                  z-index: 10;
               }
               .video-dot {
                  width: 60px;
                  height: 5px;
                  background: rgba(255, 255, 255, 0.3);
                  border-radius: 3px;
                  cursor: pointer;
                  overflow: hidden;
               }
               .dot-progress {
                  width: 0%;
                  height: 100%;
                  background: #00afef; /* Theme Blue */
                  transition: width 0.1s linear;
               }

               #bannerHeading, #bannerLink {
                  transition: opacity 0.3s ease;
               }
               .video-audio-btn {
                  position: absolute;
                  bottom: 30px;
                  right: 30px;
                  z-index: 100;
                  background: rgba(0, 0, 0, 0.5);
                  color: #fff;
                  border: 1px solid rgba(255, 255, 255, 0.3);
                  border-radius: 50%;
                  width: 45px;
                  height: 45px;
                  display: flex;
                  align-items: center;
                  justify-content: center;
                  cursor: pointer;
                  transition: all 0.3s ease;
                  backdrop-filter: blur(5px);
               }
               .video-audio-btn:hover {
                  background: #00afef;
                  transform: scale(1.1);
               }
               @media screen and (max-width: 768px) {
                  .video-audio-btn {
                     bottom: 80px; /* Above dots on mobile */
                     right: 20px;
                  }
               }
            </style>

            {{-- commmon section for video start --}}
            <div class="overlay" style="pointer-events: none;">
               <div class="overlay-col" style="pointer-events: auto;">
                  <h2 id="bannerHeading">PTMT Faucets | CP Faucets | Shower | Health Faucets | CP Accessories | PTMT Accessories | Expose Shower | High Grade Engineering Polymer Taps: Durable Elegance for Every Flow – RN Valves & Faucets</h2>
                  <a id="bannerLink" class="explore-btn" href="{{url('/ptmt-taps-or-faucets')}}">Explore Now</a>
               </div>
            </div>
            {{-- commmon section for video end --}}

            <script>
               document.addEventListener("DOMContentLoaded", function() {
                  const myVideo = document.getElementById("myVideo");
                  const mobileVideo = document.getElementById("mobileVideo");
                  
                  const desktopVideos = [
                     "https://rnvalves.media/Catalogue/bannerVideo1.mp4",
                     "https://rnvalves.media/Catalogue/bannerVideo2.mp4",
                     "https://rnvalves.media/Catalogue/bannerVideo3.mp4",
                  ];
                  const mobileVideos = [
                     "https://rnvalves.media/Catalogue/bannerVideo.mp4",
                     "https://rnvalves.media/Catalogue/bannerVideo2.mp4",
                     "https://rnvalves.media/Catalogue/bannerVideo3.mp4",
                  ];

                  function setVideoSource(videoEl, url) {
                     const source = videoEl.querySelector("source");
                     if (!source) return;
                     source.src = url;
                     source.removeAttribute("data-src");
                     videoEl.load();
                  }

                  function startHeroVideos() {
                     const isMobileInit = window.innerWidth <= 768;
                     if (isMobileInit) {
                        setVideoSource(mobileVideo, mobileVideos[0]);
                     } else {
                        setVideoSource(myVideo, desktopVideos[0]);
                     }
                     myVideo.play().catch(function(){});
                     mobileVideo.play().catch(function(){});
                  }

                  const heroObserver = new IntersectionObserver(function(entries) {
                     entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                           startHeroVideos();
                           heroObserver.disconnect();
                        }
                     });
                  }, { rootMargin: "200px 0px" });
                  heroObserver.observe(document.querySelector(".rn_home_video"));
                  
                  const textContent = [
                     {
                        heading: "PTMT Faucets | CP Faucets | Shower | Health Faucets | CP Accessories | PTMT Accessories | Expose Shower | High Grade Engineering Polymer Taps: Durable Elegance for Every Flow – RN Valves & Faucets",
                        link: "{{url('/ptmt-taps-or-faucets')}}",
                        linkText: "Explore Now"
                     },
                     {
                        heading: "Elevate Your Space with Our Premium Collection: Where Style Meets Functionality",
                        link: "{{url('/products')}}",
                        linkText: "Discover More"
                     }
                  ];
                  
                  let currentVideoIndex = 0;
                  let isAudioMuted = true; // Track audio state globally

                  function changeVideo(index) {
                     if (index < 0) {
                        currentVideoIndex = desktopVideos.length - 1;
                     } else if (index >= desktopVideos.length) {
                        currentVideoIndex = 0;
                     } else {
                        currentVideoIndex = index;
                     }

                     const isMobile = window.innerWidth <= 768;
                     const activeVideo = isMobile ? mobileVideo : myVideo;
                     const inactiveVideo = isMobile ? myVideo : mobileVideo;

                     // Update Desktop Source
                     setVideoSource(myVideo, desktopVideos[currentVideoIndex]);
                     
                     // Update Mobile Source
                     setVideoSource(mobileVideo, mobileVideos[currentVideoIndex]);

                     // Apply mute state based on global flag and visibility
                     myVideo.muted = true; // Always mute desktop by default during change
                     mobileVideo.muted = true; // Always mute mobile by default during change
                     
                     if (!isAudioMuted) {
                        activeVideo.muted = false;
                     }

                     myVideo.play();
                     mobileVideo.play();
                     
                     // Update Dots
                     document.querySelectorAll('.dot-progress').forEach(p => p.style.width = '0%');
                     document.querySelectorAll('.video-dot').forEach(d => d.classList.remove('active'));
                     const newActiveDot = document.getElementById('dot' + currentVideoIndex);
                     if(newActiveDot) newActiveDot.classList.add('active');

                     // Update Text Content with Fade
                     const heading = document.getElementById("bannerHeading");
                     const link = document.getElementById("bannerLink");
                     
                     heading.style.opacity = 0;
                     link.style.opacity = 0;
                     
                     setTimeout(() => {
                        heading.innerHTML = textContent[currentVideoIndex].heading;
                        link.innerHTML = textContent[currentVideoIndex].linkText;
                        link.href = textContent[currentVideoIndex].link;
                        
                        heading.style.opacity = 1;
                        link.style.opacity = 1;
                     }, 300);
                  }

                  // Progress Bar Update
                  function updateProgress() {
                     const activeV = window.innerWidth <= 768 ? mobileVideo : myVideo;
                     if(activeV && activeV.duration) {
                        const progress = (activeV.currentTime / activeV.duration) * 100;
                        const activeDot = document.querySelector('#dot' + currentVideoIndex + ' .dot-progress');
                        if (activeDot) activeDot.style.width = progress + '%';
                     }
                  }
                  
                  myVideo.addEventListener("timeupdate", updateProgress);
                  mobileVideo.addEventListener("timeupdate", updateProgress);

                  // Event listeners for buttons
                  document.getElementById("nextBtn").addEventListener("click", function() {
                     changeVideo(currentVideoIndex + 1);
                  });
                  document.getElementById("prevBtn").addEventListener("click", function() {
                     changeVideo(currentVideoIndex - 1);
                  });
                  
                  // Dot Click Listeners
                  document.querySelectorAll('.video-dot').forEach(dot => {
                     dot.addEventListener("click", function() {
                        const idx = parseInt(this.getAttribute('data-index'));
                        if(idx !== currentVideoIndex) {
                           changeVideo(idx);
                        }
                     });
                  });

                  // Auto play next video when ended
                  myVideo.addEventListener("ended", function() {
                     changeVideo(currentVideoIndex + 1);
                  });
                  mobileVideo.addEventListener("ended", function() {
                     changeVideo(currentVideoIndex + 1);
                  });
                  
                  // Audio Toggle Logic
                  const audioBtn = document.getElementById("videoAudioToggle");
                  const audioIcon = document.getElementById("videoAudioIcon");
                  
                  audioBtn.addEventListener("click", function() {
                     const isMobile = window.innerWidth <= 768;
                     const activeVideo = isMobile ? mobileVideo : myVideo;
                     const inactiveVideo = isMobile ? myVideo : mobileVideo;

                     if (isAudioMuted) {
                        // Unmute
                        isAudioMuted = false;
                        activeVideo.muted = false;
                        inactiveVideo.muted = true; // Ensure inactive stays muted
                        audioIcon.classList.remove("fa-volume-mute");
                        audioIcon.classList.add("fa-volume-up");
                     } else {
                        // Mute
                        isAudioMuted = true;
                        myVideo.muted = true;
                        mobileVideo.muted = true;
                        audioIcon.classList.remove("fa-volume-up");
                        audioIcon.classList.add("fa-volume-mute");
                     }
                  });

                  // Handle window resize to prevent audio mixing
                  window.addEventListener('resize', function() {
                     if (!isAudioMuted) {
                        const isMobile = window.innerWidth <= 768;
                        if (isMobile) {
                           myVideo.muted = true;
                           mobileVideo.muted = false;
                        } else {
                           myVideo.muted = false;
                           mobileVideo.muted = true;
                        }
                     }
                  });
                  

               });
            </script>
         </div>
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
