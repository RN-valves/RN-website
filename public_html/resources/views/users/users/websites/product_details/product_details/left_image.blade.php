<div class="col-lg-6">
   <!-- Desktop Slider Start --> 
   <div class="prod_gallery gallery_sticky" id="content">
      <!-- Show Default Image / Hover Zoom Container -->
      <div class="prod_gallery mainphoto_showcase" id="product_zoom_wrapper">
         <div class="product_zoom_container" id="product_zoom_box">
            <img src="{{ url($getSingleProduct['image']??'') }}" class="prothumbsize" id="main_product_zoom_img" title="{{ $getSingleProduct['title']??'' }}" alt="{{ $getSingleProduct['title']??'' }}">
            <div class="zoom-badge-hint"><i class="fa fa-search-plus"></i> Roll over image to zoom</div>
         </div>
      </div>
      <!-- Show Default Image --->

      <!-- Show Thumbnail Slider Start --->
      <div class="div_thumb">
         <ul id="thumblist" class="prod_gallery">
            <!--- Main image thumbnail --->
            <li>
               <a class="zoomThumbActive" href="javascript:void(0);" data-image="{{ url($getSingleProduct['image']??'') }}" rel="{gallery: 'gal1', smallimage: '{{ url($getSingleProduct['image']??'') }}',largeimage: '{{ url($getSingleProduct['image']??'') }}'}">
                  <img src="{{ url($getSingleProduct['image']??'') }}" class="thmbs" alt="{{ $getSingleProduct['title']??'' }}">
               </a>
            </li>
            @if(@$getSingleProduct['is_isicertified'])
            <li>
               <a href="javascript:void(0);" data-image="{{isiImage()}}" rel="{gallery: 'gal1', smallimage: '{{isiImage()}}',largeimage: '{{isiImage()}}'}">
                  <img src="{{isiImage()}}" class="thmbs" alt="{{ $getSingleProduct['title']??'' }}">
               </a> 
            </li> 
            @endif
            <!-- Extra gallery thumbs only — never repeat main image --->
            @if($getSingleProduct['productImages']->count()>0)
            @foreach($getSingleProduct['productImages']??'' as $productImage)
            @php
               $mainImage = normalizeProductImageUrl($getSingleProduct['image'] ?? '');
               $galleryImage = normalizeProductImageUrl($productImage['image'] ?? '');
            @endphp
            @if(!empty($productImage['image']) && $galleryImage !== '' && $galleryImage !== $mainImage)
            <li>
               <a href="javascript:void(0);" data-image="{{ url($productImage['image']) }}" rel="{gallery: 'gal1', smallimage: '{{ url($productImage['image']) }}',largeimage: '{{ url($productImage['image']) }}'}">
                  <img src="{{ url($productImage['image']) }}" class="thmbs" alt="{{ $getSingleProduct['title']??'' }}">
               </a>
            </li>
            @endif
            @endforeach
            @endif
            <!-- thumb loop --->
         </ul>
      </div>
   </div>
   <!-- Desktop Slider END --> 

   <!-- MOBILE SLIDER START --->   
   <div class="mobile_slider">
      <!--- img Default ---->
      <div class="pro_img_bxxbx">
         <img src="{{ $getSingleProduct['image']??'' }}" alt="{{ $getSingleProduct['title']??'' }}" title="{{ $getSingleProduct['title']??'' }}"> 
      </div>
      <!--- img Default ---->
      @if($getSingleProduct['productImages']->count()>0)
      @foreach($getSingleProduct['productImages']??'' as $productImage)
      @php
         $mainImage = normalizeProductImageUrl($getSingleProduct['image'] ?? '');
         $galleryImage = normalizeProductImageUrl($productImage['image'] ?? '');
      @endphp
      @if(!empty($productImage['image']) && $galleryImage !== '' && $galleryImage !== $mainImage)
      <!--- img loop ---->
      <div class="pro_img_bxxbx">
         <img src="{{ url($productImage['image']) }}" alt="{{ $getSingleProduct['title']??'' }}"> 
      </div>
      <!--- img loop ---->
      @endif
      @endforeach
      @endif
   </div>
   <!-- MOBILE SLIDER END --->  
</div>

<style>
/* Product Image Zoom Showcase */
.mainphoto_showcase {
   width: calc(100% - 100px) !important;
   margin-left: 100px !important;
   border: 1px solid #e2e8f0 !important;
   border-radius: 12px !important;
   background: #ffffff !important;
   text-align: center;
   display: flex !important;
   align-items: center !important;
   justify-content: center !important;
   overflow: hidden !important;
   position: relative !important;
   height: 498px !important;
   max-height: 498px !important;
   box-shadow: 0 4px 18px rgba(0, 0, 0, 0.04);
}

.product_zoom_container {
   width: 100%;
   height: 100%;
   display: flex;
   align-items: center;
   justify-content: center;
   overflow: hidden;
   position: relative;
   cursor: crosshair;
}

.product_zoom_container #main_product_zoom_img {
   max-width: 90% !important;
   max-height: 90% !important;
   width: auto !important;
   height: auto !important;
   object-fit: contain !important;
   object-position: center !important;
   display: block;
   margin: 0 auto;
   transform-origin: center center;
   transform: scale(1);
   transition: transform 0.25s ease-out, opacity 0.2s ease;
   pointer-events: none;
   user-select: none;
   -webkit-user-drag: none;
}

/* Zoomed state */
.product_zoom_container.is-zoomed #main_product_zoom_img {
   transform: scale(2.4);
   transition: none !important;
}

