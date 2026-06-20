@extends('users.master')
@section('seo_tags')
@endsection
@section('ccs_links')
<link rel="stylesheet" href="{{url('users/assets/css/custom.css')}}" type="text/css">
@endsection
@section('auth_content')
<div class="breadcrumb-area style-03">
   <div class="container">
      <div class="row">
         <div class="breadcrumb-content">
            <h1 class="page-title">My Account</h1>
            <ul class="page-list">
               <li><a href="{{route('welcome')}}">Home</a></li>
               <li><a>My Account</a></li>
            </ul>
         </div>
      </div>
   </div>
</div>
<!--Page-->
<div class="cstm_page_section website-cart addressbxx">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12 col-lg-12">
            <div>
               <div class="acc_page_title">Hello, {{Auth::user()->name}}</div>
               <div class="dash_board_nav">
                  <div class="dash_board_inside"><a href="{{ route('profile.edit') }}">
                     <i class="fas fa-user icon"></i> 
                     <span class="usernav_heading">My Profile</span><i class="fas fa-chevron-right rgt_icon"></i>
                     <span class="nav_notes">Edit personal info, change password</span>
                     </a>
                  </div>
                  <div class="dash_board_inside"><a href="{{ route('customer_order_list') }}">
                     <i class="icon flaticon-shopping-cart"></i> 
                     <span class="usernav_heading">My Orders</span><i class="fas fa-chevron-right rgt_icon"></i>
                     <span class="nav_notes">View, modify and track orders</span>
                     </a>
                  </div>
                  <div class="dash_board_inside"><a href="{{ route('addressesUpdate') }}">
                     <i class="fas fa-map-marker-alt icon"></i> 
                     <span class="usernav_heading">My Addresses</span><i class="fas fa-chevron-right rgt_icon"></i>
                     <span class="nav_notes">Edit, add or remove addresses</span></a>
                  </div>
                  <div class="dash_board_inside lastbx">
                     <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                        </form>
                        <i class="fas fa-power-off icon"></i> 
                        <span class="usernav_heading">Log Out</span><i class="fas fa-chevron-right rgt_icon"></i>
                        <span class="nav_notes">Log out my account - {{Auth::user()->name}}</span>
                     </a>
                  </div>
                  <div class="clearfix"></div>
               </div>
               <h2 class="hddings">Buy something to get personalised recommendations.</h2>
               <div>
                  <a href="{{route('welcome')}}" class="btn btn-light border"><b>Continue Shopping</b></a>
                  <a href="{{route('cart')}}" class="btn btn-light border">
                     <i class="fa fa-shopping-cart"></i>
                     <span class="badge totalCartItems"> ({{ \Cart::content()->count() }})
                  </a>
               </div>
            </div>
         </div>
      </div>
      <!--end cart section-->
   </div>
</div>
<!--//  Page-->
@endsection