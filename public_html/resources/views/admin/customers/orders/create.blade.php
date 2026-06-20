@extends('admin.layout')
@section('seo_title')
<title>User Create</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Create User</li>
@endsection
@section('content')
@php
$categories = App\Models\Category::take(8)->get();
$latestCategories = App\Models\Category::latest()->take(6)->get();
@endphp
@include('admin.users.partials.basic_detail')
<nav class="navbar navbar-expand-sm navbar-light" style="background: #e3e0e0;white-space: wrap!important;border-bottom: 1px solid black;">
   <div class="container-fluid">
      <div class="collapse navbar-collapse" id="collapsibleNavbar">
         <ul class="navbar-nav">
            @foreach($categories??'' as $category)
            <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ $category->name??'' }}</a>
               <ul class="dropdown-menu">
                  @foreach(App\Models\Category::getCatSubcategories($category->id)??'' as $subcategory)
                  <li><a class="dropdown-item" href="{{ route('customers.orderCreate', ['user'=>$user, 'url_key'=>$subcategory]) }}">{{ $subcategory->name??'' }}</a></li>
                  @endforeach
               </ul>
            </li>
            @endforeach
         </ul>
      </div>
   </div>
</nav>
<nav class="navbar navbar-expand-sm navbar-light" style="background: #e3e0e0;white-space: wrap!important;">
   <div class="container-fluid">
      <div class="collapse navbar-collapse" id="collapsibleNavbar">
         <ul class="navbar-nav">
            @foreach($latestCategories??'' as $category)
            <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ $category->name??'' }}</a>
               <ul class="dropdown-menu">
                  @foreach(App\Models\Category::getCatSubcategories($category->id)??'' as $subcategory)
                  <li><a class="dropdown-item" href="{{ route('customers.orderCreate', ['user'=>$user, 'url_key'=>$subcategory]) }}">{{ $subcategory->name??'' }}</a></li>
                  @endforeach
               </ul>
            </li>
            @endforeach
         </ul>
      </div>
   </div>
