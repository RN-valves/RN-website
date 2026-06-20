@php
$newArriwals = App\Models\Product::where(['new_arrival'=>1, 'status'=>'Active', 'is_visible_website'=>1])->inRandomOrder()->limit(8)->get();
@endphp
@if($newArriwals->count()>0)
<style>
/* ===== NEW ARRIVALS SECTION ===== */
.na-section {
    padding: 80px 0 90px;
    background: #fafafa;
}
.na-container {
    max-width: 1800px; /* Maximized for full desktop space */
    margin: 0 auto;
    padding: 0 40px;
}
/* Header */
.na-header {
    text-align: center;
    margin-bottom: 50px;
}
.na-eyebrow {
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 3.5px;
    text-transform: uppercase;
    color: #00a0e3;
    margin-bottom: 12px;
}
.na-title {
    font-size: 2.6rem;
    font-weight: 800;
    color: #111;
    letter-spacing: -0.5px;
    margin: 0 0 16px;
}
.na-subtitle {
    font-size: 0.95rem;
    color: #777;
    max-width: 800px;
    margin: 0 auto;
    line-height: 1.7;
}

/* Slider */
.na-slider-outer { position: relative; }
.na-track {
    display: flex;
    gap: 40px; /* Spacious gaps for minimal look */
    overflow-x: auto;
    scroll-behavior: smooth;
    scrollbar-width: none;
    -ms-overflow-style: none;
    padding-bottom: 25px; /* shadow room */
}
.na-track::-webkit-scrollbar { display: none; }

/* Product Card - Ultra Minimal */
.na-card {
    flex: 0 0 calc(25% - 30px); /* 4 elegant floating cards */
    min-width: 300px;
    background: transparent; /* No background */
    border: none; /* No border */
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform 0.4s ease;
    text-decoration: none;
}

.na-card:hover {
    transform: translateY(-5px);
}

/* Image */
.na-img-wrap {
    position: relative;
    width: 100%;
    aspect-ratio: 1/1;
    background: #fff; /* Pure white floating box */
    padding: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.03); /* Extremely soft luxury shadow */
    transition: box-shadow 0.4s ease;
}
.na-card:hover .na-img-wrap {
    box-shadow: 0 15px 40px rgba(0,0,0,0.08);
}
.na-img-wrap img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    transition: transform 0.6s cubic-bezier(0.2, 0.8, 0.2, 1);
}
.na-card:hover .na-img-wrap img { transform: scale(1.08); }

.na-badge {
    position: absolute;
    top: 14px; left: 14px;
    background: #000;
    color: #fff;
    font-size: 0.6rem;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
    padding: 6px 14px;
    z-index: 2;
}

/* Content */
.na-body {
    padding: 30px 10px 10px 10px;
    flex: 1;
    display: flex;
    flex-direction: column;
    text-align: center;
}
.na-cat {
    font-size: 0.75rem;
    color: #888;
    text-transform: uppercase;
    letter-spacing: 3px;
    margin-bottom: 12px;
    font-weight: 500;
}
.na-name {
    font-size: 1.25rem;
    font-weight: 400; /* Thinner, ultra-premium text */
    color: #111;
    line-height: 1.5;
    margin: 0 0 16px;
}

/* Price & Button area */
.na-footer {
    margin-top: auto;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 16px;
}
.na-price {
    font-size: 1.3rem; 
    font-weight: 600;
    color: #000;
    display: flex;
    align-items: flex-start;
    justify-content: center;
    letter-spacing: 1px;
}
.na-price span {
    font-size: 0.9rem;
    margin-top: 3px;
    margin-right: 4px;
    color: #666;
    font-weight: 400;
}

/* Attributes / Affiliate Links */
.na-links {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 14px;
    min-height: 24px;
}
.na-links img { height: 24px; opacity: 0.8; transition: opacity 0.2s; }
.na-links a:hover img { opacity: 1; }

