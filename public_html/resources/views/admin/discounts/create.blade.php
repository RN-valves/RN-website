@extends('admin.layout')
@section('seo_title')
<title>Discount Code Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Action Discount Code</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="row">
         <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
               <h2>
                  Action Discount Code
                  <div class="float-end">
                     @can('discount-list')
                     <a class="btn btn-warning" href="{{ route('discounts.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>
                     @endcan
                  </div>
               </h2>
            </div>
         </div>
      </div>
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
      <form class="row" method="POST" action="@if(!empty($discount)) {{ route('discounts.update', $discount) }} @else {{ route('discounts.store') }} @endif" enctype="multipart/form-data">
         @csrf
         @if(!empty($discount))
         @method('PUT')
         @endif
         <div class="col-md-4 form-group mt-3">
            <x-input-label class="mb-1" for="Name" :value="__('Enter Name/Enter Code')" />
            <input type="text" name="name" class="form-control shadow-none @error('name') is-invalid @enderror" placeholder="Enter Name" value="{{ old('name', @$discount->name) }}">
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
         </div>
         <div class="col-md-4 form-group mt-3">
            <x-input-label class="mb-1" for="start_value" :value="__('Start Amount')" />
            <input type="number" name="start_value" class="form-control shadow-none @error('start_value') is-invalid @enderror" placeholder="Enter start_value" value="{{ old('start_value', @$discount->start_value) }}">
            <x-input-error class="mt-2" :messages="$errors->get('start_value')" />
         </div>
         <div class="col-md-4 form-group mt-3">
            <x-input-label class="mb-1" for="end_value" :value="__('End Amount')" />
            <input type="number" name="end_value" class="form-control shadow-none @error('end_value') is-invalid @enderror" placeholder="Enter end_value" value="{{ old('end_value', @$discount->end_value) }}">
            <x-input-error class="mt-2" :messages="$errors->get('end_value')" />
         </div>
         <div class="col-md-3 form-group mt-3">
            <x-input-label class="mb-1" for="type" :value="__('Discount Type')" />
            <select class="form-control shadow-none @error('type') is-invalid @enderror" name="type" id="type">
            <option value="Amount" @selected(old('type',@$discount->type)=='Amount')>Fixed Amount</option>
            <option value="Percent" @selected(old('type',@$discount->type)=='Percent')>Percent</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('type')" />
         </div>
         <div class="col-md-3 form-group mt-3">
            <x-input-label class="mb-1" for="Value" :value="__('Enter Value')" />
            <input type="text" name="value" class="form-control shadow-none @error('value') is-invalid @enderror" placeholder="Enter value" value="{{ old('value', @$discount->value) }}">
            <x-input-error class="mt-2" :messages="$errors->get('value')" />
         </div>
         <div class="col-md-3 form-group mt-3">
            <x-input-label class="mb-1" for="Expire" :value="__('Expire Date')" />
            <input type="text" name="expired_at" id="datepicker" class="form-control shadow-none @error('expired_at') is-invalid @enderror" placeholder="Enter expired_at" expired_at="{{ old('expired_at', @$discount->expired_at) }}">
            <x-input-error class="mt-2" :messages="$errors->get('expired_at')" />
         </div>
         <div class="col-md-3 form-group mt-3">
            <x-input-label class="mb-1" for="status" :value="__('Discount Status')" />
            <select class="form-control shadow-none @error('status') is-invalid @enderror" name="status" id="status">
            <option value="Active" @selected(old('status',@$discount->status)=='Active')>Active</option>
            <option value="InActive" @selected(old('status',@$discount->status)=='InActive')>InActive</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('status')" />
         </div>
         <div class="col-md-12 form-group mt-3">
            <button type="submit" class="btn btn-primary btn-block">Submit</button>
         </div>
      </form>
   </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
   $("#parent_id").select2({
     theme: "classic"
   });
</script>
<script type="text/javascript">
   $("#content_id").select2({
     theme: "classic"
   });
</script>
@endsection