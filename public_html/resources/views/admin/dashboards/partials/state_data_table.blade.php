<!-- Top Selling -->
<div class="col-12">
   <div class="card top-selling overflow-auto">
      <div class="card-body pb-0">
         <h5 class="card-title">Total State Data <span></span></h5>
         <table class="table table-bordered table-striped">
            <thead>
               <tr>
                  <th class="text-center">State</th>
                  @can('enquiry-list')
                  <th class="text-center">Enquiry</th>
                  @endcan
                  @can('order-list')
                  <th class="text-center">Transactions</th>
                  <th class="text-center">Sales</th>
                  @endcan
                  @can('customer-index')
                  <th class="text-center">Customers</th>
                  @endcan
               </tr>
            </thead>
            <tbody>
               @php
               $states = App\Models\State::get();
               @endphp
               @foreach($states??'' as $state)
               <tr>
                  <th class="text-center">{{ $state->name??'' }}</th>
                  @can('enquiry-list')
                  <td class="text-center">
                     @if(auth()->user()->hasAnyRole(['Super_Admin','Admin']))
                     {{ App\Models\Enquiry::where(['state_id'=>$state->id])->count() }}
                     @else
                     {{ App\Models\Enquiry::where(['salesmen_id'=>auth()->user()->id,'state_id'=>$state->id])->count() }}
                     @endif
                  </td>
                  @endcan
                  @can('order-list')
                  <td class="text-center">
                     {{ App\Models\Order::total_verified_sale_cr_month()->where('state', $state->name)->count() }}
                  </td>
                  <td class="text-center">{{ round(App\Models\Order::total_verified_sale_cr_month()->where('state', $state->name)->sum('total_amount'),2) }}</td>
                  @endcan
                  @can('customer-index')
                  <td class="text-center">
                     @if(auth()->user()->hasAnyRole(['Super_Admin','Admin']))
                     {{ App\Models\User::where(['state_id'=>$state->id, 'user_type'=>'Customer'])->whereNotIn('id',[1])->count() }}
                     @else
                     {{ App\Models\User::where(['user_type'=>'Customer', 'sales_user_id'=>auth()->user()->id,'state_id'=>$state->id])->whereNotIn('id',[1])->count() }}
                     @endif
                  </td>
                  @endcan
               </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>
</div>
<!-- End Top Selling -->