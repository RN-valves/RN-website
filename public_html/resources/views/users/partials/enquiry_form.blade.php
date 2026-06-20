<div class="sign cstm_page_padding" style="background: #00000024;position: relative!important;">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12 col-lg-12">
            <div class="">
               <div class="card-body">
                  <div class="sign-in-area form_bxxxx">
                     <div class="section-title">
                        <h1 class="heading-02 text-uppercase text-center mb-2">Request Call Back</h1>
                     </div>
                     <div class="common-section-content">
                        <div class="paragraph">
                           <p class="text-center mb-2">Want to learn more about  <b>RN Valves & Faucets</b>® or need assistance with our products? Fill out the form below, and our team will respond promptly!</p>
                        </div>
                     </div>
                     <form method="post" action="{{ route('contactUs') }}" id="contactUSForm" style="margin-top: 20px!important;;">
                        @csrf
                        {{-- @if (count($errors) > 0)
                        <div class="alert alert-danger">
                           <strong>Whoops! </strong> There were some problems with your input.<br><br>
                           <ul>
                              @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                              @endforeach
                           </ul>
                        </div>
                        @endif --}}
                        @if ($errors->has('g-recaptcha-response'))
                        <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                        @endif
                        <input type="hidden" name="company_name" value="" id="company_name">
                        <div class="">
                           <div class="row">
                              <div class="col-sm-4">
                                 <div class="form-group">
                                    <x-input-label for="name" :value="__('Name')" />
                                    <x-text-input id="get_name" name="name" type="text" class="mt-1 block w-full form-control border" :value="old('name')" required autofocus autocomplete="name"  placeholder="Name" />
                                    <x-input-error class="mt-2 text-danger" :messages="$errors->get('name')" />
                                 </div>
                              </div>
                              <div class="col-sm-4">
                                 <div class="form-group">
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full form-control border" :value="old('email')" required autofocus autocomplete="email"  placeholder="email" />
                                    <x-input-error class="mt-2 text-danger" :messages="$errors->get('email')" />
                                 </div>
                              </div>
                              <div class="col-sm-4">
                                 <div class="form-group">
                                    <x-input-label for="mobile" :value="__('10 Digits Mobile Number')" />
                                    <x-text-input id="mobile" name="mobile" type="number" class="mt-1 block w-full form-control border" :value="old('mobile')" required autofocus autocomplete="mobile" placeholder="Mobile Number" />
                                    <x-input-error class="mt-2 text-danger" :messages="$errors->get('mobile')" />
                                 </div>
                              </div>
                              <div class="col-sm-4">
                                 <div class="form-group">
                                    <x-input-label for="enquiry_type" :value="__('Select Profession')" />
                                    <select class="form-control mt-1" name="enquiry_type" id="enquiry_type">
                                       <option value="">Select</option>
                                       @php
                                       $professions = App\Models\Enquiry::enquiryTypes();
                                       @endphp
                                       @foreach($professions??'' as $profession)
                                       <option value="{{ $profession }}" @selected(old('enquiry_type')==$profession)>{{ $profession }}</option>
                                       @endforeach
                                    </select>
                                    <x-input-error class="mt-2 text-danger" :messages="$errors->get('enquiry_type')" />
                                 </div>
                              </div>
                              <div class="col-sm-4">
                                 <div class="form-group">
                                    <x-input-label for="zipcode" :value="__('Pincode')" />
                                    <x-text-input id="zipcode" name="zipcode" type="text" class="mt-1 block w-full form-control border zipcode" :value="old('zipcode')" required autofocus autocomplete="zipcode" placeholder="Pincode"/>
                                    <x-input-error class="mt-2 text-danger" :messages="$errors->get('zipcode')" />
                                    <small class="text-danger pinError" id="pinError">Invalid Pincode or not Deliverable</small>
                                 </div>
                              </div>
                              <div class="col-sm-4">
                                 <div class="form-group">
                                    <x-input-label for="address" :value="__('Locality/Address')" />
                                    <x-text-input name="address" type="text" class="mt-1 block w-full form-control border address" :value="old('address')" required autofocus autocomplete="address" placeholder="Address"/>
                                    <x-input-error class="mt-2 text-danger" :messages="$errors->get('address')" />
                                 </div>
                              </div>
                              <div class="col-sm-12">
                                 <div class="form-group">
                                    <x-input-label for="purpose" :value="__('Message')" />
                                    <textarea name="purpose" class="mt-1 block w-full form-control border purpose" style="height: 100px;" placeholder="Message" autocomplete="off">{{ old('purpose') }}</textarea>
                                    <x-input-error class="mt-2 text-danger" :messages="$errors->get('purpose')" />
                                 </div>
                              </div>
                              {{-- 
                              <div class="col-sm-4">
                                 <div class="form-group">
                                    <x-input-label for="city" :value="__('City')" />
                                    <x-text-input id="city_id" name="city" type="text" class="mt-1 block w-full form-control border" :value="old('city')" required autofocus autocomplete="city" disabled/>
                                 </div>
                              </div>
                              <div class="col-sm-4">
                                 <div class="form-group">
                                    <x-input-label for="state" :value="__('State')" />
                                    <x-text-input id="state_id" name="state" type="text" class="mt-1 block w-full form-control border" :value="old('state')" required autofocus autocomplete="state" disabled/>
                                 </div>
                              </div>
                              --}}
                           </div>
                           <div class="flex items-center gap-4">
                              <button class="btn btn-dark enquiryDisable"><b>SUBMIT REQUEST</b></button>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>