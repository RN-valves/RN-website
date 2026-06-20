@extends('admin.layout')
@section('seo_title')
<title>User Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">{{ $user->name??'' }}</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body">
      <div class="row">
   @include('admin.users.partials.menu')
   @include('admin.users.partials.basic_detail')
</div>
<div class="card">
   <div class="card-body py-3">
      @canany(['user-address-create' , 'user-address-edit'])
      <div class="col-lg-12">
         <form action="{{ route('userAddresses.store') }}" method="POST" accept-charset="utf-8" class="row">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <div class="col-lg-6 form-group pt-2">
               <label>Name</label>
               <input type="text" name="name" value="{{ old('name',@$userAddress->name??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 text-danger" :messages="$errors->get('name')" />
            </div>
            <div class="col-lg-6 form-group pt-2">
               <label>Mobile</label>
               <input type="text" name="mobile" value="{{ old('mobile',@$userAddress->mobile??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 text-danger" :messages="$errors->get('mobile')" />
            </div>
            <div class="col-lg-3 form-group pt-2">
               <label>Pincode</label>
               <input type="number" name="zipcode" value="{{ old('zipcode',@$userAddress->zipcode??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 text-danger" :messages="$errors->get('zipcode')" />
            </div>
            <div class="col-lg-6">
               <x-input-label class="pt-2" for="type" :value="__('Address Type')" />
               <select class="form-control" name="type">
                  @foreach($addressTypes??'' as $type)
                  <option value="{{ $type }}" @selected(old('type', @$userAddress->type)==$type)>{{ $type }}</option>
                  @endforeach
               </select>
               <x-input-error class="mt-2 text-danger" :messages="$errors->get('type')" />
            </div>
            <div class="col-lg-12 form-group pt-2">
               <label>Address</label>
               <input type="text" name="address" value="{{ old('address',@$userAddress->address??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 text-danger" :messages="$errors->get('address')" />
            </div>
            <div class="col-lg-12 form-group pt-2">
               <button class="btn btn-primary btn-sm" type="submit">Submit</button>
            </div>
         </form>
      </div>
      @endcan
   </div>
</div>
<div class="col-lg-12">
   <div class="table-responsive">
      <h4>Address List</h4>
      <table class="table table-hover table-bordered table-sm">
         <thead>
            <tr>
               <th>ID</th>
               <th>Name</th>
               <th>Mobile</th>
               <th>Pincode</th>
               <th>City</th>
               <th>State</th>
               <th>Type</th>
               <th>Address</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
            @foreach($user->addresses??'' as $user_address)
            <tr>
               <td>{{ $user_address->id??0 }}</td>
               <td>{{ $user_address->name??'NA' }}</td>
               <td>{{ $user_address->mobile??'NA' }}</td>
               <td>{{ $user_address->zipcode??'NA' }}</td>
               <td>{{ $user_address->city->name??'NA' }}</td>
               <td>{{ $user_address->state->name??'NA' }}</td>
               <td>{{ $user_address->type??'NA' }}</td>
               <td>{{ $user_address->address??'NA' }}</td>
               <td>
                  @can('user-address-edit')
                  <a href="{{ route('userAddresses.edit', $user_address) }}" class="btn btn-warning btn-sm"><i class="bx bx-edit-alt"></i>  Edit</a>
                  @endcan
               </td>
            </tr>
            @endforeach
         </tbody>
      </table>
   </div>
</div>
   </div>
</div>
@endsection
@section('scripts')
@endsection