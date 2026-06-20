@extends('admin.layout')
@section('seo_title')
<title>Careers/Jobs Descriptions Index</title>
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/42.0.1/ckeditor5.css">
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Action Careers/Jobs Descriptions</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="row">
         <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
               <h2>
                  Action Careers/Jobs Descriptions
                  <div class="float-end">
                     @can('career-list')
                     <a class="btn btn-warning" href="{{ route('careers.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>
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
      <form class="row" method="POST" action="@if(!empty($career)) {{ route('careers.update', $career) }} @else {{ route('careers.store') }} @endif" enctype="multipart/form-data">
         @csrf
         @if(!empty($career))
         @method('PUT')
         @endif
         <div class="col-md-12 form-group mt-3">
            <x-input-label class="mb-1" for="password_confirmation" :value="__('Enter title')" />
            <input type="text" name="title" class="form-control shadow-none @error('title') is-invalid @enderror" placeholder="Enter title" value="{{ old('title', @$career->title) }}">
            <x-input-error class="text-danger mt-2" :messages="$errors->get('title')" />
         </div>
         <div class="col-md-12 form-group mt-3">
            <x-input-label class="mb-1" for="designation" :value="__('Enter Designation')" />
            <input type="text" name="designation" class="form-control shadow-none @error('designation') is-invalid @enderror" value="{{ old('designation', @$career->designation) }}">
            <x-input-error class="text-danger mt-2" :messages="$errors->get('designation')" />
         </div>
         <div class="col-md-12 form-group mt-3">
            <x-input-label class="mb-1" for="password_confirmation" :value="__('Enter All Description')" />
            <textarea class="form-control shadow-none editor @error('content') is-invalid @enderror" id="editor" name="content"> {{ old('content', @$career['content']) }} </textarea>
            <x-input-error class="text-danger mt-2" :messages="$errors->get('content')" />
         </div>
         <div class="col-md-3 form-group mt-3">
            <x-input-label class="mb-1" for="Pincode" :value="__('Enter pincode')" />
            <input type="text" name="zipcode" class="form-control shadow-none @error('zipcode') is-invalid @enderror" placeholder="Enter zipcode" id="zipcode" value="{{ old('zipcode', @$career->zipcode) }}">
            <x-input-error class="text-danger mt-2" id="pinError" :messages="$errors->get('zipcode')" />
         </div>
         <div class="col-md-3 form-group mt-3">
            <x-input-label class="mb-1" for="city" :value="__('City')" />
            <input type="text" name="city" class="form-control shadow-none @error('city') is-invalid @enderror" disabled="" placeholder="Enter city" id="city_id" value="{{ old('city', @$career->city) }}">
         </div>
         <div class="col-md-3 form-group mt-3">
            <x-input-label class="mb-1" for="state" :value="__('State')" />
            <input type="text" name="state" class="form-control shadow-none @error('state') is-invalid @enderror" disabled="" placeholder="Enter state" id="state_id" value="{{ old('state', @$career->state) }}">
         </div>
         <div class="col-md-3 form-group mt-3">
            <x-input-label class="mb-1" for="country" :value="__('Country')" />
            <input type="text" name="country" class="form-control shadow-none @error('country') is-invalid @enderror" disabled="" placeholder="Enter country" id="country_id" value="{{ old('country', @$career->country) }}">
         </div>
         <div class="col-md-12 form-group mt-3">
            <x-input-label class="mb-1" for="date" :value="__('Enter Published Date')" />
            <input type="text" name="published_at" id="datepicker" class="form-control shadow-none @error('published_at') is-invalid @enderror" placeholder="Enter published_at" value="{{ old('published_at', @$career->published_at) }}">
            <x-input-error class="text-danger mt-2" :messages="$errors->get('published_at')" />
         </div>
         <div class="col-md-3 form-group mt-3">
            <x-input-label class="mb-1" for="password_confirmation" :value="__('Select Status')" />
            <select class="form-control shadow-none @error('status') is-invalid @enderror" name="status" id="status">
               <option value="">Select Status</option>
               <option value="Active" @selected(old('status',@$career->status)=="Active")>Active</option>
               <option value="InActive" @selected(old('status',@$career->status)=="InActive")>InActive</option>
            </select>
            <x-input-error class="text-danger mt-2" :messages="$errors->get('status')" />
         </div>
         <div class="col-md-3 form-group mt-3">
            <x-input-label class="mb-1" for="attachment" :value="__('Select attachment (Opt) - PDF,Docx')" />
            <input type="file" name="attachment" class="form-control shadow-none @error('attachment') is-invalid @enderror">
            <x-input-error class="text-danger mt-2" :messages="$errors->get('attachment')" />
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
<script type="importmap">
   {
       "imports": {
           "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/42.0.1/ckeditor5.js",
           "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/42.0.1/"
       }
   }
</script>
<script type="module">
   import {
       ClassicEditor,
       Essentials,
       Paragraph,
       Bold,
       Italic,
       Font
   } from 'ckeditor5';
   
   ClassicEditor
       .create( document.querySelector( '#editor' ), {
           plugins: [ Essentials, Paragraph, Bold, Italic, Font ],
           toolbar: [
         'undo', 'redo', '|', 'bold', 'italic', '|',
         'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
           ]
       } )
       .then( editor => {
           window.editor = editor;
       } )
       .catch( error => {
           console.error( error );
       } );
</script>
<script type="text/javascript">
   $(document).ready(function(){
      $("#pinError").hide();
      $("#zipcode").on('keyup', function(){
         var pincode = this.value;

         var zipRegex = /^\d{5}$/;

         if (!zipRegex.test(pincode))
         {
            $("#pinError").show();
         } 

         $("#city_id").html();
         $("#state_id").html();
         $("#country_id").html();
         $.ajax({
            url: '{{ route('pincodes.get_pincode_city_state') }}',
            type: 'POST',
            data: {
               pincode: pincode,
               _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function(result){
               if(result){
                  $("#pinError").hide();
                  $("#city_id").val(result.city.name);
                  $("#state_id").val(result.state.name);
                  $("#country_id").val(result.country.name);
               }else{
                  alert('error');
               }
               
            }
         });
      });
   });
</script>
@endsection