.na-specs {
    display: flex;
    justify-content: center;
    gap: 12px;
    margin-top: -4px;
    margin-bottom: 24px;
    font-size: 0.8rem;
    color: #888;
    letter-spacing: 0.5px;
}
.na-specs span {
    border-right: 1px solid #ddd;
    padding-right: 12px;
}
.na-specs span:last-child {
    border-right: none;
    padding-right: 0;
}
.na-specs strong { color: #333; font-weight: 500; }

/* Nav - Ultra Modern */
.na-nav {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
    margin-top: 50px;
}
.na-arrow {
    width: 44px; height: 44px;
    border-radius: 50%;
    border: 1px solid #e0e0e0; /* subtle border like reference */
    background: transparent;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.3s ease;
}
.na-arrow:hover { background: #f9f9f9; border-color: #d0d0d0; }
.na-arrow svg { stroke: #111; transition: stroke 0.3s; stroke-width: 1.5; width: 16px; height: 16px; }

.na-dots { display: flex; gap: 8px; align-items: center; margin: 0 10px; }
.na-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: #d4d4d4;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
}
.na-dot.active {
    width: 22px; /* Pill shaped active dot */
    height: 6px;
    border-radius: 4px;
    background: #111;
}

/* responsive */
@media (max-width: 1500px) { .na-card { flex: 0 0 calc(33.333% - 27px); } }
@media (max-width: 1024px) { .na-card { flex: 0 0 calc(50% - 20px); } }
@media (max-width: 620px)  {
    .na-card { flex: 0 0 85%; }
    .na-title { font-size: 2rem; }
    .na-container { padding: 0 15px; }
}
</style>

<div class="na-section">
    <div class="na-container">
        <!-- Header -->
        <div class="na-header">
            <div class="na-eyebrow">Discover Excellence</div>
            <h2 class="na-title">New Arrivals</h2>
            <p class="na-subtitle">Check out our new features designed to improve your bathroom's elegance and functionality. Our range includes innovative taps, beautiful showers, durable PTMT taps and high quality CP accessories.</p>
        </div>

        <!-- Slider -->
        <div class="na-slider-outer">
            <div class="na-track" id="naTrack">
                @foreach($newArriwals as $product)
                <a href="{{ route('productList.view', [$product->category->url_key, $product->subcategory->url_key, $product->url_key]) }}" class="na-card">
                    
                    <div class="na-img-wrap">
                        <span class="na-badge">New</span>
                        <img src="{{ url($product->image??'') }}" alt="{{$product->title??''}}" loading="lazy">
                    </div>

                    <div class="na-body">
                        <div class="na-cat">{{$product->category->name??''}} • {{$product->subcategory->name??''}}</div>
                        <h3 class="na-name">{{$product->name??''}}</h3>
                        
                        <div class="na-specs">
                            @if(!empty($product->article))<span>Code: <strong>{{$product->article}}</strong></span>@endif
                            @if(!empty($product->size))<span>• Size: <strong>{{$product->size}}</strong></span>@endif
                        </div>

                        <div class="na-footer">
                            <div class="na-price"><span>₹</span>{{$product->in_mrp??0}}</div>
                            
                            <div class="na-links">
                                @if(!empty($product->productAttribute->flipkart_link))
                                <object><a href="{{ url($product->productAttribute->flipkart_link) }}" target="_blank"><img src="icons/flipkart.png" alt="Flipkart"></a></object>
                                @endif
                                @if(!empty($product->productAttribute->amazon_link))
                                <object><a href="{{ url($product->productAttribute->amazon_link) }}" target="_blank"><img src="icons/amazon.png" alt="Amazon"></a></object>
                                @endif
                            </div>
                        </div>

                    </div>

                </a>
                @endforeach
            </div>
        </div>

        <!-- Nav -->
        <div class="na-nav">
            <button class="na-arrow" id="naPrev" aria-label="Previous">
                <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <div class="na-dots" id="naDots"></div>
            <button class="na-arrow" id="naNext" aria-label="Next">
                <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
        </div>

    </div>
</div>

<script>
(function() {
    var track = document.getElementById('naTrack');
    var dotsC = document.getElementById('naDots');
    if (!track) return;

    var cards   = Array.from(track.querySelectorAll('.na-card'));
    var total   = cards.length;
    var cur     = 0;
    var animating = false;

    var autoPlayTimer;

    function visCount() {
        var w = track.parentElement.offsetWidth;
        if (w < 620) return 1;
        if (w < 1024) return 2;
        if (w < 1500) return 3;
        return 4; // desktop shows 4 minimal cards
    }

    /* Build dots */
    var maxSlide = Math.max(0, total - visCount());
    for (var i = 0; i <= maxSlide; i++) {
        (function(idx){
            var d = document.createElement('div');
            d.className = 'na-dot' + (idx === 0 ? ' active' : '');
            d.addEventListener('click', function(){ goTo(idx); });
            dotsC.appendChild(d);
        })(i);
    }

    function updateDots() {
        var dots = dotsC.querySelectorAll('.na-dot');
        dots.forEach(function(d, i){ d.classList.toggle('active', i === cur); });
    }

    function goTo(idx) {
        if (animating) return;
        var vis = visCount();
        var max = Math.max(0, total - vis);
        cur = Math.min(Math.max(idx, 0), max);

        var style   = window.getComputedStyle(track);
        var gap     = parseFloat(style.gap) || 40;
        var cardW   = cards[0].offsetWidth + gap;
        var target  = cur * cardW;
        
        animating = true;
        var start    = track.scrollLeft;
        var distance = target - start;
        var duration = 250; /* Super fast and snappy scroll duration */
        var startTime = null;

        function ease(t){ return t < .5 ? 2*t*t : -1+(4-2*t)*t; }
        function step(ts) {
            if (!startTime) startTime = ts;
            var prog = Math.min((ts - startTime) / duration, 1);
            track.scrollLeft = start + distance * ease(prog);
            if (prog < 1) { requestAnimationFrame(step); }
            else { animating = false; }
        }
        requestAnimationFrame(step);
        updateDots();
    }

    document.getElementById('naPrev').addEventListener('click', function(){ 
        goTo(cur - 1); 
        resetAutoPlay();
    });
    document.getElementById('naNext').addEventListener('click', function(){ 
        goTo(cur + 1); 
        resetAutoPlay();
    });

    /* --- Auto Scroll Logic --- */
    function startAutoPlay() {
        autoPlayTimer = setInterval(function() {
            var vis = visCount();
            var max = Math.max(0, total - vis);
            if (cur >= max) {
                goTo(0); // Loop back to start smoothly
            } else {
                goTo(cur + 1);
            }
        }, 3000); // scrolls faster every 3 seconds
    }

    function resetAutoPlay() {
        clearInterval(autoPlayTimer);
        startAutoPlay();
    }

    // Pause auto-play when hovering over the slider track
    track.addEventListener('mouseenter', function() { clearInterval(autoPlayTimer); });
    track.addEventListener('mouseleave', function() { startAutoPlay(); });

    // Initialize
    startAutoPlay();

})();
</script>
@endif
<style type="text/css">
   .grid-list-column-item{width: 100% !important;}
   .theiaStickySidebar .nt_bg_lz {background-size: contain  !important; border: 1px solid #ddd !important;}
   .pswp__img{height: auto !important; margin-top: 50px;}
   .pswp__button--share{display: none !important;}
   .theiaStickySidebar .padding-top__127_66 { padding-top: 115.66%;}
   .shipping-product {
   display: flex;
   align-items: center;
   padding: 8px 15px;
   background: #f9f9f9;
   font-size: 13px;
   margin-bottom: 10px; border-radius: 3px;
   }
   .shipping-product span {
   color: #000;
   margin-left: 10px;
   font-weight: 800;
   }
   .shipping-product p {
   padding-right: 10px;
   margin-left: 5px; margin-bottom: 0px;
   }
   .quantity .tc a,  .quantity .tc button { top: 1px !important;}
   .quantity input.input-text[type="number"] { height: 35px !important;}
   .header_shadow{box-shadow: none !important;}
   @import url(https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css);
   fieldset, label { margin: 0; padding: 0; }
   h1 { font-size: 1.5em; margin: 10px; }
   /****** Style Star Rating Widget *****/
   .rating { 
   border: none;
   float: left;
   }
   .rating > input { display: none; } 
   .rating > label:before { 
   margin: 5px;
   font-size: 1.25em;
   font-family: 'Font Awesome 5 Free';
   display: inline-block;
   content: "\f005";
   }
   .rating > .half:before { 
   content: "\f089";
   position: absolute;
   }
   .rating > label { 
   color: #ddd; 
   float: right; 
   }
   /***** CSS Magic to Highlight Stars on Hover *****/
   .rating > input:checked ~ label, /* show gold star when clicked */
   .rating:not(:checked) > label:hover, /* hover current star */
   .rating:not(:checked) > label:hover ~ label { color: #FFD700;  } /* hover previous stars in list */
   .rating > input:checked + label:hover, /* hover current star when changing rating */
   .rating > input:checked ~ label:hover,
   .rating > label:hover ~ input:checked ~ label, /* lighten current selection */
   .rating > input:checked ~ label:hover ~ label { color: #FFED85;  }  
   .breadcrumb-area { padding: 50px 0 50px 0 !important;}
   .breadcrumb-area.style-03 .breadcrumb-content{padding: 10px 25px 10px 25px !important;}
</style>