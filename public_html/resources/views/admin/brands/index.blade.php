@extends('admin.layout')
@section('seo_title')
<title>Brand Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Brand</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="row">
      <table class="table table-bordered table-sm">
         <tr>
            <th>#</th>
            <th>Name</th>
            <th>Products</th>
            <th>Logo</th>
         </tr>
         @foreach($brands??'' as $brand)
         <tr>
            <td>{{ $brand->id??'' }}</td>
            <td> <a href="{{ route('brands.show', $brand) }}"> <strong>{{ $brand->name??'' }}</strong> </a></td>
            <td>0</td>
            <td><img src="{{ url($brand->logo??'') }}" alt="" width="50px"></td>
         </tr>
         @endforeach
      </table>
   </div>
</div>
@endsection