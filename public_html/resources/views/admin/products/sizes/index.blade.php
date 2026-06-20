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
<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12 margin-tb">
         <div class="clearfix"></div>
         <div class="row">
            <div class="col-lg-12">
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
                           <th class="bg-light">MRP(IN)</th>
                           <th class="bg-light">Selling(IN)</th>
                           <th class="bg-light">MRP(OTH)</th>
                           <th class="bg-light">Selling(OTH)</th>
                        </tr>
                        <tr>
                           <td>₹{{ $product->in_mrp??'' }}</td>
                           <td>₹{{ $product->in_selling??'' }}</td>
                           <td>₹{{ $product->oth_mrp??'' }}</td>
                           <td>₹{{ $product->oth_selling??'' }}</td>
                        </tr>
                     </thead>
                  </table>
               </div>
            </div>
            <div class="col-lg-12">
               <table class="table table-bordered">
                  <tr>
                     <th class="text-center" style="background: #cacdcf;">Add New Size</th>
                  </tr>
               </table>
               <div class="px-2">
                  <form method="POST" action="{{ route('products.addNewSize', $product) }}" class="row">
                     @csrf
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
                     </div>
                     <div class="col-lg-4 form-group pt-2">
                        <label for="roles_select" class="mb-1">
                        Select Size
                        </label>
                        <select class="js-states form-control" id="size" name="size">
                        @foreach ($sizes??'' as $size)
                        <option value="{{ $size->name??'' }}" @selected(old('size', @$product->size)==$size->name??'')>{{ $size->name??'' }}</option>
                        @endforeach
                        </select>
                        <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('size')" />
                     </div>
                     <div class="col-lg-4 form-group pt-2">
                        <label class="mb-1">Product Code</label>
                        <input type="text" name="sku_code" value="{{ old('sku_code') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
                        <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('sku_code')" />
                     </div>
                     <div class="col-lg-4 form-group pt-2">
                        <label class="mb-1">Enter Stock (Pcs)</label>
                        <input type="number" name="stock_pcs" value="{{ old('stock_pcs', @$product->stock_pcs??0) }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
                        <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('stock_pcs')" />
                     </div>
                     <div class="col-lg-12 pt-3">
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
                                 <input type="number" name="in_selling" value="{{ old('in_selling', @$product->in_selling??0) }}" placeholder="Selling" autocomplete="off" class="form-control shadow-none">
                                 <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('in_selling')" />
                              </td>
                              <td>
                                 <input type="number" name="in_v1_mrp" value="{{ old('in_v1_mrp', @$product->in_v1_mrp??0) }}" placeholder="V1 MRP" autocomplete="off" class="form-control shadow-none">
                                 <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('in_v1_mrp')" />
                              </td>
                           </tr>
                           <tr>
                              <td>Other Country</td>
                              <td>
                                 <input type="number" name="oth_mrp" value="{{ old('oth_mrp', @$product->oth_mrp??0) }}" placeholder="MRP" autocomplete="off" class="form-control shadow-none">
                                 <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('oth_mrp')" />
                              </td>
                              <td>
                                 <input type="number" name="oth_selling" value="{{ old('oth_selling', @$product->oth_selling??0) }}" placeholder="Selling" autocomplete="off" class="form-control shadow-none">
                                 <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('oth_selling')" />
                              </td>
                              <td>
                                 <input type="number" name="oth_v1_mrp" value="{{ old('oth_v1_mrp', @$product->oth_v1_mrp??0) }}" placeholder="V1 MRP" autocomplete="off" class="form-control shadow-none">
                                 <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('oth_v1_mrp')" />
                              </td>
                           </tr>
                        </table>
                        <div class="col-md-3 form-group mt-3">
                           <button type="submit" class="btn btn-success w-100"> <i class="bx bxs-bar-chart-square"></i> Add New Size</button>
                        </div>
                     </div>
                  </form>
               </div>
               <div class="table-responsive pt-3">
                  <table class="table table-bordered table-hover table-striped">
                     @php
                     $sizeGroups = App\Models\Product::sizeGroups($product->product_size_id, $product->id);
                     @endphp
                     <tr>
                        <th>Product Code</th>
                        <th>Size</th>
                        <th>Stock(Pcs)</th>
                        <th>MRP(IN)</th>
                        <th>Selling(IN)</th>
                        <th>MRP(OTH)</th>
                        <th>Selling(OTH)</th>
                     </tr>
                     @foreach($sizeGroups->sortByDesc('id')??'' as $sizePro)
                     <tr>
                        <th>
                           <a href="{{ route('products.show', $sizePro) }}">{{ $sizePro->sku_code??'' }}</a>
                        </th>
                        <td>{{ $sizePro->size??'' }}</td>
                        <td>{{ $sizePro->productAttribute->stock_pcs??'' }}</td>
                        <td>₹{{ $product->in_mrp??'' }}</td>
                        <td>₹{{ $product->in_selling??'' }}</td>
                        <td>₹{{ $product->oth_mrp??'' }}</td>
                        <td>₹{{ $product->oth_selling??'' }}</td>
                     </tr>
                     @endforeach
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
   $("#size").select2({
     theme: "classic"
   });
</script>
@endsection