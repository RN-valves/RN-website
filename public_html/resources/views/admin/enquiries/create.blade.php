@extends('admin.layout')
@section('seo_title')
<title>Enquiry</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Enquiry</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12">

         {{-- @if (count($errors) > 0)
         <div class="alert alert-danger">
            <strong>Whoops! </strong> There were some problems with your input.<br><br>
            <ul>
               @foreach ($errors->all() as $error)
               <li>{{ $error }}</li>
               @endforeach
            </ul>
         </div>
         @endif --}}
         <form action="{{ route('enquiries.store') }}" method="POST" accept-charset="utf-8" class="row">
            @csrf
            <div class="col-lg-4 mb-3">
               <label for="roles_select" style="width:100%;">
                 Select Enquiry Type
               </label>
                 <select class="js-states form-control" id="enquiry_type" name="enquiry_type">
                     @foreach ($types as $type)
                     <option value="{{ $type }}" @selected(old('enquiry_type', @$enquiry->enquiry_type)==$type)>{{ $type }}</option>
                     @endforeach
                 </select>
                  <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('enquiry_type')" />
            </div>
            <div class="col-lg-4 mb-3">
               <label for="roles_select" style="width:100%;">
                 Select Scource
                 <select class="js-states form-control" id="scource_type" name="scource_type">
                     @foreach ($scources as $scource)
                     <option value="{{ $scource }}" @selected(old('scource_type', @$enquiry->scource_type)==$scource)>{{ $scource }}</option>
                     @endforeach
                 </select>
                  <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('scource_type')" />
               </label>
            </div>
            

            @if(auth()->user()->id==1 || empty(@$enquiry))
            <div class="col-lg-4 mb-3">
               <label for="roles_select" style="width:100%;">
                 Assigned To
                 <select class="js-states form-control" id="salesmen_id" name="salesmen_id">
                     @foreach ($users as $user)
                     <option value="{{ $user->id }}" @selected(old('salesmen_id', @$enquiry->salesmen_id)==$user->id)>{{ $user->name??'' }} {{ $user->mobile??'' }}</option>
                     @endforeach
                 </select>
                  <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('salesmen_id')" />
               </label>
            </div>
            @else
            <div class="col-lg-4 mb-3">
               <label for="roles_select" style="width:100%;">
                 Assigned To
               </label>
               <input type="hidden" name="salesmen_id" value="{{ @$enquiry->salesmen_id }}">
               <input type="text" value="{{ @$enquiry->salesmen->name??'' }}" disabled="" class="form-control">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('salesmen_id')" />
            </div>
            @endif


            <div class="col-lg-4 form-group pt-2">
               <label class="mb-1">Published Date</label>
               <input type="text" name="published_at" id="datepicker" value="{{ old('published_at', @$enquiry->published_at??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('published_at')" />
            </div>
            <div class="col-lg-4 form-group pt-2">
               <label class="mb-1">Name</label>
               <input type="text" name="name" value="{{ old('name', @$enquiry->name??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('name')" />
            </div>
            <div class="col-lg-4 form-group pt-2">
               <label class="mb-1">Company Name</label>
               <input type="text" name="company_name" value="{{ old('company_name', @$enquiry->company_name??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('company_name')" />
            </div>
            <div class="col-lg-6 form-group pt-2">
               <label class="mb-1">Mobile</label>
               <input type="text" name="mobile" value="{{ old('mobile', @$enquiry->mobile??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('mobile')" />
            </div>
            <div class="col-lg-6 form-group pt-2">
               <label class="mb-1">Email (Opt)</label>
               <input type="text" name="email" value="{{ old('email', @$enquiry->email??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('email')" />
            </div>
            <div class="col-lg-3 form-group pt-2">
               <label class="mb-1">Pincode</label>
               <input type="text" name="zipcode" value="{{ old('zipcode', @$enquiry->zipcode??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('zipcode')" />
            </div>
            <div class="col-lg-9 form-group pt-2">
               <label class="mb-1">Address</label>
               <input type="text" name="address" value="{{ old('address', @$enquiry->address??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('address')" />
            </div>
            <div class="col-lg-12 form-group pt-2">
               <label class="mb-1">Purpose/Message*</label>
               <input type="text" name="purpose" value="{{ old('purpose', @$enquiry->purpose??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('purpose')" />
            </div>
            <div class="col-lg-12 form-group pt-2">
               <button class="btn btn-primary btn-sm" type="submit">Submit</button>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
$("#enquiry_type").select2({
  theme: "classic"
});
</script>
<script type="text/javascript">
$("#scource_type").select2({
  theme: "classic"
});
</script>
<script type="text/javascript">
$("#salesmen_id").select2({
  theme: "classic"
});
</script>
@endsection