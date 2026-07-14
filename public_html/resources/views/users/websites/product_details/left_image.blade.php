<div class="col-lg-6">
   <!--  Desktop Slider Start --> 
   <div class="prod_gallery gallery_sticky" id="content">
      <!--Show Default Image--->
      <div class="prod_gallery mainphoto_showcase">
         <a href="{{ url($getSingleProduct['image']??'') }}" class="jqzoom" rel='gal1'  title="asr" >
         <img src="{{ url($getSingleProduct['image']??'') }}" class="prothumbsize"  title="{{ $getSingleProduct['title']??'' }}" alt="{{ $getSingleProduct['title']??'' }}">
         </a> 
      </div>
      <!--Show Default Image--->
      <!--Show slider start Image--->
      <div class="div_thumb" >
         <ul id="thumblist" class="prod_gallery" >
            <!---set default img--->
            <li>
               <a class="zoomThumbActive" href='javascript:void(0);' rel="{gallery: 'gal1', smallimage: '{{ url($getSingleProduct['image']??'') }}',largeimage: '{{ url($getSingleProduct['image']??'') }}'}">
               <img src="{{ url($getSingleProduct['image']??'') }}" class="thmbs" alt="{{ $getSingleProduct['title']??'' }}">
               </a>
            </li>
            @if(@$getSingleProduct['is_isicertified'])
           <li>
               <a href='javascript:void(0);' rel="{gallery: 'gal1', smallimage: '{{isiImage()}}',largeimage: '{{isiImage()}}'}">
               <img src="{{isiImage()}}" class="thmbs" alt="{{ $getSingleProduct['title']??'' }}">
               </a> 
            </li> 
            @endif
            <!--set default img--->
            <!--thumb loop li repeat--->
            @if($getSingleProduct['productImages']->count()>0)
            @foreach($getSingleProduct['productImages']??'' as $productImage)
            @if(!empty($productImage['image']))
            <li>
               <a href='javascript:void(0);' rel="{gallery: 'gal1', smallimage: '{{ url($productImage['image']) }}',largeimage: '{{ url($productImage['image']) }}'}">
               <img src="{{ url($productImage['image']) }}"  class="thmbs" alt="{{ $getSingleProduct['title']??'' }}" onerror="this.closest('li')?.remove()">
               </a>
            </li>
            @endif
            @endforeach
            @endif
            <!--thumb loop--->
         </ul>
      </div>
   </div>
   <!--  Desktop Slider END --> 
   <!--MOBILE SLIDER START--->   
   <div class="mobile_slider">
      <!---img Default---->
      <div class="pro_img_bxxbx">
         <img src="{{ $getSingleProduct['image']??'' }}" alt="{{ $getSingleProduct['title']??'' }}" title="{{ $getSingleProduct['title']??'' }}"> 
      </div>
      <!---img Default---->
      @if($getSingleProduct['productImages']->count()>0)
      @foreach($getSingleProduct['productImages']??'' as $productImage)
      @if(!empty($productImage['image']))
      <!---img loop---->
      <div class="pro_img_bxxbx">
         <img src="{{ url($productImage['image']) }}" alt="{{ $getSingleProduct['title']??'' }}" onerror="this.closest('.pro_img_bxxbx')?.remove()"> 
      </div>
      <!---img loop---->
      @endif
      @endforeach
      @endif
   </div>
   <!--MOBILE SLIDER END--->  
</div>