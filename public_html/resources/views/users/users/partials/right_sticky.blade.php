<?php 
   $url = url()->full(); 
   $types = App\Models\Enquiry::enquiryTypes();
   ?>
<!--help popup-->
<div class="modal fade enquiryeform" id="need_help_form" tabindex="-1" role="dialog" style="z-index:4999" aria-hidden="true" data-backdrop="false">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Need a help</h5>
            <button type="button" class="close" id="btn_enquiry_close" data-dismiss="modal" aria-label="Close"> 
            <span aria-hidden="true">×</span> </button>
         </div>
         <div id="loadbody" class="modal-body">
            <div class=helpenqform>
               <div class="call_div">
                  <h4>TOLL FREE</h4>
                  <a href="tel:{{ frontPage()->mobile??'' }}"><i class="icon flaticon-phone-call"></i>{{ frontPage()->mobile??'' }}</a>
               </div>
               <div class="mail_div">
                  <h4>EMAIL US</h4>
                  <a href="mailto:{{ frontPage()->email??'' }}"><i class="icon flaticon-email"></i> {{ frontPage()->email??'' }}</a>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!--help popup-->
<div class="modal fade enquiryeform" id="leadform__enquiry" tabindex="-1" role="dialog" style="z-index: 4999;" aria-hidden="true" data-backdrop="false">
   <div class="modal-dialog custom_modal_popup">
      <div class=modal-content>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden=true>&times;</span>
         </button>
         <div id="loadbody" class="modal-body">
            <form id="popup_form" method="POST" autocomplete="off">
               @csrf
               <input type="hidden" name="page_url" value="{{ $url }}">
               <div class="register-page lead-page">
                  <div class="contioner">
                     <div class="fieldset">
                        <div class="fieldset">
                           <div class="visit-type">
                              <div class="popup_title">Call Back Request: Purchase Assistance and Support</div>
                           </div>
                           <div class="lead-form-details-New">
                              <div class="form-group">
                                 <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name"placeholder="Name" value="{{old('name')}}">
                              </div>
                              <div class="form-group">
                                 <input class="form-control @error('mobile') is-invalid @enderror" type="tel" id="mobile" name="mobile" placeholder="Contact Number" value="{{old('mobile')}}">
                              </div>
                              <div class="form-group">
                                 <input class="form-control @error('email') is-invalid @enderror" type="text" id="email" name="email"placeholder="Email id" value="{{old('email')}}">
                              </div>
                              <div class="form-group">
                                 <input class="form-control @error('zipcode') is-invalid @enderror" type="number" id="zipcode" name="zipcode" placeholder="zipcode" value="{{old('zipcode')}}">
                              </div>
                              <div class="form-group">
                                 <select class="form-control @error('enquiry_type') is-invalid @enderror" name="enquiry_type">
                                    <option value="">Select Profession</option>
                                    @foreach($types??'' as $type)
                                    <option value="{{ $type }}" @selected(old('enquiry_type'))>{{ $type }}</option>
                                    @endforeach
                                 </select>
                              </div>
                              <div class="form-group">
                                 <textarea class="form-control @error('purpose') is-invalid @enderror" id="purpose" name="purpose" placeholder="purpose" style="height: 100px !important;">{{old('purpose')}}</textarea>
                              </div>
                              <button type="submit" id="popup_form_btn" class="btn btn-dark popup_form_disabled">Submit</button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<style type="text/css">
   body.modal-open:before {
   position: fixed;
   top: 0;
   left: 0;
   width: 100%;
   height: 100%;
   background: rgb(0 0 0 / 50%);
   content: "";
   z-index: 1050;
   }
   .error{
   color: red;
   font-size: 13px;
   }
</style>