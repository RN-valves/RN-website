@can('enquiry-list')
<!-- Sales Card -->
<div class="col-xxl-2 col-md-2">
   <div class="card info-card sales-card">
      {{-- 
      <div class="filter">
         <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
         <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <li class="dropdown-header text-start">
               <h6>Filter</h6>
            </li>
            <li><a class="dropdown-item" href="#">Today</a></li>
            <li><a class="dropdown-item" href="#">This Month</a></li>
            <li><a class="dropdown-item" href="#">This Year</a></li>
         </ul>
      </div>
      --}}
      <a href="{{ route('enquiries.index') }}">
         <div class="card-body">
            <h5 class="card-title">Enquiries <span>| Total</span></h5>
            <div class="d-flex align-items-center">
               <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bx bx-list-ol"></i>
               </div>
               <div class="ps-3">
                  @if(auth()->user()->hasAnyRole(['Super_Admin','Admin']))
                  <h6>{{ App\Models\Enquiry::count() }}</h6>
                  @else
                  <h6>{{ App\Models\Enquiry::where(['salesmen_id'=>auth()->user()->id])->count() }}</h6>
                  @endif
                  {{-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> --}}
               </div>
            </div>
         </div>
      </a>
   </div>
</div>
@endcan
<!-- End Sales Card -->
@can('order-list')
<!-- Revenue Card -->
<div class="col-xxl-2 col-md-2">
   <a href="{{ route('orders.index') }}">
      <div class="card info-card revenue-card">
         <div class="card-body">
            <h5 class="card-title">Sale <span>| Total</span></h5>
            <div class="d-flex align-items-center">
               <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-currency-rs">₹</i>
               </div>
               <div class="ps-3">
                  <h6>{{ round(App\Models\Order::total_verified_sale_cr_month()->sum('total_amount'),2) }}</h6>
                  {{-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> --}}
               </div>
            </div>
         </div>
      </div>
   </a>
</div>
<!-- End Revenue Card -->
@endcan
@can('customer-index')
<!-- Customers Card -->
<div class="col-xxl-2 col-xl-2">
   <a href="{{ route('users.customer_network') }}">
      <div class="card info-card customers-card">
         <div class="card-body">
            <h5 class="card-title">Customers <span>| Total</span></h5>
            <div class="d-flex align-items-center">
               <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-people"></i>
               </div>
               <div class="ps-3">
                  @if(auth()->user()->hasAnyRole(['Super_Admin','Admin']))
                  <h6>{{ App\Models\User::where(['user_type'=>'Customer'])->whereNotIn('id',[1])->count() }}</h6>
                  @else
                  <h6>{{ App\Models\User::where(['user_type'=>'Customer', 'sales_user_id'=>auth()->user()->id])->whereNotIn('id',[1])->count() }}</h6>
                  @endif
                  {{-- <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span> --}}
               </div>
            </div>
         </div>
      </div>
   </a>
</div>
@endcan
@can('remark-log-list')
<div class="col-xxl-2 col-xl-2">
   <a href="{{ route('remarkLogs.index') }}">
      <div class="card info-card sales-card">
         <div class="card-body">
            <h5 class="card-title">Call Logs <span>| Total</span></h5>
            <div class="d-flex align-items-center">
               <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bx bx-phone"></i>
               </div>
               <div class="ps-3">
                  @if(auth()->user()->hasAnyRole(['Super_Admin','Admin']))
                  <h6>{{ App\Models\RemarkLog::count() }}</h6>
                  @else
                  <h6>{{ App\Models\RemarkLog::where('user_id',auth()->user()->id)->count() }}</h6>
                  @endif
                  {{-- <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span> --}}
               </div>
            </div>
         </div>
      </div>
   </a>
</div>
@endcan
@can('order-list')
<div class="col-xxl-2 col-xl-2">
   <a href="{{ route('orders.index') }}">
      <div class="card info-card sales-card">
         <div class="card-body">
            <h5 class="card-title">Order Pending <span>| Total</span></h5>
            <div class="d-flex align-items-center">
               <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bx bx-cart"></i>
               </div>
               <div class="ps-3">
                  @if(auth()->user()->hasAnyRole(['Super_Admin','Admin','Dispatch']))
                  <h6>{{ App\Models\Order::whereNotIn('status',['Delivered','Cancelled','RTO','RTO Delivered'])->whereDate('created_at','>','2025-01-31')->count() }}</h6>
                  @else
                  <h6>{{ App\Models\Order::whereNotIn('status',['Delivered','Cancelled','RTO','RTO Delivered'])->where('user_id',auth()->user()->id)->whereDate('created_at','>','2025-01-20')->count() }}</h6>
                  @endif
                  {{-- <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span> --}}
               </div>
            </div>
         </div>
      </div>
   </a>
</div>
@endcan
@can('order-list')
<div class="col-xxl-2 col-xl-2">
   <a href="{{ route('orders.index') }}">
      <div class="card info-card sales-card">
         <div class="card-body">
            <h5 class="card-title">Order Delivered <span>| Total</span></h5>
            <div class="d-flex align-items-center">
               <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bx bx-cart"></i>
               </div>
               <div class="ps-3">
                  @if(auth()->user()->hasAnyRole(['Super_Admin','Admin','Dispatch']))
                  <h6>{{ App\Models\Order::where('status','Delivered')->count() }}</h6>
                  @else
                  <h6>{{ App\Models\Order::where('status','Delivered')->where('user_id',auth()->user()->id)->count() }}</h6>
                  @endif
                  {{-- <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span> --}}
               </div>
            </div>
         </div>
      </div>
   </a>
