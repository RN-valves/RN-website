<div class="col-lg-12">
   <div class="card">
      <div class="card-header p-1">

         @can('product-list')
         <a href="{{ route('products.show',$product) }}" class="btn border btn-sm @if(request()->routeIs('products.show'))  active btn-secondary @else btn-default @endif"><i class="bx bx-add-to-queue"></i> Product Details</a>
         @endcan

         @can('create-new-product-color')
         <a href="{{ route('products.addNewColor',$product) }}" class="btn border btn-sm @if(request()->routeIs('products.addNewColor'))  active btn-secondary @else btn-default @endif"><i class="bx bx-add-to-queue"></i> Add New Color</a>
         @endcan

         @can('create-new-product-size')
         <a href="{{ route('products.addNewSize',$product) }}" class="btn border btn-sm @if(request()->routeIs('products.addNewSize'))  active btn-secondary @else btn-default @endif"><i class="bx bx-add-to-queue"></i> Add New Size</a>
         @endcan

      </div>

      <div class="card-body pt-3 pb-1">
         <div class="pull-left">
            <h2 class="mb-0">
               <small>{{ $product->name??'' }} - PR{{ $product->id??'' }}</small>
               <div class="float-end">
                  <div class="">
                     <span class="text-muted">MRP(IN) : <strong> ₹{{ $product->in_mrp??'' }}</strong></span>
                     @can('product-edit')
                     <a class="btn btn-primary btn-sm" href="{{ route('products.edit', $product) }}"> <i class="bx bx-edit-alt"></i> Edit Product</a>
                     @endcan
                     @can('product-list')
                     <a class="btn btn-warning btn-sm" href="{{ route('products.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>
                     @endcan
                  </div>
               </div>
            </h2>
         </div>
      </div>

   </div>
</div>