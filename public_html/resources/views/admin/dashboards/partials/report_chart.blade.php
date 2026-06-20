<div class="col-12">
   <div class="card">
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
      @canany(['enquiry-list' , 'order-list' , 'customer-index'])
      @php
      $getOrderMonthly = App\Models\Order::getOrderMonthly();
      $months = array(1,2,3,4,5,6,7,8,9,10,11,12);
      @endphp
      <div class="card-body">
         <h5 class="card-title">Reports <span>/Monthly</span></h5>
         <!-- Line Chart -->
         <div id="reportsChart"></div>
         <script>
            document.addEventListener("DOMContentLoaded", () => {
              new ApexCharts(document.querySelector("#reportsChart"), {
                series: [
                @can('order-list')
                {
                  name: 'Sales',
                  data: [
                     @foreach($months as $month)
                     @php
                     $orderAmount = App\Models\Order::whereMonth('created_at',$month)->whereYear('created_at', now())->sum('total_amount');
                     @endphp
                     {{ $orderAmount->total_amount??0 }},
                     @endforeach
                     ],
                }, 
                @endcan
                @can('enquiry-list') 
                {
                  name: 'Enquiries',
                  data: [
                     @foreach($months as $month)
                     @php
                     $enquiryCount = App\Models\Enquiry::whereMonth('created_at', $month)->whereYear('created_at', now())->count();
                     @endphp
                     {{ $enquiryCount }},
                     @endforeach
                     ]
                },
                @endcan
                @can('customer-index')
                {
                  name: 'Customers',
                  data: [
                     @foreach($months as $month)
                     @php
                     $customersCount = App\Models\User::where('user_type','Customer')->whereNotIn('id',[1])->whereMonth('created_at', $month)->whereYear('created_at', now())->count();
                     @endphp
                     {{ $customersCount??0 }},
                     @endforeach
                     ]
                }
                @endcan
                ],
                chart: {
                  height: 350,
                  type: 'area',
                  toolbar: {
                    show: false
                  },
                },
                markers: {
                  size: 4
                },
                colors: ['#4154f1', '#2eca6a', '#fad02c'],
                fill: {
                  type: "gradient",
                  gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.3,
                    opacityTo: 0.4,
                    stops: [0, 90, 1000]
                  }
                },
                dataLabels: {
                  enabled: false
                },
                stroke: {
                  curve: 'smooth',
                  width: 2
                },
                xaxis: {
                  type: 'datetime',
                  categories: [
                     @foreach($months as $month)
                     @php
                     $monthd = Carbon\Carbon::createFromDate(now()->format('Y'), $month)->startOfMonth();
                     @endphp
                     "{{ $monthd->format('M Y') }}",
                     @endforeach
                     ]
                },
                tooltip: {
                  x: {
                    format: 'MM {{ now()->format('Y') }}' 
                  },
                }
              }).render();
            });
         </script>
         <!-- End Line Chart -->
      </div>
   </div>
</div>
@endcan