@if(empty(request('q')))
<div id="accordionOne" class="filter_btnnn">
   <div class="card">
      <div class="card-header" id="headingOne">
         <a role="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="fas fa-filter mr__5"></i>Filter</a>
      </div>
      <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
         data-parent="#accordionOne">
         <div class="card-body">
            <div class="widget-area">
               @if($productBullets->count()>0)
               <div class="widget widget_nav_menu radio-button">
                  <h5 class="widget-title border-bottom"> Products </h5>
                  <ul>
                     @foreach($productBullets  as $key => $productBullet)
                     <li>
                        <div class="form-check px-0">
                           <label class="form-check-label">
                           <input type="checkbox" name="color" value="{{ @$productBullet }}" class="filterBullet"> &nbsp;  {{ @$productBullet }}
                           <span class="float-right right-menu bg-white border"> ({{App\Models\Product::where('is_visible_website',1)->where('subcategory_id',$getSingleSubCategory->id)->where('name',$productBullet)->count()}}) </span>
                           </label>
                        </div>
                     </li>
                     @endforeach
                  </ul>
               </div>
               @endif
               @if($categoryColors->count()>0)
               <div class="widget widget_nav_menu radio-button">
                  <h5 class="widget-title border-bottom"> Available Colors </h5>
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
               <div class="widget widget_nav_menu radio-button">
                  <h5 class="widget-title border-bottom"> Available Sizes </h5>
                  <ul>
                     @foreach($categorySizes->sortBy('size')??'' as $key => $categorySize)
                     <li>
                        <div class="form-check px-0">
                           <label class="form-check-label">
                           <input type="checkbox" name="size" value="{{ $categorySize->size??'' }}" class="filterAjax"> &nbsp;{{ $categorySize->size??'' }}
                           <span class="float-right right-menu bg-white border"> ( {{  App\Models\Product::getSubcategorySizeProducts($getSingleSubCategory->id, $categorySize->size)->count() }} ) </span>
                           </label>
                        </div>
                     </li>
                     @endforeach
                  </ul>
               </div>
               @endif
               @if($similarCategories->count()>0)
               <div class="widget widget_nav_menu radio-button">
                  <h5 class="widget-title border-bottom"> {{$getSingleSubCategory->category->name??''}}</h5>
                  <ul>
                     @foreach($similarCategories??'' as $similarCategory)
                     <li>
                        <a href="{{ route('productList.list', [$getSingleSubCategory->category->url_key,$similarCategory]) }}" class="{{url()->current()==route('productList.list', [$getSingleSubCategory->category->url_key,$similarCategory])?'active':''}}">{{$similarCategory['name']??'' }}
                        <span class="float-right right-menu bg-white border"> ( {{ App\Models\Product::getSubcategoryProducts($similarCategory->id)->count() }} ) </span>
                        </a>
                     </li>
                     @endforeach
                  </ul>
               </div>
               @endif
            </div>
         </div>
      </div>
   </div>
</div>
@endif