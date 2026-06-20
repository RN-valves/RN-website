@extends('admin.layout')
@section('seo_title')
<title>Product</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Product</li>
@endsection
@section('content')
<div class="row">
   @include('admin.products.partials.menu')
</div>
@can('bullet-point-create')
<div class="card pt-4">
   <div class="card-body">
      <form class="row" method="POST" action="{{ route('products.product_bullet_product', $product) }}" id="bullet_form">
         @csrf
         <div class="col-md-9 form-group">
            <select name="product_bullet_id[]" class="form-control" id="nameProductBullet" multiple="">
               @foreach(App\Models\ProductBullet::where('status','Active')->whereNotIn('name', $product->bullets->pluck('name'))->get() as $pBullet)
               <option value="{{ $pBullet->id }}">{{ $pBullet->name??'' }}</option>
               @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('product_bullet_id')" />
         </div>
         <div class="col-md-3 form-group">
            <button type="submit" id="disabled_btn" class="btn btn-dark w-100 disabled_btn">Add Bullet Point</button>
         </div>
      </form>
   </div>
</div>
@endcan
<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12 margin-tb">
         <div class="clearfix"></div>
         <div class="row">
            @can("change-product-status")
            <div class="col-lg-12">
               <form class="row" method="POST" action="{{ route('products.statusProduct', $product) }}">
                  @csrf
                  <div class="col-lg-4 form-group">
                     <label>Name</label>
                     <select class="form-control" name="status" id="status">
                     @foreach($statuses??'' as  $status)
                     <option value="{{ $status }}" @selected(old('status', @$product->status)==$status)>{{ $status }}</option>
                     @endforeach 
                     </select>
                  </div>
                  <div class="col-lg-4 form-group">
                     <label>Update Product Status</label><br>
                     <button type="submit" class="btn btn-success btn-sm">Update Product Status</button>
                  </div>
               </form>
            </div>
            @endcan
            <div class="col-lg-8">
               <div class="table-responsive bg-secondary">
                  <table class="table">
                     <thead>
                        <tr>
                           <th>Category</th>
                           <th>
                              <a href="{{ route('categories.show', $product->category) }}">{{ $product->category->name??'' }}</a>
                           </th>
                           <th>SubCategory</th>
                           <th>
                              <a href="{{ route('subcategories.show', $product->subcategory) }}">{{ $product->subcategory->name??'' }}</a>
                           </th>
                        </tr>
                        <tr>
                           <th>Brand</th>
                           <td>{{ $product->brand??'' }}</td>
                           <th>Material</th>
                           <td>{{ $product->material??'' }}</td>
                        </tr>
                        <tr>
                           <th>Product Article</th>
                           <td>{{ $product->article??'' }}</td>
                           <th>Product Code</th>
                           <td>{{ $product->sku_code??'' }}</td>
                        </tr>
                        <tr>
                           <th>Color Name</th>
                           <td>{{ $product->color_name??'' }} <br> {{ $product->color_group_id??'' }}</td>
                           <th>Color Icon</th>
                           <td>
                              <img src="{{ url($product->color_icon??'') }}" width="30px">
                           </td>
                        </tr>
                        <tr>
                           <th>Product Size</th>
                           <td>{{ $product->size??'' }} <span class="text-danger">|</span> {{ $product->product_size_id??'' }}</td>
                           <th>Content Id</th>
                           <td>{{ $product->content->title??'' }}</td>
                        </tr>
                        <tr>
                           <th>HSN Code</th>
                           <td>{{ $product->hsn??'' }}</td>
                           <th>Is Visible Web?</th>
                           <td>{{ $product->is_visible_website? 'Visible' : 'InVisible'??'' }}</td>
                        </tr>
                        <tr>
                           <th>Is Visible API?</th>
                           <td>{{ $product->is_visible_api? 'Visible' : 'InVisible'??'' }}</td>
                           <th>New Arrival?</th>
                           <td>{{ $product->new_arrival? 'Yes' : 'No'??'' }}</td>
                        </tr>
                        <tr>
                           <th class="text-primary" colspan="4">Product Attributes Detail</th>
                        </tr>
                        <tr>
                           <th>Master CTN Pcs</th>
                           <td>{{ $product->productAttribute->ctn_pcs??0 }}</td>
                           <th>Middle CTN Pcs</th>
                           <td>{{ $product->productAttribute->mid_ctn_pcs??0 }}</td>
                        </tr>
                        <tr>
                           <th>Inner Pcs QTY</th>
                           <td>{{ $product->productAttribute->inner_pcs??0 }}</td>
                           <th>Stock Pcs</th>
                           <td>{{ $product->productAttribute->stock_pcs??0 }}</td>
                        </tr>
                        <tr>
                           <th>Is Featured?</th>
                           <td>{{ $product->is_featured? 'Yes' : 'No'??'' }}</td>
                           <th>Product Length</th>
                           <td>{{ $product->productAttribute->product_length??0 }}</td>
                        </tr>
                        <tr>
                           <th>Product Breadth</th>
                           <td>{{ $product->productAttribute->product_breadth??0 }}</td>
                           <th>Product Height</th>
                           <td>{{ $product->productAttribute->product_height??0 }}</td>
                        </tr>
                        <tr>
                           <th>Product Weight (GM)</th>
                           <td>{{ $product->productAttribute->only_product_wt_gm??0 }}</td>
                           <th>Product LBH Weight (GM)</th>
                           <td>{{ $product->productAttribute->product_lbh_weight_gm??0 }}</td>
                        </tr>
                        <tr>
                           <th>Mid CTN Weight (KG)</th>
                           <td>{{ $product->productAttribute->mid_ctn_lbh_weight_kg??0 }}</td>
                           <th>Master CTN Weight (KG)</th>
                           <td>{{ $product->productAttribute->master_ctn_lbh_weight_kg??0 }}</td>
                        </tr>
                        <tr>
                           <th>Residential Warranty</th>
                           <td>{{ $product->productAttribute->residential_warranty??'' }}</td>
                           <th>Commercial Warranty</th>
                           <td>{{ $product->productAttribute->commercial_warranty??'' }}</td>
                        </tr>
                        <tr>
                           <th>Amazon Link</th>
                           <td><a href="{{ url($product->productAttribute->amazon_link??'') }}"> {{ $product->productAttribute->amazon_link??'' }} </a></td>
                           <th>Flipkart Link</th>
                           <td><a href="{{ url($product->productAttribute->flipkart_link??'') }}"> {{ $product->productAttribute->flipkart_link??'' }} </a></td>
                        </tr>
                        <tr>
                           <th>Video Url()</th>
                           <td>{{ $product->productAttribute->video_url??'' }}</td>
                           <th>Short Description</th>
                           <td>{{ $product->productAttribute->short_description??'' }}</td>
                        </tr>
                     </thead>
                  </table>
                  <table class="table table-bordered">
                     <tr>
                        <th>MRP(IN)</th>
                        <th>Selling(IN)</th>
                        <th>V1-MRP(IN)</th>
                        <th>MRP(OTH)</th>
                        <th>Selling(OTH)</th>
                        <th>V1-MRP(OTH)</th>
                     </tr>
                     <tr>
                        <td>₹{{ $product->in_mrp??'' }}</td>
                        <td>₹{{ $product->in_selling??'' }}</td>
                        <td>₹{{ $product->in_v1_mrp??'' }}</td>
                        <td>₹{{ $product->oth_mrp??'' }}</td>
                        <td>₹{{ $product->oth_selling??'' }}</td>
                        <td>₹{{ $product->oth_v1_mrp??'' }}</td>
                     </tr>
                     <tbody>
                        <td colspan="6">{!! $product->content->content??'' !!}</td>
                     </tbody>
                  </table>
               </div>
               <div class="table-responsive pt-3">
                  <table class="table table-bordered table-hover table-striped">
                     @php
                     $colorGroups = App\Models\Product::colorGroups($product->color_group_id, $product->id);
                     @endphp
                     <tr>
                        <th colspan="7" class="text-center">Available Colors</th>
                     </tr>
                     <tr>
                        <th>Color Name</th>
                        <th>Article</th>
                        <th>Product Code</th>
                        <th>Stock Pcs</th>
                        <th>MRP(IN)</th>
                        <th>Selling(IN)</th>
                        <th>Img</th>
                     </tr>
                     @foreach($colorGroups->sortByDesc('id')??'' as $colorPro)
                     <tr>
                        <td>{{ $colorPro->color_name??'' }}</td>
                        <td>{{ $colorPro->article??'' }}</td>
                        <th>
                           <a href="{{ route('products.show', $colorPro) }}">{{ $colorPro->sku_code??'' }}</a>
                        </th>
                        <td>{{ $colorPro->productAttribute->stock_pcs??'' }}</td>
                        <td>{{ $colorPro->in_mrp??'' }}</td>
                        <td>{{ $colorPro->in_selling??'' }}</td>
                        <td>
                           @if(!empty($colorPro->image))
                           <a href="{{ url($colorPro->image??'') }}"><i class="bx bx-image"></i></a>
                           @endif
                        </td>
                     </tr>
                     @endforeach
                  </table>
               </div>
            </div>
            <div class="col-lg-4" style="border-left: 4px solid grey;">
               <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                     <tr>
                        <th class="text-center" colspan="4" style="background: #cacdcf;">Bullet Points</th>
                     </tr>
                     <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Action</th>
                     </tr>
                     {{-- {{ dd($product->bullets) }} --}}
                     @foreach($product->bullets??'' as $bpoint)
                     {{-- {{ dd($bpoint->pivot->product_bullet_id) }} --}}
                     <tr>
                        <td>{{ $bpoint->id??'' }}</td>
                        <td>{{ $bpoint->name??'' }}</td>
                        <td>
                           <a href="{{ route('products.delete_product_bullet_id', ['bullet_id'=>$bpoint->pivot->product_bullet_id, 'product_id'=>$product->id]) }}" class="text-danger"> Delete </a>
                        </td>
                     </tr>
                     @endforeach
                  </table>
                  <table class="table table-bordered table-hover table-striped">
                     <tr>
                        <th class="text-center" colspan="4" style="background: #cacdcf;">Product Size Group List</th>
                     </tr>
                     @php
                     $sizeGroups = App\Models\Product::sizeGroups($product->product_size_id, $product->id);
                     @endphp
                     <tr>
                        <th>Product Code</th>
                        <th>Size</th>
                        <th>MRP(IN)</th>
                        <th>Selling(IN)</th>
                     </tr>
                     @foreach($sizeGroups->sortByDesc('id')??'' as $sizePro)
                     <tr>
                        <th>
                           <a href="{{ route('products.show', $sizePro) }}">{{ $sizePro->sku_code??'' }}</a>
                        </th>
                        <td>{{ $sizePro->size??'' }}</td>
                        <td>{{ $sizePro->in_mrp??'' }}</td>
                        <td>{{ $sizePro->in_selling??'' }}</td>
                     </tr>
                     @endforeach
                  </table>
               </div>
               @if(!empty($product->image))
               <div class="card-img">
                  <img src="{{ url($product->image??'') }}" width="100%">
               </div>
               @endif
               <div class="row">
                  @foreach($product->productImages??'' as $productImage)
                  <div class="col-lg-4">
                     <div class="card">
                        <div class="card-img border">
                           <img src="{{ url($productImage->image??'') }}" width="100%">
                        </div>
                     </div>
                  </div>
                  @endforeach
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
   $("#status").select2({
     theme: "classic"
   });
   $("#size").select2({
     theme: "classic"
   });
   $("#nameProductBullet").select2({
     theme: "classic"
   });
</script>
<script type="text/javascript">
$(document).ready(function () {
   $("#bullet_form").submit(function (e) {
      $(".disabled_btn").attr("disabled", true);
      return true;
   });
});
</script>
@endsection