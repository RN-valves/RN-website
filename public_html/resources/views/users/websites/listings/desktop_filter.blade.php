<div class="col-lg-3">
   <div class="widget-area">
      {{-- Check search result --}}
      <form id="filterForm" method="post" action="{{ route('filterProductList') }}">
         {{ csrf_field() }}
         <input type="hidden" name="size_id" id="get_sizes" class="form-control" placeholder="Sizes">
         <input type="hidden" name="color_id" id="get_colors" class="form-control" placeholder="Colors">
         <input type="hidden" name="bullet_id" id="get_bullets" class="form-control" placeholder="Bullets">
         @if(empty(request('q')) && empty(request('product_name')))
         <input type="hidden" name="subcategory_id" value="{{ $getSingleSubCategory->id }}" class="form-control" placeholder="Categories">
         @elseif(!empty(request('q')))
         <input type="hidden" name="q" value="{{ request('q') }}" class="form-control" placeholder="">
         @elseif(!empty(request('product_name')))
         <input type="hidden" name="product_name" value="{{ request('product_name') }}" class="form-control" placeholder="">
         @endif
         <input type="hidden" name="sort_by_id" id="get_sort_by" class="form-control" placeholder="Sort Filter">
      </form>
      @if(empty(request('q')) && empty(request('product_name')))
      @if(count($productBullets) > 0)
      <div class="widget widget_nav_menu radio-button hidden_991">
         <h5 class="widget-title border-bottom">Products</h5>
         
         <ul>
            @foreach($productBullets??'' as $productBullet)
            <li>
               <div class="form-check px-0">
                  <label class="form-check-label">
                  <input type="checkbox" name="bullet" value="{{ $productBullet ??'' }}" class="filterBullet"> &nbsp;  {{ $productBullet ??'' }}
                  <span class="float-right right-menu bg-white border"> ({{App\Models\Product::where('is_visible_website',1)->where('status','Active')->where('subcategory_id',$getSingleSubCategory->id)->where('name',$productBullet)->count()}}) </span>
                  </label>
               </div>
            </li>
            @endforeach
         </ul>
      </div>
      @endif
      @if($categoryColors->count()>0)
      <div class="widget widget_nav_menu radio-button hidden_991">
         <h5 class="widget-title border-bottom">Available Colors</h5>
         <ul>
            @foreach($categoryColors??'' as $key => $categoryColor)
            <li>
               <div class="form-check px-0">
                  <label class="form-check-label">
                  <input type="checkbox" name="color" value="{{ $categoryColor->color_name??'' }}" class="filterColor"> &nbsp;  {{ $categoryColor->color_name??'' }}
                  <span class="float-right right-menu bg-white border"> ( {{ App\Models\Product::getSubcategoryColorProducts($getSingleSubCategory->id, $categoryColor->color_name)->count() }} ) </span>
                  </label>
               </div>
            </li>
            @endforeach
         </ul>
      </div>
      @endif
      @if($categorySizes->count()>0)
      <div class="widget widget_nav_menu radio-button hidden_991">
         <h5 class="widget-title border-bottom">Available Sizes</h5>
         <ul>
            @foreach($categorySizes->sortBy('size')??'' as $key => $categorySize)
            <li>
               <div class="form-check px-0">
                  <label class="form-check-label">
                  <input type="checkbox" name="size" value="{{ $categorySize->size??'' }}" class="filterAjax"> &nbsp;{{ $categorySize->size??'' }}
                  <span class="float-right right-menu bg-white border"> ( {{ App\Models\Product::getSubcategorySizeProducts($getSingleSubCategory->id, $categorySize->size)->count() }} ) </span>
                  </label>
               </div>
            </li>
            @endforeach
         </ul>
      </div>
      @endif
      @if($similarCategories->count()>0)
      <div class="widget widget_nav_menu radio-button hidden_991">
         <h5 class="widget-title border-bottom ">{{$getSingleSubCategory->category->name??''}}</h5>
         <ul>
            @if(isset($similarCategories))
            @foreach($similarCategories??'' as $key => $similarCategory)
            <li>
               <a href="{{ route('productList.list', [$getSingleSubCategory->category->url_key,$similarCategory]) }}" class="{{url()->current()==route('productList.list', [$getSingleSubCategory->category->url_key,$similarCategory])?'active':''}}">{{$similarCategory['name']??'' }}
               <span class="float-right right-menu bg-white border"> ( {{ App\Models\Product::getSubcategoryProducts($similarCategory->id)->count() }} ) </span>
               </a>
            </li>
            @endforeach
            @endif
         </ul>
      </div>
      @endif
      @if(ActiveCategories()->count()>0)
      <div class="widget style-01">
         <h5 class="widget-title border-bottom">All Categories</h5>
         <div class="tagcloud">
            @foreach(ActiveCategories()??'' as $ACategory)
            <a href="{{route('productList', $ACategory)}}">{{$ACategory->name??''}}</a>
            @endforeach
         </div>
      </div>
      @endif

      {{-- Check else condition for search result --}}
      @else
      <h5 class="widget-title border-bottom "><small>Search for .. </small> </h5>
      <div class="widget widget_nav_menu radio-button hidden_991">
      <h5 class="widget-title border-bottom ">{{ request('q') ?? request('product_name')}}</h5>
      </div>
      @endif
      {{-- Check search result --}}
      <!--// Tag Widget-->
   </div>
</div>