@extends('admin.layout')
@section('seo_title')
<title>Shipping Weight Charges</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Shipping Weight Charges</li>
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
         <form action="@if(!empty($shippingCharge)) {{ route('shippingCharges.update', $shippingCharge) }} @endif" method="POST" accept-charset="utf-8" class="row" enctype="multipart/form-data">
            @csrf
            @if(!empty($shippingCharge))
            @method('PUT')
            @endif
            <div class="col-lg-12 pt-3">
               <div class="table-responsive">
                  <table class="table table-bordered">
                     <tr>
                        <th class="text-center" style="background: #cacdcf;" colspan="7">Shipping Weight Charges Updates</th>
                     </tr>
                     <tr>
                        <th>w_0_100gm</th>
                        <th>w_101_200gm</th>
                        <th>w_201_400gm</th>
                        <th>w_401_600gm</th>
                        <th>w_601_1000gm</th>
                        <th>w_1001_1500gm</th>
                        <th>w_1501_2000gm</th>
                     </tr>
                     <tr>
                        <td>
                           <input type="number" name="w_0_100gm" value="{{ old('w_0_100gm', @$shippingCharge->w_0_100gm??0) }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
                           <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('w_0_100gm')" />
                        </td>
                        <td>
                           <input type="number" name="w_101_200gm" value="{{ old('w_101_200gm', @$shippingCharge->w_101_200gm??0) }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
                           <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('w_101_200gm')" />
                        </td>
                        <td>
                           <input type="number" name="w_201_400gm" value="{{ old('w_201_400gm', @$shippingCharge->w_201_400gm??0) }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
                           <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('w_201_400gm')" />
                        </td>
                        <td>
                           <input type="number" name="w_401_600gm" value="{{ old('w_401_600gm', @$shippingCharge->w_401_600gm??0) }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
                           <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('w_401_600gm')" />
                        </td>
                        <td>
                           <input type="number" step="any" name="w_601_1000gm" value="{{ old('w_601_1000gm', @$shippingCharge->w_601_1000gm??0) }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
                           <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('w_601_1000gm')" />
                        </td>
                        <td>
                           <input type="number" step="any" name="w_1001_1500gm" value="{{ old('w_1001_1500gm', @$shippingCharge->w_1001_1500gm??0) }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
                           <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('w_1001_1500gm')" />
                        </td>
                        <td>
                           <input type="number" step="any" name="w_1501_2000gm" value="{{ old('w_1501_2000gm', @$shippingCharge->w_1501_2000gm??0) }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
                           <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('w_1501_2000gm')" />
                        </td>
                     </tr>
                     <tr>
                        <th>w_2001_2500gm</th>
                        <th>w_2501_3000gm</th>
                        <th>w_3001_4000gm</th>
                        <th>w_4001_5000gm</th>
                        <th>w_5001_10000gm</th>
                        <th>w_10001_20000gm</th>
                        <th>w_20001_40000gm</th>
                     </tr>
                     <tr>
                        <td>
                           <input type="number" step="any" name="w_2001_2500gm" value="{{ old('w_2001_2500gm', @$shippingCharge->w_2001_2500gm??0) }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
                           <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('w_2001_2500gm')" />
                        </td>
                        <td>
                           <input type="number" step="any" name="w_2501_3000gm" value="{{ old('w_2501_3000gm', @$shippingCharge->w_2501_3000gm??0) }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
                           <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('w_2501_3000gm')" />
                        </td>
                        <td>
                           <input type="number" step="any" name="w_3001_4000gm" value="{{ old('w_3001_4000gm', @$shippingCharge->w_3001_4000gm??0) }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
                           <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('w_3001_4000gm')" />
                        </td>
                        <td>
                           <input type="number" step="any" name="w_4001_5000gm" value="{{ old('w_4001_5000gm', @$shippingCharge->w_4001_5000gm??0) }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
                           <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('w_4001_5000gm')" />
                        </td>
                        <td>
                           <input type="number" step="any" name="w_5001_10000gm" value="{{ old('w_5001_10000gm', @$shippingCharge->w_5001_10000gm??0) }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
                           <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('w_5001_10000gm')" />
                        </td>
                        <td>
                           <input type="number" name="w_10001_20000gm" value="{{ old('w_10001_20000gm', @$shippingCharge->w_10001_20000gm??0) }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
                           <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('w_10001_20000gm')" />
                        </td>
                        <td>
                           <input type="number" name="w_20001_40000gm" value="{{ old('w_20001_40000gm', @$shippingCharge->w_20001_40000gm??0) }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
                           <x-input-error class="mt-2 text-danger error_ipt" :messages="$errors->get('w_20001_40000gm')" />
                        </td>
                     </tr>
                  </table>
                  <div class="col-md-3 form-group mt-3">
                     <x-input-label class="mb-1" for="status" :value="__('Status')" />
                     <select class="form-control shadow-none @error('status') is-invalid @enderror" name="status" id="status">
                        <option value="Active" @selected(old('status',@$shippingCharge->status)=='Active')>Active</option>
                        <option value="InActive" @selected(old('status',@$shippingCharge->status)=='InActive')>InActive</option>
                     </select>
                     <x-input-error class="mt-2" :messages="$errors->get('status')" />
                  </div>
                  <div class="col-md-3 form-group mt-3">
                     <button type="submit" class="btn btn-primary btn-block">Submit</button>
                  </div>
               </div>
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
@endsection