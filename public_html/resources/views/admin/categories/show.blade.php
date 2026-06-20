@extends('admin.layout')
@section('seo_title')
<title>Category Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Categories</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h2>
               <div class="float-end">
                  @can('category-edit')
                  <a class="btn btn-info btn-sm" href="{{ route('categories.edit', $category) }}"> <i class="bx bx-edit-alt"></i> Edit category</a>
                  @endcan
                  @can('category-list')
                  <a class="btn btn-warning btn-sm" href="{{ route('categories.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>
                  @endcan
               </div>
            </h2>
         </div>
      </div>
      <div class="clearfix"></div>
      <div class="row">
         @can('bullet-point-create')
         <div class="card pt-4">
            <div class="card-body">
               <form class="row" method="POST" action="{{ route('bPoints.store') }}">
                  @csrf
                  <input type="hidden" name="model_type" value="Category">
                  <input type="hidden" name="model_id" value="{{ $category->id }}">
                  <div class="col-md-9 form-group">
                     <input type="text" name="name" class="form-control shadow-none @error('name') is-invalid @enderror" placeholder="Enter Name" value="{{ old('name') }}">
                     <x-input-error class="mt-2" :messages="$errors->get('name')" />
                  </div>
                  <div class="col-md-3 form-group">
                     <button type="submit" class="btn btn-dark btn-block">Add Bullet Point</button>
                  </div>
               </form>
            </div>
         </div>
         @endcan
         <div class="col-lg-12">
            <div class="card-header">
               <h5 class="mb-0">
                  <strong class="text-dark">CAT{{ $category->id }} : {{ $category->name??'' }}</strong>
                  <span class="float-end text-dark text-bold">Discount % : {{ $category->discount??0 }}</span>
               </h5>
               <p class="mb-0">{{ $category->uuid??'' }}</p>
               <p class="mb-0 btn btn-warning btn-sm"><strong>is_visible_website?</strong> 
                  @if($category->is_visible_website==0)
                  <span class="text-danger">No</span>
                  @else
                  <span class="text-success">Yes</span>
                  @endif
               </p>
            </div>
            <div class="card-footer">
               @foreach($category->subcategories??'' as $subcategory)

               @can('subcategory-list')
               <a href="{{ route('subcategories.show', $subcategory) }}">
                  <span class="badge badge-sm bg-info">{{ $subcategory->name??'' }}</span>
               </a>
               @else
               <span class="badge badge-sm bg-info">{{ $subcategory->name??'' }}</span>
               @endcan
               
               @endforeach
            </div>
         </div>
         <div class="col-lg-9">
            <div class="card-body">
               <p class="mb-0 text-bold card-title">Bullet Points</p>
               <table class="table table-bordered table-striped">
                  <tr>
                     <th>Id</th>
                     <th>Title</th>
                     <th>Action</th>
                  </tr>
                  @foreach($category->bullet_points??'' as $bpoint)
                  <tr>
                     <td>{{ $bpoint->id??'' }}</td>
                     <td>{{ $bpoint->name??'' }}</td>
                     <td>
                        @can('bullet-point-delete')
                        <form method="POST" action="{{ route('bPoints.destroy', $bpoint) }}" class="text-center">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit"><i class="bx bx-trash"></i> </button>
                        </form>
                        @endcan
                     </td>
                  </tr>
                  @endforeach
               </table>
               <hr>
               <p class="mb-0">{!! $category->content->content??'' !!}</p>
               <p class="mb-0 text-bold card-title">SEO Title</p>
               <p class="mb-0">{{ $category->title??'' }}</p>
               <p class="mb-0 text-bold card-title">SEO Keywords</p>
               <p class="mb-0">{{ $category->keywords??'' }}</p>
               <p class="mb-0 text-bold card-title">SEO Description</p>
               <p class="mb-0">{{ $category->description??'' }}</p>
            </div>
         </div>
         <div class="col-lg-3">
            <div class="row">
               <div class="col-lg-12">
                  <div class="card-header">
                     <h5 class="mb-0 text-dark text-center">Category Banner</h5>
                  </div>
                  @if(!empty($category->banner))
                  <div class="card-img">
                     <img src="{{ url($category->banner??'') }}" width="100%">
                  </div>
                  @endif
               </div>
               <div class="col-lg-12">
                  <div class="card-header">
                     <h5 class="mb-0 text-dark text-center">Category Image</h5>
                  </div>
                  @if(!empty($category->image))
                  <div class="card-img">
                     <img src="{{ url($category->image??'') }}" width="100%">
                  </div>
                  @endif
               </div>
               <div class="col-lg-12">
                  <div class="card-header">
                     <h5 class="mb-0 text-dark text-center">Category Icon</h5>
                  </div>
                  @if(!empty($category->icon))
                  <div class="card-img">
                     <img src="{{ url($category->icon??'') }}" width="100%">
                  </div>
                  @endif
               </div>
            </div>
         </div>
         @if(!empty($category->pdf_catalogue))
         <div class="col-lg-12">
            <div class="card">
               <div class="card-header p-0">
                  <a target="_blank" href="{{ url($category->pdf_catalogue??"") }}">
                     PDF Catalogue
                  </a>
               </div>
            </div>
         </div>
         @endif
      </div>
   </div>
</div>
@endsection
@section('scripts')
@endsection