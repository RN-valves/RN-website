@extends('users.master')
@section('seo_tags')
@endsection
@section('ccs_links')
<link rel="stylesheet" href="{{url('users/assets/css/custom.css')}}" type="text/css">
@endsection
@section('auth_content')

<div class="">
   <div class="container-fluid">
      @if (count($errors) > 0)
         <div class="alert alert-danger">
            <strong>Whoops! </strong> There were some problems with your input.<br><br>
            <ul>
               @foreach ($errors->all() as $error)
               <li>{{ $error }}</li>
               @endforeach
            </ul>
         </div>
         @endif
      <div>
         <div class="brdcrm_menu"><a href="{{ route('dashboard') }}"><i class="fas fa-chevron-left"></i>Back to My Account</a></div>
         <div class="row">
            @include('profile.partials.order_detail')
            @include('profile.partials.order_right_side_detail')
         </div>
      </div>
   </div>
</div>

@endsection
@section('scripts')
<script type="text/javascript">
   //Cancel Order
   $(document).on('click', '.btnCancelOrder', function(){
        var reason = $("#cancelReason").val();
        var cancel_reason_text = $("#cancel_reason_text").val();
        if(reason==""){
            alert("Please select reason for cancelling the Order");
            return false;
        }
        if(cancel_reason_text==""){
            alert("Please enter reason for cancelling the Order");
            return false;
        }
        var result = confirm("Are you want to cancel this order?");
        if(!result){
            return false;
        }
   });  
</script>

<script type="text/javascript">
$(document).ready(function () {
   $(".confirm-form").submit(function (e) {
      $(".btnCancelOrder").attr("disabled", true);
      return true;
   });
});
</script>
@endsection
