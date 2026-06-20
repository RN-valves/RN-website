<?php 
   $url = url()->full();
?>
<div class="sidebarhover">
   <ul>
      <li><a class="actn_enquiry" href="javascript:void();"><img src="{{ url('icons/enquiry.svg') }}" width="26" height="30" alt="enquiry" /><span>Call Back Request</span></a></li>
      <li><a href="{{route('register')}}"><i class="icon flaticon-avatar"  style="font-size:25px;margin-left: 0px;"></i><span>Become a Dealer</span></a></li>
      <li><a class="actn_help" href="javascript:void();"><img src="{{ url('icons/gethelp.svg') }}" width="30" height="30" alt="help" /><span class="nh">Need a help</span></a></li>
   </ul>
</div>
<div class="menu_bar_sticky" id="menu_bar_sticky">
   <ul>
      <li>
         <a class="actn_enquiry" href="javascript:void();">
         <i class="icon flaticon-email"></i>
         <span class="en">Enquiry</span>
         </a>
      </li>
      <li>
         <a class="mdd {{$url==route('register')? 'active': ''}}" href="{{route('register')}}">
         <i class="icon flaticon-avatar"></i>
         <span class="en">Register<font></font></span>
         </a>
      </li>
      <li>
         <a class="actn_help" href="javascript:void();">
         <i class="icon flaticon-phone-call"></i><span class="nh"><font>Need a </font>Help</span>
         </a>
      </li>
      {{-- 
      <li class="vsb991">
         <a class="mdd crticon {{$url==route('cart')? 'active': ''}}" href="{{route('cart')}}"><span class="badgecart totalCartItems">{{ \Cart::content()->count() }}</span>
         <i class="icon flaticon-shopping-cart"></i><span class="nh">Cart</span>
         </a>
      </li>
      <li class="vsb991">
         <a class="mdd bdrnone {{$url==route('dashboard')? 'active': ''}}" href="{{route('dashboard')}}">
         <i class="icon fas fa-user-circle" @guest @else style="color:#ffdf77;" @endguest></i><span class="nh"><font>My </font>Account</span>
         </a>
      </li>
      --}}
   </ul>
   <div class="stikyarrow">
      <span data-toggle="toggle" data-target="#menu_bar_sticky"> <i class="fa fa-angle-left" aria-hidden="true"></i> </span>
   </div>
</div>