@php
$latestPosts = App\Models\Blog::getBlogList()->take(15);
@endphp

@if($latestPosts->count() > 0)
<style>
/* ===== LATEST UPDATES ===== */
.lu2-section {
    padding: 70px 0 80px;
    background: #ffffff;
}
.lu2-container {
    max-width: 1700px; /* Increased to use much more free space */
    margin: 0 auto;
    padding: 0 40px;
}
/* Header */
.lu2-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 40px;
}
.lu2-label {
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 3.5px;
    text-transform: uppercase;
    color: #00a0e3;
    margin-bottom: 8px;
}
.lu2-heading {
    font-size: 2.2rem;
    font-weight: 800;
    color: #0f0f0f;
    letter-spacing: -0.5px;
    margin: 0 0 6px;
}
.lu2-sub {
    font-size: 0.92rem;
    color: #888;
    max-width: 480px;
    line-height: 1.7;
    margin: 0;
}
.lu2-view-all {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: #0f0f0f;
    text-decoration: none;
    border-bottom: 1.5px solid #0f0f0f;
    padding-bottom: 2px;
    white-space: nowrap;
    transition: color .25s, border-color .25s;
}
.lu2-view-all:hover { color: #00a0e3; border-color: #00a0e3; }

/* Slider wrapper */
.lu2-slider-wrap {
    position: relative;
}
.lu2-track {
    display: flex;
    gap: 22px;
    overflow: hidden;         /* hide overflow; JS handles scroll */
}

/* ===== CARD ===== */
.lu2-card {
    flex: 0 0 calc(20% - 17.6px); /* 5 cards visible on desktop */
    min-width: 260px;
    min-height: 480px; /* Added height */
    background: #fff;
    border-radius: 20px;
    border: 1px solid #f0f0f0;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    transition: transform .35s ease, box-shadow .35s ease;
    text-decoration: none;
    display: flex;
    flex-direction: column;
}
.lu2-card:hover {
    transform: translateY(-7px);
    box-shadow: 0 18px 40px rgba(0,0,0,0.11);
}

/* Image */
.lu2-img-wrap {
    position: relative;
    width: 100%;
    aspect-ratio: 4/3; /* Taller image */
    overflow: hidden;
    background: #f4f4f4;
}
.lu2-img-wrap img {
    width: 100%; height: 100%;
    object-fit: cover;
    display: block;
    transition: transform .45s ease;
}
.lu2-card:hover .lu2-img-wrap img { transform: scale(1.06); }
.lu2-cat-badge {
    position: absolute;
    top: 14px; left: 14px;
    background: #00a0e3;
    color: #fff;
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    padding: 5px 12px;
    border-radius: 30px;
}

/* Body */
.lu2-body {
    padding: 24px 24px 26px;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.lu2-meta {
    font-size: 0.75rem;
    color: #a0a0a0;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.lu2-meta i { color: #00a0e3; font-size: 0.7rem; }
.lu2-title {
    font-size: 1.05rem;
    font-weight: 800;
    color: #111;
    line-height: 1.45;
    margin: 0 0 12px;

    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.lu2-desc {
    font-size: 0.82rem;
    color: #777;
    line-height: 1.7;
    flex: 1;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.lu2-link {
    margin-top: 16px;
    font-size: 0.74rem;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: #00a0e3;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.lu2-link-arrow { transition: transform .2s; }
.lu2-card:hover .lu2-link-arrow { transform: translateX(4px); }

/* Nav */
.lu2-nav {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 12px;
    margin-top: 36px;
}
.lu2-btn {
    width: 44px; height: 44px;
    border-radius: 50%;
    border: 1.5px solid #e0e0e0;
    background: #fff;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    transition: background .25s, border-color .25s;
}
.lu2-btn:hover { background: #0f0f0f; border-color: #0f0f0f; }
.lu2-btn:hover svg { stroke: #fff; }
.lu2-btn svg { stroke: #444; transition: stroke .25s; }
.lu2-dots { display: flex; gap: 7px; align-items: center; }
.lu2-dot {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: #ddd;
    cursor: pointer;
    transition: background .25s, width .25s, border-radius .25s;
}
.lu2-dot.on { width: 24px; border-radius: 4px; background: #0f0f0f; }

/* responsive */
@media (max-width: 1500px) { .lu2-card { flex: 0 0 calc(25% - 16.5px); } }
@media (max-width: 1200px) { .lu2-card { flex: 0 0 calc(33.333% - 15px); } }
@media (max-width: 900px)  { .lu2-card { flex: 0 0 calc(50% - 11px); } }
@media (max-width: 620px)  {
    .lu2-card { flex: 0 0 85%; min-height: 420px; }
    .lu2-header { flex-direction: column; align-items: flex-start; gap: 14px; padding: 0 10px; }
    .lu2-heading { font-size: 1.6rem; }
    .lu2-container { padding: 0 15px; }
}
</style>

<section class="lu2-section">
    <div class="lu2-container">

        {{-- Header --}}
        <div class="lu2-header">
            <div>
                <div class="lu2-label">From the Blog</div>
                <h2 class="lu2-heading">Latest Updates</h2>
                <p class="lu2-sub">Over 24 years of trust, quality, and innovation in bathroom fittings.</p>
            </div>
            <a href="{{ route('blogs', ['url_key'=>'blogs']) }}" class="lu2-view-all">
                View All
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>

        {{-- Slider --}}
        <div class="lu2-slider-wrap">
            <div class="lu2-track" id="lu2Track">
                @foreach($latestPosts as $blog)
                <a href="{{ route('blogs', $blog->url_key) }}" class="lu2-card">
                    <div class="lu2-img-wrap">
                        <img src="{{ url($blog['image']) }}" alt="{{ $blog['title'] }}" loading="lazy">
                        @if($blog->category_name)
                        <span class="lu2-cat-badge">{{ $blog->category_name }}</span>
                        @endif
                    </div>
                    <div class="lu2-body">
                        <div class="lu2-meta">
                            <i class="far fa-clock"></i>
                            {{ $blog->published_at->format('d M Y') }}
                        </div>
                        <div class="lu2-title">{{ $blog->name }}</div>
                        <div class="lu2-desc">{{ substr($blog->short_description, 0, 150) }}..</div>
                        <span class="lu2-link">
                            Read More
                            <svg class="lu2-link-arrow" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#00a0e3" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        {{-- Nav --}}
        <div class="lu2-nav">
            <button class="lu2-btn" id="lu2Prev" aria-label="Prev">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <div class="lu2-dots" id="lu2Dots"></div>
            <button class="lu2-btn" id="lu2Next" aria-label="Next">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
        </div>

    </div>
</section>

<script>
(function () {
    var track = document.getElementById('lu2Track');
    var dotsC = document.getElementById('lu2Dots');
    if (!track) return;

    var cards   = Array.from(track.querySelectorAll('.lu2-card'));
    var total   = cards.length;
    var cur     = 0;
    var animating = false;

    function visCount() {
        var w = track.parentElement.offsetWidth;
        if (w < 620) return 1;
        if (w < 900) return 2;
        if (w < 1200) return 3;
        if (w < 1500) return 4;
        return 5; // ultrawide/large desktop shows 5 cards
    }

    /* Build dots */
    var maxSlide = Math.max(0, total - visCount());
    for (var i = 0; i <= maxSlide; i++) {
        (function(idx){
            var d = document.createElement('div');
            d.className = 'lu2-dot' + (idx === 0 ? ' on' : '');
            d.addEventListener('click', function(){ goTo(idx); });
            dotsC.appendChild(d);
        })(i);
    }

    function updateDots() {
        var dots = dotsC.querySelectorAll('.lu2-dot');
        dots.forEach(function(d, i){ d.classList.toggle('on', i === cur); });
    }

    function goTo(idx) {
        if (animating) return;
        var vis = visCount();
        var max = Math.max(0, total - vis);
        cur = Math.min(Math.max(idx, 0), max);

        /* card width + gap */
        var style   = window.getComputedStyle(track);
        var gap     = parseFloat(style.gap) || 22;
        var cardW   = cards[0].offsetWidth + gap;
        var target  = cur * cardW;

        /* animate with JS (track has overflow:hidden, no native scroll) */
        animating = true;
        var start    = track.scrollLeft;
        var distance = target - start;
        var duration = 420;
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

    document.getElementById('lu2Prev').addEventListener('click', function(){ goTo(cur - 1); });
    document.getElementById('lu2Next').addEventListener('click', function(){ goTo(cur + 1); });

    /* Auto-play */
    setInterval(function(){
        var vis = visCount();
        var max = Math.max(0, total - vis);
        goTo(cur < max ? cur + 1 : 0);
    }, 5000);
})();
</script>
@endif