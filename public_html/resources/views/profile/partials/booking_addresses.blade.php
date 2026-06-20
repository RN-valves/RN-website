<div class="col-md-12 col-lg-12">
   <div class="card">
      <div class="card-body">
         <div class="acc_page_title">Add New Addresses</div>
         <form method="post" action="{{ route('addressesStore') }}" class="mt-6 space-y-6">
            @csrf
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
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
            <div class="">
               <div class="row">
                  <div class="col-sm-4">
                     <div class="form-group">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full form-control border" :value="old('name', @$userAddress->name)" required autofocus autocomplete="name"  placeholder="Name" />
                        <x-input-error class="mt-2 text-danger" :messages="$errors->get('name')" />
                     </div>
                  </div>
                  <div class="col-sm-4">
                     <div class="form-group">
                        <x-input-label for="mobile" :value="__('10 Digits Mobile Number')" />
                        <x-text-input id="mobile" name="mobile" type="number" class="mt-1 block w-full form-control border" :value="old('mobile', @$userAddress->mobile)" required autofocus autocomplete="mobile" placeholder="Mobile Number" />
                        <x-input-error class="mt-2 text-danger" :messages="$errors->get('mobile')" />
                     </div>
                  </div>
                  @if(!auth()->user()->email)
                  <div class="col-sm-4">
                     <div class="form-group">
                        <x-input-label for="email" :value="__('Enter valid email address')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full form-control border" :value="old('email', @auth()->user()->email)" required autofocus autocomplete="email" placeholder="Email Address" />
                        <x-input-error class="mt-2 text-danger" :messages="$errors->get('mobile')" />
                     </div>
                  </div>
                  @endif
                  <div class="col-sm-4">
                     <div class="form-group">
                        <x-input-label for="zipcode" :value="__('Pincode')" />
                        <x-text-input id="zipcode" name="zipcode" type="text" class="mt-1 block w-full form-control border zipcode" :value="old('zipcode', @$userAddress->zipcode)" required autofocus autocomplete="zipcode" placeholder="Pincode"/>
                        <x-input-error class="mt-2 text-danger" :messages="$errors->get('zipcode')" />
                        <!-- <small class="text-danger" id="pinError">Invalid Pincode or not Deliverable</small> -->
                     </div>
                  </div>
                  <div class="col-sm-4">
                     <div class="form-group">
                        <x-input-label for="city" :value="__('City')" />
                        <x-text-input id="city_id" name="city" type="text" class="mt-1 block w-full form-control border" :value="old('city', @$userAddress->city)" required autofocus autocomplete="city" disabled/>
                     </div>
                  </div>
                  <div class="col-sm-4">
                     <div class="form-group">
                        <x-input-label for="state" :value="__('State')" />
                        <x-text-input id="state_id" name="state" type="text" class="mt-1 block w-full form-control border" :value="old('state', @$userAddress->state)" required autofocus autocomplete="state" disabled/>
                     </div>
                  </div>
                  <div class="col-sm-12">
                     <div class="form-group">
                        <x-input-label for="address" :value="__('Enter Complete Address')" />
                        <textarea rows="3" id="address" name="address" class="mt-1 block w-full form-control shadow-none border" required autofocus autocomplete="address" placeholder="Complete Address">{{ old('address', @$userAddress->address) }}</textarea>
                        <x-input-error class="mt-2 text-danger" :messages="$errors->get('address')" />
                     </div>
                  </div>
               </div>
               <div class="mb-2">
                  <label>This is my</label>
               </div>
               <div class="btn-group btn-group-toggle mb-2 border" data-toggle="buttons">
                  @foreach($addressTypes??'' as $type)
                  <label class="btn btn-light @if(@$userAddress->type == $type) bg-info text-white @endif">
                  <input type="radio" name="type" id="type" value="{{ $type }}" {{ @$userAddress->type == $type ? 'checked' : '' }} autocomplete="off"> {{ $type }} </label>
                  @endforeach
               </div>
               <div class="flex items-center gap-4">
                  <x-primary-button style="background: black;">{{ __('Save') }}</x-primary-button>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
<div class="col-md-12 col-lg-12 py-2">
   <div class="card p-0">
      <div class="card-header">
         <div class=""><b>Addresses List</b></div>
      </div>
      <div class="card-body p-0">
         <div class="address_booklist_bxxx">
            <ul>
               @if($user->addresses->count()>0)
               @foreach($user->addresses as $address)
               <!--looop--->
               <li class="selected">
                  <label>
                     <span>{{ $address['name']??'' }} <font>{{ $address->type??'' }}</font></span><br>
                     <span>{{ $address->country->code??'' }} {{ $address['mobile']??'' }}</span>
                     <div class="px-2 py-2">{{ $address['address']??'' }}, {{ $address['city']->name??'' }}, {{ $address['state']->name??'' }} <br>
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
                        {{-- @can('user-address-delete')
                        <div class="col-6 p_lr_8 pipline">
                           <form method="POST" action="{{ route('userAddresses.destroy', $address) }}" class="text-center">
                              @csrf
                              @method('DELETE')
                              <button class="btn btn-block removeCartItem btn-light" type="submit"><i class="fa fa-trash"></i> <b>REMOVE</b></button>
                           </form>
                        </div>
                        @endcan --}}
                     </div>
                  </div>
               </li>
               <!--looop end--->
               @endforeach
               @endif
            </ul>
         </div>
      </div>
   </div>
</div>