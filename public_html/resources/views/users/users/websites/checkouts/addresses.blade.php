<?php 
   $authUser = auth()->user();
   $addressTypes = App\Models\UserAddress::AddressTypes();
   ?>
@if(!empty($authUser))
<div class="check_tbs_box">
   <div class="head_section"> Delivery Address <a href="{{ url('usr/addresses') }}" class="chng_btn"><i class="fas fa-map-marker-alt"></i> Add Address</a> </div>
   <div>
      <div class="address_booklist_bxxx crtbtnactionlst">
         <ul>
            @foreach($authUser->addresses as $address)
            <!--looop--->
            <li class="selected">
               <label>
                  <input type="radio" name="shipping_charge_id" value="{{ $address->id }}" class="input-radio radio_22 getShippingCharge" id="shipping{{$address->id}}" required> 
                  <span>{{ substr($address['name']??'',0,10) }}. <font>{{ $address->type??'' }}</font>
                  {{ $address['mobile']??'' }}
                  </span>
                  <div class="addrsss_dtls">{{ $address['address']??'' }}, {{ $address['city']->name??'' }}, {{ $address['state']->name??'' }}
                     Pincode - <b>{{ $address['zipcode']??'' }}</b>
                  </div>
               </label>
               <div class="crtbtnactionlst">
                  <div class="row p_lr_8">
                     @can('user-address-edit')
                     <div class="col-12 p_lr_8">
                        <a href="{{ route('customer_address_edit', $address) }}" class="btn btn-block btn-light"><i class="fa fa-edit"></i><b>Edit</b></a>
                     </div>
                     @endcan
                     {{-- <div class="col-6 p_lr_8 pipline">
                        <a class="btn btn-block DeleteAddress btn-light" data-address="{{ $address->id }}" ><i class="fa fa-trash"></i> <b>REMOVE</b></a>
                     </div> --}}
                  </div>
               </div>
            </li>
            <!--looop end--->
            @endforeach
            <li> <a href="{{ url('usr/addresses') }}" class="add_newaddress"><i class="fa fa-plus"></i> Add New Address</a> </li>
         </ul>
      </div>
   </div>
</div>
@endif