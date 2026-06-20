@extends('admin.layout')
@section('seo_title')
<title>Remark Create</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Create Remark</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body bg-light py-3">
      <div class="row">
         <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
               <h2>
                  <div class="float-end">
                     @can('user-list')
                     <a class="btn btn-warning" href="{{ route('remarks.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>
                     @endcan
                  </div>
               </h2>
            </div>
         </div>
      </div>

      <form action="{{ route('remarks.store') }}" method="POST" class="row g-3">
         @csrf
         <div class="col-md-6">
            <div class="form-group">
               <label for="type">Select Type</label>
               <select name="type" class="form-control shadow-none">
                  @foreach($types??'' as $type)
                  <option value="{{ $type }}" @selected(old('type', @$remark->type)==$type)>{{ $type }}</option>
                  @endforeach
               </select>
               <x-input-error class="mt-2 text-danger" :messages="$errors->get('type')" />
            </div>
         </div>
         <div class="col-md-6">
            <div class="form-group">
               <label for="name">Name</label>
               <input type="text" name="name" id="name" class="form-control shadow-none @error('name') is-invalid @enderror" autocomplete="off" placeholder="Name" value="{{ old('name', @$remark->name) }}">
               <x-input-error class="mt-2 text-danger" :messages="$errors->get('name')" />
            </div>
         </div>
         <div class="col-md-12">
            <div class="form-group">
               <label for="description">Description</label>
               <input type="text" name="description" id="description" class="form-control shadow-none @error('description') is-invalid @enderror" autocomplete="off" placeholder="description" value="{{ old('description', @$remark->description) }}">
               <x-input-error class="mt-2 text-danger" :messages="$errors->get('description')" />
            </div>
         </div>
         <div class="form-group">
            <button type="submit" id="btnId" class="btn btn-success">Submit</button>
         </div>
      </form>
      <!-- End floating Labels Form -->
   </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
$("#roles_select").select2({
  theme: "classic"
});
</script>
<script type="text/javascript">
$("#select_user").select2({
  theme: "classic"
});
</script>
@endsection