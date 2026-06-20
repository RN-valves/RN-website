@extends('admin.layout')
@section('seo_title')
<title>Product</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Product</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12">
         @if (count($errors) > 0)
         <div class="alert alert-danger">
            <strong>Whoops! </strong> There were some problems with your input.<br><br>
            <ul>
               @foreach ($errors->all() as $error)
               <li>{{ $error }}</li>
               @endforeach
            </ul>
         </div>
         @endif
         <form action="{{ route('products.update', $product) }}" method="POST" accept-charset="utf-8" class="row" enctype="multipart/form-data">
            @csrf
            @if(!empty($product))
            @method('PUT')
            @endif
            <div class="col-lg-3 form-group pt-2">
               <label for="roles_select" style="width:100%;">
               Select Brand
               </label>
               <select class="js-states form-control" id="brand" name="brand">
               @foreach ($brands??'' as $brand)
               <option value="{{ $brand->name }}" @selected(old('brand', @$product->brand)==$brand->name)>{{ $brand->name??'' }}</option>
               @endforeach
               </select>
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('brand')" />
            </div>
            <div class="col-lg-3 form-group pt-2">
               <label for="roles_select" style="width:100%;">
               Select Category
               </label>
               <select class="js-states form-control" id="subcategory_id" name="subcategory_id">
               @foreach ($subcategories??'' as $subcategory)
               <option value="{{ $subcategory->id }}" @selected(old('subcategory_id', @$product->subcategory_id)==$subcategory->id)>{{ $subcategory->name??'' }} - {{ $subcategory->category->name??'' }}</option>
               @endforeach
               </select>
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('subcategory_id')" />
            </div>
            <div class="col-lg-3 form-group pt-2">
               <label for="roles_select" style="width:100%;">
                  Select Material
                  <select class="js-states form-control" id="material" name="material">
                  @foreach ($materials??'' as $material)
                  <option value="{{ $material->name??'' }}" @selected(old('material', @$product->material)==$material->name??'')>{{ $material->name??'' }}</option>
                  @endforeach
                  </select>
                  <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('material')" />
               </label>
            </div>
            <div class="col-lg-3 form-group pt-2">
               <label for="roles_select" style="width:100%;">
                  Select Sale Type
                  <select class="js-states form-control" id="sale_type" name="sale_type">
                  @foreach ($materials??'' as $material)
                  <option value="{{ $material->name??'' }}" @selected(old('sale_type', @$product->sale_type)==$material->name??'')>{{ $material->name??'' }}</option>
                  @endforeach
                  </select>
                  <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('sale_type')" />
               </label>
            </div>
            <div class="col-lg-3 form-group pt-2">
               <label for="roles_select" style="width:100%;">
                  Select Color
                  <select class="js-states form-control" id="color_name" name="color_name">
                  @foreach ($colors??'' as $color)
                  <option value="{{ $color->name??'' }}" @selected(old('color_name', @$product->color_name)==$color->name??'')>{{ $color->name??'' }}</option>
                  @endforeach
                  </select>
                  <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('color_name')" />
               </label>
            </div>
            <div class="col-lg-3 form-group pt-2">
               <label for="roles_select" style="width:100%;">
                  Select Size
                  <select class="js-states form-control" id="size" name="size">
                  @foreach ($sizes??'' as $size)
                  <option value="{{ $size->name??'' }}" @selected(old('size', @$product->size)==$size->name??'')>{{ $size->name??'' }}</option>
                  @endforeach
                  </select>
                  <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('size')" />
               </label>
            </div>
            <div class="col-lg-3 form-group pt-2">
               <label for="roles_select" style="width:100%;">
                  Select Updated Content
                  <select class="js-states form-control" id="content_id" name="content_id">
                  @foreach ($contents??'' as $content)
                  <option value="{{ $content->id??'' }}" @selected(old('content_id', @$product->content_id)==$content->id??'')>{{ $content->title??'' }}</option>
                  @endforeach
                  </select>
                  <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('content_id')" />
               </label>
            </div>
            <!-- <div class="col-lg-3 form-group">
               <label class="mb-1">Image</label>
               <input type="file" name="image" value="{{ old('image', @$product->image??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('image')" />
            </div> -->
            <div class="col-lg-3 form-group">
               <label class="mb-1">Image Url</label>
               <input type="text" name="image" value="{{ old('image', @$product->image??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('image')" />
            </div>
            <div class="col-lg-5 form-group">
               <label class="mb-1">Enter Product Name</label>
               <input type="text" name="name" value="{{ old('name', @$product->name??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('name')" />
            </div>
            <div class="col-lg-2 form-group">
               <label class="mb-1">Product Article</label>
               <input type="text" name="article" value="{{ old('article', @$product->article??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('article')" />
            </div>
            <div class="col-lg-2 form-group">
               <label class="mb-1">Product Code</label>
               <input type="text" name="sku_code" value="{{ old('sku_code', @$product->sku_code??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('sku_code')" />
            </div>
            <div class="col-lg-3 form-group">
               <label class="mb-1">HSN Code</label>
               <input type="text" name="hsn" value="{{ old('hsn', @$product->hsn??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('hsn')" />
            </div>

            <div class="col-lg-4 form-group">
               <label class="mb-1">Color Group Id</label>
               <input type="text" name="color_group_id" value="{{ old('color_group_id', @$product->color_group_id??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('color_group_id')" />
            </div>
            <div class="col-lg-4 form-group">
               <label class="mb-1">Size Group Id</label>
               <input type="text" name="product_size_id" value="{{ old('product_size_id', @$product->product_size_id??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('product_size_id')" />
            </div>
            <div class="col-lg-4 form-group">
               <label class="mb-1">Combo Group Id</label>
               <input type="text" name="product_combo_id" value="{{ old('product_combo_id', @$product->product_combo_id??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('product_combo_id')" />
            </div>

            <div class="col-lg-12 pt-3">
               <div class="table-responsive">
                  <table class="table table-bordered">
                     <tr>
                        <th>Country Name</th>
                        <th>MRP</th>
                        <th>Selling</th>
                        <th>V1 MRP</th>
                     </tr>
                     <tr>
                        <td>India</td>
                        <td>
                           <input type="number" name="in_mrp" value="{{ old('in_mrp', @$product->in_mrp??0) }}" placeholder="MRP" autocomplete="off" class="form-control shadow-none">
                           <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('in_mrp')" />
                        </td>
                        <td>
                           <input type="text" name="in_selling" value="{{ old('in_selling', @$product->in_selling??0) }}" placeholder="Selling" autocomplete="off" class="form-control shadow-none">
                           <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('in_selling')" />
                        </td>
                        <td>
                           <input type="text" name="in_v1_mrp" value="{{ old('in_v1_mrp', @$product->in_v1_mrp??0) }}" placeholder="V1 MRP" autocomplete="off" class="form-control shadow-none">
                           <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('in_v1_mrp')" />
                        </td>
                     </tr>
                     <tr>
                        <td>Other Country</td>
                        <td>
                           <input type="text" name="oth_mrp" value="{{ old('oth_mrp', @$product->oth_mrp??0) }}" placeholder="MRP" autocomplete="off" class="form-control shadow-none">
                           <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('oth_mrp')" />
                        </td>
                        <td>
                           <input type="text" name="oth_selling" value="{{ old('oth_selling', @$product->oth_selling??0) }}" placeholder="Selling" autocomplete="off" class="form-control shadow-none">
                           <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('oth_selling')" />
                        </td>
                        <td>
                           <input type="text" name="oth_v1_mrp" value="{{ old('oth_v1_mrp', @$product->oth_v1_mrp??0) }}" placeholder="V1 MRP" autocomplete="off" class="form-control shadow-none">
                           <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('oth_v1_mrp')" />
                        </td>
                     </tr>
                  </table>
               </div>
            </div>
            <div class="col-lg-12 form-group">
               <label class="mb-1">SEO Title</label>
               <input type="text" name="title" value="{{ old('title', @$product->title??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('title')" />
            </div>
            <div class="col-lg-12 form-group">
               <label class="mb-1">SEO Keywords</label>
               <input type="text" name="keywords" value="{{ old('keywords', @$product->keywords??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('keywords')" />
            </div>
            <div class="col-lg-12 form-group">
               <label class="mb-1">SEO Description</label>
               <input type="text" name="description" value="{{ old('description', @$product->description??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('description')" />
            </div>
            <div class="col-lg-12 form-group">
               <label class="mb-1">Search Keywords</label>
               <input type="text" name="search_keywords" value="{{ old('search_keywords', @$product->search_keywords??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('search_keywords')" />
            </div>
            <div class="col-md-3 form-group mt-3">
               <x-input-label class="mb-1" for="is_visible_website" :value="__('Is Visible?')" />
               <select class="form-control shadow-none @error('is_visible_website') is-invalid @enderror" name="is_visible_website" id="is_visible_website">
                  <option value="1" @selected(old('is_visible_website',@$product->is_visible_website)==1)>Visible</option>
                  <option value="0" @selected(old('is_visible_website',@$product->is_visible_website)==0)>InVisible</option>
               </select>
               <x-input-error class="mt-2" :messages="$errors->get('is_visible_website')" />
            </div>
            <div class="col-md-3 form-group mt-3">
               <x-input-label class="mb-1" for="is_visible_api" :value="__('Is Visible API?')" />
               <select class="form-control shadow-none @error('is_visible_api') is-invalid @enderror" name="is_visible_api" id="is_visible_api">
                  <option value="1" @selected(old('is_visible_api',@$product->is_visible_api)==1)>Visible</option>
                  <option value="0" @selected(old('is_visible_api',@$product->is_visible_api)==0)>InVisible</option>
               </select>
               <x-input-error class="mt-2" :messages="$errors->get('is_visible_api')" />
            </div>
            <div class="col-md-3 form-group mt-3">
               <x-input-label class="mb-1" for="new_arrival" :value="__('New Arrwal?')" />
               <select class="form-control shadow-none @error('new_arrival') is-invalid @enderror" name="new_arrival" id="new_arrival">
                  <option value="1" @selected(old('new_arrival',@$product->new_arrival)==1)>Visible</option>
                  <option value="0" @selected(old('new_arrival',@$product->new_arrival)==0)>InVisible</option>
               </select>
               <x-input-error class="mt-2" :messages="$errors->get('new_arrival')" />
            </div>
            <div class="col-md-3 form-group mt-3">
               <x-input-label class="mb-1" for="is_featured" :value="__('Is Featured?')" />
               <select class="form-control shadow-none @error('is_featured') is-invalid @enderror" name="is_featured" id="is_featured">
                  <option value="1" @selected(old('is_featured',@$product->is_featured)==1)>Visible</option>
                  <option value="0" @selected(old('is_featured',@$product->is_featured)==0)>InVisible</option>
               </select>
               <x-input-error class="mt-2" :messages="$errors->get('is_featured')" />
            </div>
            <div class="col-md-3 form-group mt-3">
               <x-input-label class="mb-1" for="is_isicertified" :value="__('Is ISI Certified?')" />
               <select class="form-control shadow-none @error('is_isicertified') is-invalid @enderror" name="is_isicertified" id="is_isicertified">
                  <option value="1" @selected(old('is_isicertified',@$product->is_isicertified)==1)>Yes</option>
                  <option value="0" @selected(old('is_isicertified',@$product->is_isicertified)==0)>No</option>
               </select>
               <x-input-error class="mt-2" :messages="$errors->get('is_isicertified')" />
            </div>
            <div class="col-lg-12 pt-3">
               <div class="table-responsive">
                  <table class="table table-bordered">
                     <tr>
                        <th class="text-center" style="background: #cacdcf;" colspan="6">Product Attributes Detail</th>
                     </tr>
                     <tr>
                        <th>CTN Pcs QTy</th>
                        <th>Mid. CTN Pcs</th>
                        <th>Inner Pcs QTy</th>
                        <th>Stock Pcs QTy</th>
                        <th>Product Length</th>
                        <th>Product breadth</th>
                     </tr>
                     <tr>
                        <td>
                           <input type="number" name="ctn_pcs" value="{{ old('ctn_pcs', @$product->productAttribute->ctn_pcs??0) }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
                           <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('ctn_pcs')" />
                        </td>
                        <td>
                           <input type="number" name="mid_ctn_pcs" value="{{ old('mid_ctn_pcs', @$product->productAttribute->mid_ctn_pcs??0) }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
                           <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('mid_ctn_pcs')" />
                        </td>
                        <td>
                           <input type="number" name="inner_pcs" value="{{ old('inner_pcs', @$product->productAttribute->inner_pcs??0) }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
                           <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('inner_pcs')" />
                        </td>
                        <td>
                           <input type="number" name="stock_pcs" value="{{ old('stock_pcs', @$product->productAttribute->stock_pcs??0) }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
                           <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('stock_pcs')" />
                        </td>
                        <td>
                           <input type="number" step="any" name="product_length" value="{{ old('product_length', @$product->productAttribute->product_length??0) }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
                           <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('product_length')" />
                        </td>
                        <td>
                           <input type="number" step="any" name="product_breadth" value="{{ old('product_breadth', @$product->productAttribute->product_breadth??0) }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
                           <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('product_breadth')" />
                        </td>
                     </tr>
                     <tr>
                        <th>Product height</th>
                        <th>Only Product Weight (GM)</th>
                        <th>Product Inner LBH Weight (GM)</th>
                        <th>Mid BOX LBH Weight (KG)</th>
                        <th>Master BOX LBH Weight (KG)</th>
                        <th>Commercial Warranty</th>
                     </tr>
                     <tr>
                        <td>
                           <input type="number" step="any" name="product_height" value="{{ old('product_height', @$product->productAttribute->product_height??0) }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
                           <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('product_height')" />
                        </td>
                        <td>
                           <input type="number" step="any" name="only_product_wt_gm" value="{{ old('only_product_wt_gm', @$product->productAttribute->only_product_wt_gm??0) }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
                           <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('only_product_wt_gm')" />
                        </td>
                        <td>
                           <input type="number" step="any" name="product_lbh_weight_gm" value="{{ old('product_lbh_weight_gm', @$product->productAttribute->product_lbh_weight_gm??0) }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
                           <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('product_lbh_weight_gm')" />
                        </td>
                        <td>
                           <input type="number" step="any" name="mid_ctn_lbh_weight_kg" value="{{ old('mid_ctn_lbh_weight_kg', @$product->productAttribute->mid_ctn_lbh_weight_kg??0) }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
                           <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('mid_ctn_lbh_weight_kg')" />
                        </td>
                        <td>
                           <input type="number" step="any" name="master_ctn_lbh_weight_kg" value="{{ old('master_ctn_lbh_weight_kg', @$product->productAttribute->master_ctn_lbh_weight_kg??0) }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
                           <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('master_ctn_lbh_weight_kg')" />
                        </td>
                        <td>
                           <input type="number" name="residential_warranty" value="{{ old('residential_warranty', @$product->productAttribute->residential_warranty??0) }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
                           <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('residential_warranty')" />
                        </td>
                     </tr>
                  </table>
               </div>
            </div>
            <div class="col-lg-3 form-group">
               <label class="mb-1">Commercial Warranty</label>
               <input type="number" name="commercial_warranty" value="{{ old('commercial_warranty', @$product->productAttribute->commercial_warranty??0) }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('commercial_warranty')" />
            </div>
            <div class="col-lg-9 form-group">
               <label class="mb-1">Product Video URL (Opt)</label>
               <input type="text" name="video_url" value="{{ old('video_url', @$product->productAttribute->video_url??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('video_url')" />
            </div>
            <div class="col-lg-4 form-group">
               <label class="mb-1">Amazon Link (Opt)</label>
               <input type="text" name="amazon_link" value="{{ old('amazon_link', @$product->productAttribute->amazon_link??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('amazon_link')" />
            </div>
            <div class="col-lg-4 form-group">
               <label class="mb-1">Flipkart Link (Opt)</label>
               <input type="text" name="flipkart_link" value="{{ old('flipkart_link', @$product->productAttribute->flipkart_link??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('flipkart_link')" />
            </div>
            <div class="col-lg-12 form-group">
               <label class="mb-1">Product Short Description (Opt)</label>
               <textarea class="form-control shadow-none editor @error('short_description') is-invalid @enderror" id="editor" name="short_description"> {{ old('short_description',@$product->productAttribute->short_description)}} </textarea>
               <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('short_description')" />
            </div>
            <div class="col-md-3 form-group mt-3">
               <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
   $("#subcategory_id").select2({
     theme: "classic"
   });
</script>
<script type="text/javascript">
   $("#brand").select2({
     theme: "classic"
   });
</script>
<script type="text/javascript">
   $("#material").select2({
     theme: "classic"
   });
</script>
<script type="text/javascript">
   $("#color").select2({
     theme: "classic"
   });
</script>
<script type="text/javascript">
   $("#size").select2({
     theme: "classic"
   });
</script>
<script type="text/javascript">
   $("#sale_type").select2({
     theme: "classic"
   });
</script>
<script type="text/javascript">
   $("#content_id").select2({
     theme: "classic"
   });
</script>
<script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@43.2.0/build/ckeditor.min.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .then( editor => {
            window.editor = editor;
        } )
        .catch( error => {
            console.error( 'There was a problem initializing the editor.', error );
        } );
</script>
@endsection