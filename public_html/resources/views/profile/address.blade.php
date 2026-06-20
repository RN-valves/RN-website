@extends('users.master')
@section('seo_tags')
@endsection
@section('ccs_links')
<link rel="stylesheet" href="{{url('users/assets/css/custom.css')}}" type="text/css">
@endsection
@section('auth_content')

<div class="">
   <div class="container-fluid">
      <div>
         <div class="brdcrm_menu"><a href="{{ route('dashboard') }}"><i class="fas fa-chevron-left"></i>Back to My Account</a></div>
         <div class="row">
            @include('profile.partials.booking_addresses')
         </div>
     </div>
 </div>
</div>

@endsection
@section('scripts')
@endsection
