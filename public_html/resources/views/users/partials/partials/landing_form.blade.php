<div style="background:#00a0e3;">
   <div class="row align-items-center">
      <div class="img_block col-lg-6 p-0">
         <img class="w-100" src="{{url('users/images/25_years.jpg')}}" alt="RN Valves & Faucets" title="RN Valves & Faucets"/>
      </div>
      <div class="col-lg-6">
         <div class="sign-in-area form_bxxxx" style="border-right:0px !important ;">
            <div class="landingbox">
               <h2 class="frm_h2">Looking for Bathroom Solutions? Let’s Talk – Exclusive Offers Inside!</h2>
               <p class="frmtexxt">Avail the exclusive offers and much more.</p>
               <form action="{{ route('contactUs') }}" method="POST" id="" class="contactUSForm">
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
                  @if(Session::has('success'))
                  <div class="alert alert-success">
                     {{Session::get('success')}}
                  </div>
                  @endif
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="input-group padding-top-20">
                           <div class="input-group-prepend">
                              <span class="input-group-text">
                              <i class="icon flaticon-man-user"></i>
                              </span>
                           </div>
                           <input type="text" class="form-control @error('name') is-invalid @enderror" required name="name" id="name" placeholder="Full Name" value="{{old('name')}}">
                           <div class="col-lg-12">
                              <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('name')" />
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="input-group padding-top-20">
                           <div class="input-group-prepend">
                              <span class="input-group-text">
                              <i class="icon fas fa-building"></i>
                              </span>
                           </div>
                           <input type="text" class="form-control @error('company_name') is-invalid @enderror" required name="company_name" id="company_name" placeholder="Full Company Name" value="{{old('company_name')}}">
                           <div class="col-lg-12">
                              <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('company_name')" />
                           </div>
                        </div>
                     </div>
                     <!--// Email-->
                     <div class="col-lg-6">
                        <div class="input-group padding-top-20">
                           <div class="input-group-prepend">
                              <span class="input-group-text">
                              <i class="icon flaticon-black-back-closed-envelope-shape"></i>
                              </span>
                           </div>
                           <input type="email" class="form-control @error('email') is-invalid @enderror" required name="email" value="{{old('email')}}" placeholder="Email Address">
                           <div class="col-lg-12">
                              <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('email')" />
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="input-group padding-top-20">
                           <div class="input-group-prepend">
                              <span class="input-group-text">
                              <i class="icon flaticon-call-answer"></i>
                              </span>
                           </div>
                           <input type="text" class="form-control @error('mobile') is-invalid @enderror" required name="mobile" value="{{old('mobile')}}" placeholder="Contact Number">
                           <div class="col-lg-12">
                              <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('mobile')" />
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="input-group padding-top-20">
                           <div class="input-group-prepend">
                              <span class="input-group-text">
                              <i class="fas fa-handshake"></i>
                              </span>
                           </div>
                           <select class="form-control @error('enquiry_type') is-invalid @enderror" required name="enquiry_type">
                              <option value="">Select Profession</option>
                              @foreach($types??'' as $type)
                              <option value="{{ $type }}" @selected(old('enquiry_type'))>{{ $type }}</option>
                              @endforeach
                           </select>
                           <div class="col-lg-12">
                              <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('enquiry_type')" />
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="input-group padding-top-20">
                           <div class="input-group-prepend">
                              <span class="input-group-text">
                              <i class="icon flaticon-placeholder"></i>
                              </span>
                           </div>
                           <input type="number" name="zipcode" id="zipcode" class="form-control @error('zipcode') is-invalid @enderror zipcode" required value="{{ old('zipcode') }}" placeholder="zipcode" maxlength="6" autocomplete="off">
                           <div class="col-lg-12">
                              <span class="text-danger pinError">Invalid Pincode or not Deliverable</span>
                              <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('zipcode')" />
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="input-group padding-top-20">
                     <div class="input-group-prepend">
                        <span class="input-group-text">
                        <i class="icon flaticon-placeholder"></i>
                        </span>
                     </div>
                     <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" required value="{{old('address')}}" placeholder="address">
                     <div class="col-lg-12">
                        <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('address')" />
                     </div>
                  </div>
                  <div class="input-group padding-top-20">
                     <div class="input-group-prepend">
                        <span class="input-group-text" style="align-items: initial; padding-top: 12px;">
                        <i class="icon flaticon-email"></i>
                        </span>
                     </div>
                     <textarea class="form-control @error('purpose') is-invalid @enderror" required name="purpose" style="height: 100px;" placeholder="purpose" >
                        {{old('purpose')}}
                     </textarea>
                     <div class="col-lg-12">
                        <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('purpose')" />
                     </div>
                  @if ($errors->has('g-recaptcha-response'))
                  <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                  @endif
                  </div>
                  <div class="main-btn-wrap text-left padding-top-40">
                     <button type="submit" class="btn btn-dark">Send Enquiry</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>