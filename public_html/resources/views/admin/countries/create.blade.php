@extends('admin.layout')
@section('seo_title')
<title>Countries Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Create New Country</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="row">
         <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
               <h2>
                  Create New User
                  <div class="float-end">
                     @can('country-list')
                     <a class="btn btn-warning" href="{{ route('countries.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>
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
      <form action="{{ route('countries.store') }}" method="POST" class="row g-3">
         @csrf
         <div class="col-md-6">
            <div class="form-floating">
               <input type="text" name="name" id="name" class="form-control shadow-none @error('name') is-invalid @enderror" autocomplete="off" placeholder="India" value="{{ old('name') }}">
               <x-input-error class="mt-2" :messages="$errors->get('name')" />
               <label for="name">Country Name</label>
            </div>
         </div>
         <div class="col-md-6">
            <div class="form-floating">
               <input type="text" name="code" id="code" class="form-control shadow-none @error('code') is-invalid @enderror" autocomplete="off" placeholder="+91" value="{{ old('code') }}">
               <x-input-error class="mt-2" :messages="$errors->get('code')" />
               <label for="code">Country Code</label>
            </div>
         </div>
         <div class="">
            <button type="submit" id="btnId" class="btn btn-success">Submit</button>
         </div>
      </form>
   </div>
</div>
@endsection