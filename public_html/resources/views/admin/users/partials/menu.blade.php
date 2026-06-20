<div class="col-lg-12">
   <div class="card">
      <div class="card-header p-1">

         @if($user->user_type=="Employee")

         @can('user-list')
         <a href="{{ route('users.show', ['user'=>$user]) }}" class="btn border btn-sm user_menu @if(request()->routeIs('users.show')) active btn-info @else btn-default @endif"><i class="bx bx-add-to-queue"></i> Basic Details</a>
         @endcan
         
         @else

         @can('customer-index')
         <a href="{{ route('customers.show', ['customer'=>$user]) }}" class="btn border btn-sm user_menu @if(request()->routeIs('customers.show')) active btn-info @else btn-default @endif"><i class="bx bx-add-to-queue"></i> Basic Details</a>
         @endcan

         <a href="{{ route('customers.orders.index', $user) }}" class="btn border btn-sm user_menu @if(request()->routeIs('customers.orders.index')) active btn-info @else btn-default @endif"><i class="bx bx-add-to-queue"></i> Orders</a>

         @endif

         @can('user-address-create')
         <a href="{{ route('userAddresses.create', ['user'=>$user]) }}" class="btn border btn-sm user_menu @if(request()->routeIs('userAddresses.create'))  active btn-info @else btn-default @endif"><i class="bx bx-add-to-queue"></i> Addresses</a>
         @endcan
         @can('user-log-remark-index')
         <a href="{{ route('users.userRemarkLog', ['user'=>$user]) }}" class="btn border btn-sm user_menu @if(request()->routeIs('users.userRemarkLog'))  active btn-info @else btn-default @endif"><i class="bx bx-add-to-queue"></i> Complete Remark Log</a>
         @endcan


      </div>
   </div>
</div>

<style type="text/css">
   td,th,.user_menu{
      font-size:18px!important;
   }
   td{font-weight:600!important}
   th{font-weight:400!important}
</style>