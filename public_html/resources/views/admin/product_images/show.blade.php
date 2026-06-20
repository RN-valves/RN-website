@extends('admin.layout')
@section('seo_title')
<title>Product</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Product</li>
@endsection
@section('content')
<div class="card">
   <div class="card-header p-1">
      <div class="card-body pt-3 pb-1">
         <div class="pull-left">
            <h2 class="mb-0">
               <small>{{ $product->name??'' }} - PR{{ $product->id??'' }}</small>
               <div class="float-end">
                  <div class="">
                     <span class="text-muted">MRP(IN) : <strong> ₹{{ $product->in_mrp??'' }}</strong></span>
                     @can('productImage-edit')
                     <a class="btn btn-primary btn-sm" href="{{ route('productImages.edit', $productImage) }}"> <i class="bx bx-edit-alt"></i> Edit productImage</a>
                     @endcan
                     @can('productImage-list')
                     <a class="btn btn-warning btn-sm" href="{{ route('productImages.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>
                     @endcan
                  </div>
               </div>
            </h2>
         </div>
      </div>
   </div>
   <div class="card-body py-3">
      <div class="col-lg-12 margin-tb">
         <div class="clearfix"></div>
         <div class="row">
            <div class="col-lg-9">
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
            <div class="col-lg-3" style="border-left: 4px solid grey;">
               @can('productImage-delete')
               <form method="POST" action="{{ route('productImages.destroy', $productImage) }}" class="text-center">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger btn-block" type="submit"><i class="fa fa-trash"></i> <b>Delete Image</b></button>
               </form>
               @endcan
               @if(!empty($productImage->image))
               <div class="card-img">
                  <img src="{{ url($productImage->image??'') }}" width="100%">
               </div>
               @endif
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
</script>
@endsection