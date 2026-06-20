@extends('users.master')
@section('seo_tags')
@endsection
@section('ccs_links')
<link rel="stylesheet" href="{{url('users/assets/css/custom.css')}}" type="text/css">
@endsection
@section('content')
<!--Page-->
<div class="cstm_page_section website-cart addressbxx">
   <div class="container-fluid">
      <div class="brdcrm_menu" style="margin-top: 5px !important;"><a href="{{route('welcome')}}"><i class="fas fa-chevron-left"></i>Back to Home </a></div>
      <div class="row">
         @include('users.websites.policies.menu')
         <div class="col-lg-8">
            <div class="blog-details-wrap">
               <!--Blog Details item-->
               <div class="blog-details-items">
                  <h1 class="acc_page_title">{{$data->title}}</h1>
                  <div class="blog_content_areaaa">
                     <!-- <h5>GOODS RETURN (G.R.) GUIDELINES</h5>
                     <p>Though we try our level best to ensure correct delivery as per your order but if in case of any discrepancy in the
                        goods received, you intent to return the same. Kindly inform your Sales Executive or CRM or and if they approved
                        in writing then arrange to return the same within a week or 15 days from invoicing which is ever earlier. 
                     </p>
                     <p>In case of return, due to any manufacturing defects, only the goods which have manufacturing defects will be
                        accepted after confirmation in writing, and it should be return within 90 days from the date of supply. The returned
                        goods can be replaced with the same article only.
                     </p>
                     <p>If any goods will return without confirmation in writing from the mail id “enquiry@rnvalves.com”, Company will be
                        compelled to debit 25% of net Goods Return amount(MRP should be charged, on the date of supply or the current
                        MRP, whichever is lower)
                     </p>
                     <p>As we deliver the goods freight paid, same is also expected from distributor, i.e. we should receive the Goods
                        Return freight paid, otherwise the freight will be debited to the Customer.
                        For clearance of account please do not forget to mention pertaining invoice no.
                        The items discontinued by the Company, broken sizes or any loose stock i.e. not in Company standard policy shall
                        not be accepted as Goods Return in any case.
                     </p>
                     <p><strong>All the necessary documents for returning the goods i:e</strong></p>
                     <ol>
                        <li>Debit note with properly mentioned Item code, Size, Quantity, MRP, Reason, and other necessary
                           requirements.
                        </li>
                        <li>Way bill (Road Permit)</li>
                        <li>Bilty</li>
                        <li>Other related documents / forms</li>
                     </ol>
                     <p>These documents should be duly filled, signed and checked by you. Hence the company M/s RN Faucets Pvt Ltd, will not be liable for any penalty that arises because of any discrepancies in the
                        documentation and same will be debited to your account. (It has been very important subject when the tax authority
                        have become extra strict for ensuring compliance in documents.)
                     </p>
                     <p>We request you to strictly adhere to above guidelines.
                        Kindly acknowledge the same.
                     </p> -->
                     {!! $data->description !!}
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection