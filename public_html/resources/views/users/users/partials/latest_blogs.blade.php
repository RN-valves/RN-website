@php
$latestPosts = App\Models\Blog::getBlogList();
$categories = App\Models\Category::where(['status'=>'Active','is_visible_website'=>1])->orderBy('name','asc')->get();
@endphp
@if($latestPosts->count()>0)
<div class="row">
   <div class="col-lg-12">
      <div class="section-title">
         <h2 class="heading-02">Latest Updates </h2>
         <a href="{{ route('blogs', ['url_key'=>'blogs']) }}" class="alllinks">View All</a>
         <div class="padding-top-10 padding-bottom-20">
            <p>With over 24 years of industry experience, RN Valves &amp; Faucets is not just a brand—it’s a legacy built on trust, quality, and innovation. Whether you’re upgrading your bathroom or seeking dependable fittings for a new project, we have the ideal solution for you.</p>
         </div>
      </div>
   </div>
</div>
<div class="blog_grid_area">
   <ul>
      @foreach($latestPosts->take(3)??'' as $ltBlog)
      <li class="wow fadeInUp" data-wow-delay="0.1s">
         <div class="blog_boxxxx">
            <a href="{{ route('blogs', $ltBlog->url_key) }}"> 
            <img src="{{url($ltBlog['image'])}}" alt="{{$ltBlog['title']}}" loading="lazy" title="{{$ltBlog['title']}}">
            </a>
            <div class="blogg__text">
               <a href="{{ route('blogs', $ltBlog->url_key) }}" class="badge badge-sm text-white" style="background: #00a0e3;">{{ $ltBlog->category_name??'' }} </a>
               <span class="badge bg-white badge-sm text-dark"><i class="far fa-clock text-info"></i> {{ $ltBlog->published_at->format('d M Y') }}</span>
               <a href="{{ route('blogs', $ltBlog->url_key) }}">
                  <h4 class="mb-0">{{ $ltBlog->name }}</h4>
                  <p class="text-white mt-1" style="font-size:14px;">{{ substr($ltBlog->short_description,0,125) }}..</p>
               </a>
            </div>
         </div>
      </li>
      @endforeach
   </ul>
   <div class="clear"></div>
</div>
@endif