</div>
@endcan
@can('enquiry-list')
<!-- Sales Card -->
<div class="col-xxl-2 col-md-2">
   <div class="card info-card sales-card">
      {{-- 
      <div class="filter">
         <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
         <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <li class="dropdown-header text-start">
               <h6>Filter</h6>
            </li>
            <li><a class="dropdown-item" href="#">Today</a></li>
            <li><a class="dropdown-item" href="#">This Month</a></li>
            <li><a class="dropdown-item" href="#">This Year</a></li>
         </ul>
      </div>
      --}}
      <a href="{{ route('enquiries.index') }}">
         <div class="card-body">
            <h5 class="card-title">Enquiries <span>| Today</span></h5>
            <div class="d-flex align-items-center">
               <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bx bx-list-ol"></i>
               </div>
               <div class="ps-3">
                  @if(auth()->user()->hasAnyRole(['Super_Admin','Admin']))
                  <h6>{{ App\Models\Enquiry::whereDate('created_at',now())->count() }}</h6>
                  @else
                  <h6>{{ App\Models\Enquiry::where(['salesmen_id'=>auth()->user()->id])->whereDate('created_at',now())->count() }}</h6>
                  @endif
                  {{-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> --}}
               </div>
            </div>
         </div>
      </a>
   </div>
</div>
@endcan
<!-- End Sales Card -->
@can('order-list')
<!-- Revenue Card -->
<div class="col-xxl-2 col-md-2">
   <a href="{{ route('orders.index') }}">
      <div class="card info-card revenue-card">
         <div class="card-body">
            <h5 class="card-title">Sale <span>| Today</span></h5>
            <div class="d-flex align-items-center">
               <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-currency-rs">₹</i>
               </div>
               <div class="ps-3">
                  <h6>{{ round(App\Models\Order::total_verified_sale_today()->sum('total_amount'),2) }}</h6>
                  {{-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> --}}
               </div>
            </div>
         </div>
      </div>
   </a>
</div>
<!-- End Revenue Card -->
@endcan
@can('customer-index')
<!-- Customers Card -->
<div class="col-xxl-2 col-xl-2">
   <a href="{{ route('users.customer_network') }}">
      <div class="card info-card customers-card">
         <div class="card-body">
            <h5 class="card-title">Customers <span>| Today</span></h5>
            <div class="d-flex align-items-center">
               <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-people"></i>
               </div>
               <div class="ps-3">
                  @if(auth()->user()->hasAnyRole(['Super_Admin','Admin']))
                  <h6>{{ App\Models\User::where(['user_type'=>'Customer'])->whereNotIn('id',[1])->whereDate('created_at',now())->count() }}</h6>
                  @else
                  <h6>{{ App\Models\User::where(['user_type'=>'Customer', 'sales_user_id'=>auth()->user()->id])->whereNotIn('id',[1])->whereDate('created_at',now())->count() }}</h6>
                  @endif
                  {{-- <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span> --}}
               </div>
            </div>
         </div>
      </div>
   </a>
</div>
@endcan
@can('remark-log-list')
<div class="col-xxl-2 col-xl-2">
   <a href="{{ route('remarkLogs.index') }}">
      <div class="card info-card sales-card">
         <div class="card-body">
            <h5 class="card-title">Call Logs <span>| Today</span></h5>
            <div class="d-flex align-items-center">
               <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bx bx-phone"></i>
               </div>
               <div class="ps-3">
                  @if(auth()->user()->hasAnyRole(['Super_Admin','Admin']))
                  <h6>{{ App\Models\RemarkLog::whereDate('created_at',now())->count() }}</h6>
                  @else
                  <h6>{{ App\Models\RemarkLog::where('user_id',auth()->user()->id)->whereDate('created_at',now())->count() }}</h6>
                  @endif
                  {{-- <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span> --}}
               </div>
            </div>
         </div>
      </div>
   </a>
</div>
@endcan
@can('order-list')
<div class="col-xxl-2 col-xl-2">
   <a href="{{ route('orders.index') }}">
      <div class="card info-card sales-card">
         <div class="card-body">
            <h5 class="card-title">Order Pending <span>| Today</span></h5>
            <div class="d-flex align-items-center">
               <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bx bx-cart"></i>
               </div>
               <div class="ps-3">
                  @if(auth()->user()->hasAnyRole(['Super_Admin','Admin','Dispatch']))
                  <h6>{{ App\Models\Order::where('status','Pending')->whereDate('created_at',now())->count() }}</h6>
                  @else
                  <h6>{{ App\Models\Order::where('status','Pending')->where('user_id',auth()->user()->id)->whereDate('created_at',now())->count() }}</h6>
                  @endif
                  {{-- <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span> --}}
               </div>
            </div>
         </div>
      </div>
   </a>
</div>
@endcan
@can('order-list')
<div class="col-xxl-2 col-xl-2">
   <a href="{{ route('orders.index') }}">
      <div class="card info-card sales-card">
         <div class="card-body">
            <h5 class="card-title">Order Delivered <span>| Today</span></h5>
            <div class="d-flex align-items-center">
               <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bx bx-cart"></i>
               </div>
               <div class="ps-3">
                  @if(auth()->user()->hasAnyRole(['Super_Admin','Admin','Dispatch']))
                  <h6>{{ App\Models\Order::where('status','Delivered')->whereDate('created_at',now())->count() }}</h6>
                  @else
                  <h6>{{ App\Models\Order::where('status','Delivered')->where('user_id',auth()->user()->id)->whereDate('created_at',now())->count() }}</h6>
                  @endif
                  {{-- <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span> --}}
               </div>
            </div>
         </div>
      </div>
   </a>
</div>
@endcan