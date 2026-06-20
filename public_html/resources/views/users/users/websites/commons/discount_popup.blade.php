@php
$discounts = App\Models\Discount::getActiveDiscountList();
@endphp
@if($discounts->count()>0)
<div class="product-meta">
   <span class="product-meta-name">Discount:</span>
   <span class="name"><a href="#" data-toggle="modal" data-target="#discount_popup" class="text-info"> <b> Details </b></a></span>
</div>
<style type="text/css">
   tr,th{
   font-size:12px;
   padding:5px;
   }
</style>
<div class="modal fade" id="discount_popup"  aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog cancel_form">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Discount</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position:relative;background: #00a0e3 !important;opacity: 1;color: #fff;z-index: 999;cursor: pointer!important;height: 50px!important;width: 50px!important;">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="model-body">
            <p class="text-center py-2">Apply on the checkout page</p>
            <div class="table-responsive">
               <table class="table table-bordered table-striped table-sm text-center">
                  <tr>
                     <th>Minimum</th>
                     <th>Maximum</th>
                     <th>Discount</th>
                     <th>Code</th>
                     {{-- <th>ExpireAt</th> --}}
                  </tr>
                  @foreach($discounts??'' as $discount)
                  <tr>
                     <td>₹{{ $discount->start_value??0 }}</td>
                     <td>₹{{ $discount->end_value??0 }}</td>
                     <td><strong class="text-success">@if($discount->type=="Percent") {{ $discount->value??'' }} % @else ₹{{ $discount->value??'' }} @endif</strong></td>
                     <td>{{ $discount->name??'' }}</td>
                     {{-- <td>{{ $discount->expired_at->format('d M Y') }}</td> --}}
                  </tr>
                  @endforeach
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
@endif