/* Subtle Zoom Badge / Hint */
.zoom-badge-hint {
   position: absolute;
   bottom: 12px;
   right: 12px;
   background: rgba(15, 23, 42, 0.75);
   backdrop-filter: blur(4px);
   color: #ffffff;
   font-size: 11px;
   font-weight: 600;
   padding: 5px 12px;
   border-radius: 20px;
   letter-spacing: 0.3px;
   pointer-events: none;
   transition: opacity 0.25s ease, transform 0.25s ease;
   display: flex;
   align-items: center;
   gap: 6px;
   z-index: 10;
}

.product_zoom_container.is-zoomed .zoom-badge-hint {
   opacity: 0;
   transform: translateY(6px);
}

/* Thumbnails list */
.div_thumb {
   width: 88px !important;
   position: absolute !important;
   left: 0px !important;
   top: 0px !important;
   max-height: 498px !important;
   overflow-y: auto !important;
   overflow-x: hidden !important;
   padding-right: 4px;
   scrollbar-width: thin;
   scrollbar-color: #cbd5e1 transparent;
}

.div_thumb::-webkit-scrollbar {
   width: 4px;
}
.div_thumb::-webkit-scrollbar-thumb {
   background: #cbd5e1;
   border-radius: 4px;
}

ul#thumblist {
   display: flex !important;
   flex-direction: column !important;
   gap: 10px !important;
   margin: 0 !important;
   padding: 0 !important;
   list-style: none !important;
}

ul#thumblist li {
   margin: 0 !important;
   float: none !important;
}

ul#thumblist li a {
   display: block !important;
   border: 2px solid #e2e8f0 !important;
   border-radius: 8px !important;
   padding: 4px !important;
   background: #ffffff !important;
   cursor: pointer !important;
   transition: all 0.2s ease !important;
   overflow: hidden !important;
}

ul#thumblist li a:hover {
   border-color: #00a0e3 !important;
   transform: translateY(-1px);
}

ul#thumblist li a.zoomThumbActive {
   border-color: #00a0e3 !important;
   box-shadow: 0 0 0 2px rgba(0, 160, 227, 0.25) !important;
}

ul#thumblist li a img.thmbs {
   width: 100% !important;
   height: 64px !important;
   object-fit: contain !important;
   display: block !important;
}

@media only screen and (max-width: 991px) {
   .mainphoto_showcase {
      display: none !important;
   }
   .div_thumb {
      display: none !important;
   }
}
</style>

<script>
(function() {
   function initProductZoom() {
      var zoomBox = document.getElementById('product_zoom_box');
      var zoomImg = document.getElementById('main_product_zoom_img');
      if (!zoomBox || !zoomImg) return;

      var isHovering = false;
      var rafId = null;

      function updateZoomPosition(e) {
         if (!isHovering) return;
         var rect = zoomBox.getBoundingClientRect();
         if (rect.width === 0 || rect.height === 0) return;

         var x = ((e.clientX - rect.left) / rect.width) * 100;
         var y = ((e.clientY - rect.top) / rect.height) * 100;
         var clampedX = Math.max(0, Math.min(100, x));
         var clampedY = Math.max(0, Math.min(100, y));

         if (rafId) cancelAnimationFrame(rafId);
         rafId = requestAnimationFrame(function() {
            zoomImg.style.transformOrigin = clampedX + '% ' + clampedY + '%';
         });
      }

      function onMouseEnter(e) {
         isHovering = true;
         zoomBox.classList.add('is-zoomed');
         zoomImg.style.transform = 'scale(2.4)';
         updateZoomPosition(e);
      }

      function onMouseLeave() {
         isHovering = false;
         zoomBox.classList.remove('is-zoomed');
         zoomImg.style.transition = 'transform 0.3s cubic-bezier(0.25, 1, 0.5, 1), transform-origin 0.3s cubic-bezier(0.25, 1, 0.5, 1)';
         zoomImg.style.transform = 'scale(1)';
         zoomImg.style.transformOrigin = '50% 50%';
         if (rafId) cancelAnimationFrame(rafId);
      }

      zoomBox.addEventListener('mouseenter', onMouseEnter);
      zoomBox.addEventListener('mousemove', updateZoomPosition);
      zoomBox.addEventListener('mouseleave', onMouseLeave);

      // Thumbnail switching
      var thumbLinks = document.querySelectorAll('#thumblist li a');
      thumbLinks.forEach(function(link) {
         function activateThumb(e) {
            if (e.type === 'click') e.preventDefault();
            thumbLinks.forEach(function(l) { l.classList.remove('zoomThumbActive'); });
            link.classList.add('zoomThumbActive');

            var newSrc = link.getAttribute('data-image');
            if (!newSrc) {
               var img = link.querySelector('img');
               if (img) newSrc = img.getAttribute('src');
            }

            if (newSrc && zoomImg.getAttribute('src') !== newSrc) {
               zoomImg.style.opacity = '0.3';
               var tempImg = new Image();
               tempImg.onload = function() {
                  zoomImg.setAttribute('src', newSrc);
                  zoomImg.style.opacity = '1';
               };
               tempImg.onerror = function() {
                  zoomImg.setAttribute('src', newSrc);
                  zoomImg.style.opacity = '1';
               };
               tempImg.src = newSrc;
            }
         }

         link.addEventListener('click', activateThumb);
         link.addEventListener('mouseenter', activateThumb);
      });
   }

   if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', initProductZoom);
   } else {
      initProductZoom();
   }
})();
</script>
