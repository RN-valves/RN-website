@extends('admin.layout')
@section('seo_title')
<title>Home Page Setting</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Home Page Setting</li>
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
         <form action="{{ route('frontPages.update', $frontPage) }}" method="POST" accept-charset="utf-8" class="row" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-lg-4 form-group pt-2">
               <label class="mb-1">Name</label>
               <input type="text" name="name" value="{{ old('name', @$frontPage->name??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('name')" />
            </div>
            <div class="col-lg-4 form-group pt-2">
               <label class="mb-1">Mobile</label>
               <input type="text" name="mobile" value="{{ old('mobile', @$frontPage->mobile??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('mobile')" />
            </div>
            <div class="col-lg-4 form-group pt-2">
               <label class="mb-1">Whatsapp Number</label>
               <input type="text" name="whatsapp" value="{{ old('whatsapp', @$frontPage->whatsapp??'') }}" maxlength="10" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('whatsapp')" />
            </div>
            <div class="col-lg-4 form-group pt-2">
               <label class="mb-1">Email</label>
               <input type="text" name="email" value="{{ old('email', @$frontPage->email??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('email')" />
            </div>
            <div class="col-lg-4 form-group pt-2">
               <label class="mb-1">Logo (PNG or SVG format)</label>
               <input type="file" name="logo" accept=".png,.svg,image/png,image/svg+xml" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('logo')" />
               <a target="_blank" href="{{ url($frontPage->logo??'') }}">Click to view Logo</a>
            </div>
            <div class="col-lg-12 form-group pt-2">
               <label class="mb-1">Title</label>
               <input type="text" name="title" value="{{ old('title', @$frontPage->title??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('title')" />
            </div>
            <div class="col-lg-12 form-group pt-2">
               <label class="mb-1">Keywords</label>
               <input type="text" name="keywords" value="{{ old('keywords', @$frontPage->keywords??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('keywords')" />
            </div>
            <div class="col-lg-12 form-group pt-2">
               <label class="mb-1">Description</label>
               <input type="text" name="description" value="{{ old('description', @$frontPage->description??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('description')" />
            </div>
            <div class="col-lg-12 form-group pt-2">
               <label class="mb-1">Address (opt)</label>
               <input type="text" name="address" value="{{ old('address', @$frontPage->address??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('address')" />
            </div>
            <div class="col-lg-12 form-group pt-2">
               <label class="mb-1">Facebook Link (opt)</label>
               <input type="text" name="fb_link" value="{{ old('fb_link', @$frontPage->fb_link??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('fb_link')" />
            </div>
            <div class="col-lg-12 form-group pt-2">
               <label class="mb-1">Instagram Link (opt)</label>
               <input type="text" name="insta_link" value="{{ old('insta_link', @$frontPage->insta_link??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('insta_link')" />
            </div>
            <div class="col-lg-12 form-group pt-2">
               <label class="mb-1">Twitter Link (opt)</label>
               <input type="text" name="twitter_link" value="{{ old('twitter_link', @$frontPage->twitter_link??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('twitter_link')" />
            </div>
            <div class="col-lg-12 form-group pt-2">
               <label class="mb-1">Linkedin Link (opt)</label>
               <input type="text" name="linkedin_link" value="{{ old('linkedin_link', @$frontPage->linkedin_link??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('linkedin_link')" />
            </div>
            <div class="col-lg-12 form-group pt-2">
               <label class="mb-1">Youtube Link (opt)</label>
               <input type="text" name="youtube_link" value="{{ old('youtube_link', @$frontPage->youtube_link??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('youtube_link')" />
            </div>
            <div class="col-lg-12 form-group pt-2">
               <label class="mb-1">Pinterest Link (opt)</label>
               <input type="text" name="pinterest_link" value="{{ old('pinterest_link', @$frontPage->pinterest_link??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('pinterest_link')" />
            </div>
            <div class="col-lg-12 form-group pt-2">
               <label class="mb-1">Goole Play Store Application URL (opt)</label>
               <input type="text" name="goole_app_link" value="{{ old('goole_app_link', @$frontPage->goole_app_link??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('goole_app_link')" />
            </div>
            <div class="col-lg-12 form-group pt-2">
               <label class="mb-1">IOS Application URL (opt)</label>
               <input type="text" name="ios_app_link" value="{{ old('ios_app_link', @$frontPage->ios_app_link??'') }}" class="form-control shadow-none" placeholder="Enter Value" autocomplete="off">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('ios_app_link')" />
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