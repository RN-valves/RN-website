@extends('admin.layout')
@section('seo_title')
<title>Product Bullet  Point Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Product Bullets Point </li>
@endsection
@section('content')
<div class="card">
   <div class="card-body pt-3 pb-0 mb-0">
      @can('product-bullet-point-excel')
         <a class="btn btn-success btn-sm" href="{{ route('productBullets.import_pro_bullet') }}"> <i class="bx bx-add-to-queue"></i> Upload excel</a>
      @endcan
   </div>
   @can('product-bullet-point-create')
   <div class="card-body pt-3 pb-0 mb-0">
      <form method="POST" action="{{ route('productBullets.store') }}" class="row">
         @csrf
         <div class="col-md-9 form-group">
            <input type="text" name="name" class="form-control shadow-none @error('name') is-invalid @enderror" placeholder="Enter Name" value="{{ old('name') }}">
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
         </div>
         <div class="col-md-3 form-group">
            <button class="btn btn-dark w-100">Add/Update Points</button>
         </div>
      </form>
   </div>
   @endcan
   <div class="card-body py-3">
      <livewire:product-bullet-index/>
   </div>
</div>
@endsection
@section('scripts')
@endsection