</nav>
<div class="card mt-2">
   <div class="card-body bg-light py-3">
      <form method="GET" class="row">
         @csrf
         <div class="col-md-9">
            <input type="text" name="q" class="form-control" placeholder="enter keyword for search product" value="@if(!empty(request('q'))) {{ request('q') }} @endif">
            <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('q')" />
         </div>
         <div class="col-md-3">
            <button class="btn btn-dark btn-sm">Search / Filter Product</button>
            <a href="{{ route('customers.orderCreate', $user) }}" class="btn btn-warning btn-sm">Clear</a>
         </div>
      </form>
      <div class="row mt-2">
         <div class="col-md-7">
            <div class="table-responsive">
               @if(!empty($productsList))
               {{ $productsList->withQueryString()->links() }}
               <table class="table table-bordered table-striped product_data">
                  <tr>
                     <th>Product</th>
                     <th class="text-center">Art/Color</th>
                     <th class="text-center">MRP</th>
                     <th class="text-center">QTY</th>
                     <th class="text-center">Action</th>
                  </tr>
                  @foreach($productsList as $key => $product)
                    <form class="addToCartForm" method="post" action="{{ route('customers.orderAddToCart') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                      <tr>
                         <td>{{ $product->name??'' }} - {{ $product->size??'' }} ({{ $product->sku_code??''}} - {{ $product->subcategory->name??'' }})</td>
                         <td class="text-center">
                            <small>{{ $product->article??'' }}</small><br>
                            <small>{{ $product->color_name??'' }}</small>
                         </td>
                         @if($user->country_id==1)
                         <td class="text-center"><input type="number" step="any" name="price" id="price" value="{{ $product->in_selling??'' }}" class="text-center"></td>
                         @else
                         <td class="text-center"><input type="number" step="any" name="price" id="price" value="{{ $product->oth_selling??'' }}" class="text-center"></td>
                         @endif
                         <td class="text-center">
                            <input type="number" name="quantity" data-productid="{{ $product->id }}" id="quantity" min="1" value="1" class="text-center quantity">
                         </td>
                         <td class="text-center">
                            {{-- <span class="btn btn-dark btn-sm addToCart" data-productid="{{ $product->id }}">Add</span> --}}
                            <input type="submit" name="submit" value="Add">
                         </td>
                      </tr>
                    </form>
                  @endforeach
               </table>
               @endif
            </div>
         </div>
         <div class="col-md-5" id="">
            <form action="{{ route('customers.orderCreate', $user) }}" id="saveOrderForm" method="POST" accept-charset="utf-8">
                @csrf
                <div align="right"><a href="{{ route('cartEmpty') }}" class="btn btn-dark btn-sm">Clear Cart Items <i class="bx bx-trash-alt"></i></a></div>
                <div id="AppendCartItems">
                    @include('admin.customers.orders.cart_items')
                </div>
                <table class="table table-bordered">
                  <tr>
                     <th colspan="3" style="text-align: right;"> Shipping Charges + </th>
                     <td colspan="2" style="text-align: right;">
                        <input type="number" class="form-control" name="shipping_amount" id="shipping_amount" min="0" value="{{ old('shipping_amount') }}">
                        <x-input-error class="mt-2" :messages="$errors->get('shipping_amount')" />
                     </td>
                  </tr>
                  <tr>
                     <th colspan="3" style="text-align: right;" class="text-success">Discount - </th>
                     <td colspan="2" style="text-align: right;">
                        <input type="number" class="form-control" name="discount_amount" step="any" id="discount_amount" value="{{ old('discount_amount') }}">
                        <x-input-error class="mt-2" :messages="$errors->get('discount_amount')" />
                     </td>
                  </tr>
                  <tr>
                     <th colspan="3" style="text-align: right;">Select Customer Shipping Address</th>
                     <td colspan="2" style="text-align: right;">
                        <select name="shipping_charge_id" class="form-control">
                           @foreach($user->addresses??'' as $address)
                           <option value="{{ $address->id }}" @selected(old('shipping_charge_id')==$address->id)>{{ $address->mobile??'' }}-{{ $address->zipcode??'' }}</option>
                           @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('shipping_charge_id')" />
                     </td>
                  </tr>
                  <tr>
                     <th colspan="3" style="text-align: right;">Select Payment Terms</th>
                     <td colspan="2" style="text-align: right;">
                        <select name="payment_term" class="form-control">
                           <option value="100% Advanced" @selected(old('payment_term')=='100% Advanced')>100% Advanced</option>
                           <option value="Credit" @selected(old('payment_term')=='Credit')>Credit</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('payment_term')" />
                     </td>
                  </tr>
                  <tr>
                     <th colspan="3" style="text-align: right;">Note/Remarks(opt)</th>
                     <td colspan="2" style="text-align: right;">
                        <textarea class="form-control" name="note" rows="3" placeholder="Query">{{ old('note') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('note')" />
                     </td>
                  </tr>
                </table>
                <button class="btn btn-dark saveOrderButton" type="submit">Save Order</button>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
<script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>

<script type="text/javascript">
$(document).ready(function () {
   $("#saveOrderForm").submit(function (e) {
      $(".saveOrderButton").attr("disabled", true);
      return true;
   });
});
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('.addToCartForm').submit(function(e) {
        e.preventDefault();
            var url = $(this).attr("action");
            let formData = new FormData(this);
            for(item of formData){
                console.log(item[0], item[1]);
            }
            $.ajax({
                url: $(this).attr("action"),
                type: $(this).attr("method"),
                data : formData,
                dataType:"JSON",
                processData : false,
                contentType:false,
                
             success: function(response) {

                if (response.errors) {
                    var errorMsg = '';
                    $.each(response.errors, function(field, errors) {
                        $.each(errors, function(index, error) {
                            errorMsg += error + '<br>';
                        });
                    });
                    iziToast.error({
                        message: errorMsg,
                        position: 'topRight'
                    });
                    
                } else {
                   $("#AppendCartItems").html(response.success);
                }
                         
            },
         
            });
        });
    });
</script>

<script type="text/javascript">
   $(document).on('click','.removeCartItem', function() {
        var cartid = $(this).data('cartid');
        $.ajax({
          data:{
            "_token": "{{ csrf_token() }}",
            cartid:cartid,
          },
          url: "{{ route('customers.ordercartRemoveItem') }}",
          type:"POST",
            success:function(data){
                if(data.status==false){
                    alert(data.message);
                }
                $("#AppendCartItems").html(data.success);
            },error:function(){
                alert("Error");
            }
        });
    });
</script>
<script type="text/javascript">
   $(document).on('click','.btnItemUpdate', function() {
        if($(this).hasClass('qtyMinus')){
            var quantity = $(this).prev().val();
            if(quantity<=1){
                alert("Item quantity must be 1 or Greater!");
                return false;
            }else{ 
                new_qty = parseInt(quantity)-1;
            }
        }
        if($(this).hasClass('qtyPlus')){
            var quantity = $(this).prev().prev().val();
            new_qty = parseInt(quantity)+1;
        }
        var cartid = $(this).data('cartid');
        $.ajax({
          data:{"_token": "{{ csrf_token() }}",
            cartid:cartid,
            new_qty:new_qty,
          },
          url: "{{ route('customers.customerCartUpdate') }}",
          type:"POST",
            success:function(data){
                if(data.status==false){
                    alert(data.message);
                }
                $("#AppendCartItems").html(data.success);
            },error:function(){
                alert("Error");
            }
        });
    });
</script>
<script type="text/javascript">
   $("#roles_select").select2({
     theme: "classic"
   });
</script>
@endsection
