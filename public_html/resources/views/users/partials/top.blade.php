@php
$cart = \Cart::count();
$url = url()->current();
@endphp
<!--Main Header Start-->
<header class="position-inherit border-none header_shahdow">
   <!--Topbar area-->
   <style>
        .marqueetext {
         padding: 5px 20px;
         border-radius: 12px;
         background: #00afef;
         margin: 0px 10px;
         color: #fff;
         font-size: 14px !important;
         font-weight: 600;
        }
    </style>
   <div class="topbar-area topppbg">
      <div class="container-fluid">
      <!-- <div class="row marquee_info">
         <div class="col-md-12">
            <marquee behavior="alternate" direction="left" class="marqueestyle" onmouseover="this.stop();" onmouseout="this.start();">
               <span class="marqueetext">🔥 GET FLAT 10% OFF ABOVE ₹1499 PURCHASE! 🛒 (USE CODE:	
                  RN10OFF)</span>
            </marquee>
         </div>
      </div> -->
         <div class="topbar-inner">
            <div class="left-content">
            </div>
            <div class="right-content">
               <div class="social-icon">
                  <ul>
                     <li><a href="tel:{{ frontPage()->mobile??'' }}" class="icon"><i class="fas fa-headphones"></i> {{ frontPage()->mobile??'' }}</a></li>
                     <font>|</font>
                     <li class="mbhidden"><a href="mailto:{{ frontPage()->email??'' }}" class="icon"><i class="fas fa-envelope"></i> {{ frontPage()->email??'' }}</a></li>
                     <font>|</font>
                     <li class="mbhidden"><a href="{{ route('direct_payment') }}" class="icon rounded-0"><i class="fas fa-money-check"></i> Payment Now</a></li>
                     <font>|</font>
                     @guest
                     <li><a class="icon last_icon btn text-white" href="{{route('login')}}" style="background-color:#00a0e3;">
                        <i class="fas fa-user-circle"></i><font class="mbhidden">Login </font></a>
                     </li>
                     @else
                     <li><a class="icon last_icon btn text-white" href="{{route('dashboard')}}" style="background-color:#00a0e3;">
                        <i class="fas fa-user-circle"></i><font class="mbhidden">{{ substr(auth()->user()->name??'', 0, 12) }} </font></a>
                     </li>
                     @endguest
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!--// Top Bar Area End-->
   <div class="container-fluid ">
      <div>
         <div class="header-bottom-area">
            <!--Logo Area Start-->
            <div class="logo-area">
               <a href="{{route('welcome')}}">
               <img src="{{ url(frontPage()->logo??'') }}" class="web_logo" alt="RN Valves & Faucets - Logo" fetchpriority="high">
               </a>
            </div>
            <!--// Logo Area End-->
            <!--Navbar Area Start Here-->
            <nav class="navbar navbar-area navbar-expand-lg style-02">
               <div class="container-fluid nav-container dsktop_right_pad">
                  <button class="navbar-toggler" type="button" onclick="rnToggleNav(this)" aria-label="Toggle navigation" aria-expanded="false">
                  <span class="humberger-menu black">
                  <span class="one"></span>
                  <span class="two"></span>
                  <span class="three"></span>
                  </span>
                  </button>
                  <div class="collapse navbar-collapse" id="autoshop_main_menu">
                     <ul class="navbar-nav">
                        <li class="{{$url==route('welcome')? 'current-menu-item': ''}}"><a href="{{route('welcome')}}">Home</a></li>
                        <li class="menu-item-has-children">
                           <a href="#">Our Products</a>
                           <div class="sub-menu asrmenus">
                              <div class="epayment-tab-container">
                                 <div class="row plr8">
                                    <div class="col-md-9 col-sm-9 col-9 plr8 lefft_sidde">
                                       
                                       <div class="epayment-tab">
                                          <!-- cat tab1 -->
                                          <style>
                                           .ashdngs a {
                                             display: inline-block;                                          
                                             background: linear-gradient(135deg, #025e89, #008cc1, #02c952);
                                             color: white; 
                                             padding: 10px 20px!important;
                                             border-radius: 10px; 
                                             text-decoration: none;                                            
                                             position: relative;
                                             text-align: center;
                                             transition: all 0.3s ease;
                                             box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
                                           }

                                           .ashdngs a:hover {
                                              box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.3);
                                              background: linear-gradient(135deg, #01445f, #006d95, #029a3c);
                                             }
                                           .catprlop:hover {
                                              box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.3);                                            
                                             }
                                          </style>            
                                          
                                          @php $acat = 0; @endphp
                                          @foreach(ActiveCategories()??'' as $ACategory)
                                          @php $acat++ @endphp
                                          <div class="epayment-tab-content @if($acat==7) active @endif">
                                             <h5 class="ashdngs">
                                                <a href="{{ route('productList', $ACategory) }}" class="maincategory">{{ $ACategory->name??'' }}</a>
                                             </h5>
                                             
                                             <div class="row plr8">
                                                <!--loop-->
                                                @foreach(App\Models\Category::getCatSubcategories($ACategory->id)??'' as $subCat)
                                                <div class="col-md-6 col-sm-6 col-6 plr8">
                                                   <a href="{{ route('productList.list', [$ACategory->url_key,$subCat]) }}">
                                                      <div class="catprlop">
                                                         <img src="{{ url($subCat->image??'') }}" class="cathumb" alt="{{ $subCat->title??'' }}" title="{{ $subCat->title??'' }}" loading="lazy" width="80" height="80">
                                                         <div class="catxtxbx">
                                                            <div class="cat2name">{{ $subCat->name??'' }}</div>
                                                            <div class="greytxext">{{ $subCat->name??'' }}</div>
                                                         </div>
                                                         @if($subCat->is_new == 1)
                                                         <img src="https://rnvalves.media/Catalogue/master/new-1.gif" width="40" height="25" alt="" srcset="">
                                                         @endif
                                                      </div>
                                                   </a>
                                                </div>
                                                @endforeach
                                                <!--loop end-->
                                             </div>
                                          </div>
                                          @endforeach
                                          <!-- cat tab1 end-->
                                       </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-3 plr8 right_sidde">
                                       <div class="epayment-tab-menu">
                                          <div class="list-group">
                                             
                                             @php $acat = 0; @endphp
                                             @foreach(ActiveCategories()??'' as $ACategory)
                                             @php $acat++ @endphp
                                             @if($acat==7)
                                             <a href="#" class="list-group-item text-center active">
                                                 {{ $ACategory->name??'' }}</a>
                                             @else
                                             
                                             <a href="#" class="list-group-item text-center">
                                             {{ $ACategory->name??'' }}</a>
                                             @endif
                                             @endforeach
                                           
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </li>
                        {{-- 
                        <li class="menu-item-has-children">
                           <a href="#">Our Products</a>
                           <ul class="sub-menu">
                              @foreach(ActiveCategories()??'' as $ACategory)
                              <li class="current-menu-item"><a href="{{ route('productList', $ACategory) }}">{{ $ACategory->name??'' }}</a></li>
                              @endforeach
                           </ul>
                        </li>
                        --}}
                        <li class="{{ $url==route('aboutUs')? 'current-menu-item': '' }}"><a href="{{route('aboutUs')}}">About Us</a></li>
                        {{-- <li class="{{ $url==route('catalogue')? 'current-menu-item': '' }}"><a href="{{route('catalogue')}}">Catalogue</a></li> --}}
                        <li class="{{ $url==route('contactUs')? 'current-menu-item': '' }}"><a href="{{route('contactUs')}}">Contact Us</a></li>
                        <li class="{{ $url==route('news',['url_key' => 'news'])? 'current-menu-item': '' }}"><a href="{{route('news',['url_key' => 'news'])}}">Media</a></li>
                     </ul>
                  </div>
                  <!-------Mobile Menu-------------->                  
                  <div id="navbarSupportedContent" class="rn-mobile-nav">
                     <ul class="navbar-nav ml-auto py-4 py-md-0">
                        <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                           <a class="nav-link" href="{{route('welcome')}}">Home</a>
                        </li>
                        <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                           <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)" role="button" aria-haspopup="true" aria-expanded="false">Our Products</a>
                           <div class="dropdown-menu twobxss">
                              @foreach(ActiveCategories()??'' as $ACategory)
                              <a href="{{ route('productList', $ACategory) }}">
                                 <img src="{{ url($ACategory->image??'') }}" alt="{{ $ACategory->name??'' }}" title="{{ $ACategory->name??'' }}" class="moblcthumb" loading="lazy" width="60" height="60">
                                 <div class="ctnsmxe">{{ $ACategory->name??'' }}</div>
                              </a>
                              @endforeach
                              <div class="clerbx"></div>
                           </div>
                        </li>
                        <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                           <a class="nav-link" href="{{route('aboutUs')}}">About RN Valves</a>
                        </li>
                        <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                           <a class="nav-link" href="{{route('contactUs')}}">Contact Us</a>
                        </li>
                        <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                           <a class="nav-link" href="{{ route('career') }}">Career with Us</a>
                        </li>
                        <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                           <a class="nav-link" href="{{route('blogs', ['url_key'=>'blogs'])}}">Our Blogs</a>
                        </li>
                        <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                           <a class="nav-link" href="{{ route('policy', ['url_key'=>"privacy"]) }}">Privacy Policy</a>
                        </li>
                        <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                           <a class="nav-link" href="{{ route('policy', ['url_key'=>"certificates"]) }}">Our Certification</a>
                        </li>
                        <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                           <a class="nav-link" href="{{ route('news',['url_key' => 'news']) }}">Media</a>
                        </li>
                     </ul>
                  </div>
                  <!-------Mobile Menu-------------->

                  <!--Nav Right Content-->
                  <style>
                     @media (max-width: 991px) {
                        .header-bottom-area {
                           position: relative !important;
                        }
                        .navbar {
                           position: static !important;
                        }
                        .navbar-toggler {
                           position: absolute !important;
                           right: 15px !important;
                           top: 35px !important;
                           transform: translateY(-50%) !important;
                           z-index: 100 !important;
                           width: auto !important;
                        }
                        .nav-right-content {
                           position: absolute !important;
                           right: 70px !important; /* Move away from hamburger */
                           top: 35px !important;
                           transform: translateY(-50%) !important;
                           z-index: 99 !important;
                        }
                        .nav-right-content ul {
                           gap: 10px !important;
                        }
                        .search_box {
                           padding: 0px 5px !important;
                           margin: 0 !important;
                           background: transparent !important;
                           box-shadow: none !important;
                        }
                        @media (max-width: 480px) {
                           .nav-right-content {
                              right: 50px !important;
                           }
                           .search_box {
                              padding: 0 !important;
                           }
                        }
                     }
                  </style>
                  <div class="nav-right-content black">
                     <div class="d-flex align-items-center">
                        <ul style="display: flex; gap: 20px; align-items: center; margin: 0; padding: 0;">
                           <li class="search_box" style="background: #f1f5f9; border-radius: 30px; padding: 5px 15px; box-shadow: inset 0 2px 4px rgba(0,0,0,0.02); transition: all 0.3s ease;">
                              @include('users.partials.search')
                           </li>
                           <li class="cart" style="margin-right: 10px !important;">
                              <a href="{{ route('cart') }}" class="notification" style="color: #475569; text-decoration: none; position: relative; display: inline-block; font-size: 20px; transition: color 0.25s ease;" onmouseover="this.style.color='#003366'" onmouseout="this.style.color='#475569'">
                              <i class="fa fa-shopping-cart"></i>
                              <span class="badge totalCartItems" style="position: absolute; top: -8px; right: -10px; background: #ef4444; color: white; border-radius: 50%; min-width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: bold;">{{ \Cart::content()->count() }}</span>
                              </a>
                           </li>
                        </ul>
                     </div>
                  </div>
                  <!--// Nav Right Content-->
               </div>
            </nav>
            <!-- navbar area end -->
         </div>
         <!--// header Bottom-->
      </div>
   </div>
                   {{-- Mobile nav toggle CSS + JS --}}
                   <style>
                      @media (max-width: 991px) {
                         #navbarSupportedContent.rn-mobile-nav {
                            display: none;
                            width: 100%;
                            position: absolute;
                            top: 100%;
                            left: 0;
                            right: 0;
                            background: #ffffff;
                            z-index: 9000;
                            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
                            border-top: 3px solid #00a0e3;
                            max-height: 80vh;
                            overflow-y: auto;
                         }
                         #navbarSupportedContent.rn-mobile-nav.rn-open {
                            display: block !important;
                         }
                         #navbarSupportedContent.rn-mobile-nav .navbar-nav {
                            flex-direction: column !important;
                            padding: 8px 0 !important;
                            margin: 0 !important;
                         }
                         #navbarSupportedContent.rn-mobile-nav .nav-item {
                            border-bottom: 1px solid #f0f0f0;
                            padding-left: 0 !important;
                            margin: 0 !important;
                         }
                         #navbarSupportedContent.rn-mobile-nav .nav-link {
                            padding: 13px 20px !important;
                            font-size: 15px !important;
                            font-weight: 600 !important;
                            color: #1a1a1a !important;
                            display: block;
                         }
                         #navbarSupportedContent.rn-mobile-nav .nav-link:hover {
                            background: #f4f7fb;
                            color: #003366 !important;
                         }
                         #navbarSupportedContent.rn-mobile-nav .dropdown-menu {
                            position: static !important;
                            float: none !important;
                            width: 100% !important;
                            box-shadow: none !important;
                            border: none !important;
                            background: #f4f7fb !important;
                            padding: 0 !important;
                            margin: 0 !important;
                         }
                         #navbarSupportedContent.rn-mobile-nav .dropdown-menu.show {
                            display: block !important;
                         }
                      }
                      @media (min-width: 992px) {
                         #navbarSupportedContent.rn-mobile-nav {
                            display: none !important;
                         }
                      }
                   </style>
                   <script>
                   function rnToggleNav(btn) {
                      var nav = document.getElementById('navbarSupportedContent');
                      if (!nav) return;
                      var isOpen = nav.classList.contains('rn-open');
                      if (isOpen) {
                         nav.classList.remove('rn-open');
                         btn.setAttribute('aria-expanded', 'false');
                      } else {
                         nav.classList.add('rn-open');
                         btn.setAttribute('aria-expanded', 'true');
                      }
                   }
                   document.addEventListener('click', function(e) {
                      var nav = document.getElementById('navbarSupportedContent');
                      var btn = document.querySelector('.navbar-toggler');
                      if (nav && btn && !nav.contains(e.target) && !btn.contains(e.target)) {
                         nav.classList.remove('rn-open');
                         btn.setAttribute('aria-expanded', 'false');
                      }
                   });
                   </script>
</header>
<!--// Main Header End Here-->
<!--Slider Area Start-->
