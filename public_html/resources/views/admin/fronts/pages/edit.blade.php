@extends('admin.layout')
@section('seo_title')
<title>Content Setting</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Page Setting</li>
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
         <form action="{{ route('page.update') }}" method="POST" accept-charset="utf-8" class="row" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{@$data->url_key}}" name="url_key">
            <div class="col-lg-4 form-group pt-2">
               <label class="mb-1">Title</label>
               <input type="text" name="title" value="{{old('title',@$data->title)}}" class="form-control shadow-none" placeholder="Enter Title" autocomplete="off">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('title')" />
            </div>
            <div class="col-lg-12 form-group pt-2">
               <label class="mb-1">Description</label>
               <textarea class="form-control shadow-none editor @error('description') is-invalid @enderror" id="editor" name="description"> {{ old('description',@$data->description)}} </textarea>
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('description')" />
            </div>
          
          
            <div class="col-lg-12 form-group py-2 text-center">
               <button class="btn btn-primary btn-sm float-end" type="submit">Update</button>
            </div>
         </form>
         <hr>
         @if(@$data->url_key == 'certificates')
         <form action="{{ route('certificates.store') }}" method="POST" accept-charset="utf-8" class="row" enctype="multipart/form-data">
            @csrf
            <div class="col-lg-4 form-group py-2">
               <label class="mb-1">Upload Certificate</label>
               <input type="file" name="image" value="{{old('image')}}" class="form-control shadow-none" autocomplete="off">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('image')" />
            </div>
            <div class="col-lg-4 form-group">
               <button class="btn btn-primary mt-4">Add</button>
            </div>
            <div class="blog_right_side row">
                @foreach($certis as $cert)
               <div class="col-lg-3">
                  <div class="card">
                     <div class="card-img rn_proframebox">
                        <img src="{{ asset($cert->image) }}" width="100%">
                     </div>
                     <div class="d-flex mt-1">
                     <i class="btn btn-danger btn-sm bx bx-trash" 
                        style="width: 30px;" 
                        data-id="{{ $cert->id }}" 
                        data-url="{{ route('certificates.destroy',$cert->id) }}" 
                        data-bs-toggle="modal" 
                        data-bs-target="#deleteModal"></i>
                    <i class='btn btn-success btn-sm bx bxs-edit' 
                        style="width: 30px;" 
                        data-id="{{ $cert->id }}" 
                        data-url="{{ route('certificates.update',$cert->id) }}" 
                        data-image="{{ asset($cert->image) }}" 
                        data-bs-toggle="modal" 
                        data-bs-target="#updateModal"></i>
                     </div>
                  </div>
               </div>
               @endforeach
            </div>
         </form>
         @endif
         @if(@$data->url_key == 'our-csr')
         <form action="{{ route('page.update') }}" method="POST" accept-charset="utf-8" class="row" enctype="multipart/form-data">
            @csrf
            <div class="col-lg-4 form-group py-2">
               <label class="mb-1">Upload Images(Size: 529*353px)</label>
               <input type="file" name="image" value="{{old('image')}}" class="form-control shadow-none" accept=".jpeg, .png, .jpg, .JPG" autocomplete="off">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('image')" />
            </div>
            <div class="col-lg-4 form-group">
               <button class="btn btn-primary mt-4">Add</button>
            </div>
            <div class="blog_right_side row">
                @foreach($eximages as $imgs)
               <div class="col-lg-3">
                  <div class="card">
                     <div class="card-img rn_proframebox">
                        <img src="{{ asset($imgs->file) }}" width="100%">
                     </div>
                     <div class="d-flex mt-1">
                     <i class="btn btn-danger btn-sm bx bx-trash" 
                        style="width: 30px;" 
                        data-id="{{ $imgs->id }}" 
                        data-url="{{ route('page.update') }}" 
                        data-bs-toggle="modal" 
                        data-bs-target="#deleteModal"></i>
                    <i class='btn btn-success btn-sm bx bxs-edit' 
                        style="width: 30px;" 
                        data-id="{{ $imgs->id }}" 
                        data-url="{{ route('page.update') }}" 
                        data-image="{{ asset($imgs->file) }}" 
                        data-bs-toggle="modal" 
                        data-bs-target="#updateModal"></i>
                     </div>
                  </div>
               </div>
               @endforeach
            </div>
         </form>
         @endif
      </div>
   </div>
</div>
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
    
      <div class="modal-body">
        Are you sure you want to delete this?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <form id="deleteForm" method="POST" action="">
          @csrf
          <input type="hidden" name="form" value="0">
          <input type="hidden" id="delid" name="id" value="">
          @if(@$data->url_key != 'our-csr')
          @method('DELETE')
          @endif
          <button type="submit" class="btn btn-danger">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Update Modal -->

<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateModalLabel">Update</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="updateForm" method="POST" enctype="multipart/form-data">
        @csrf
        @if(@$data->url_key != 'our-csr')
        @method('PUT')
        @endif
        <div class="modal-body">
          <input type="hidden" id="certId" name="id">
          <input type="hidden" name="form" value="1">
          <!-- Certificate Image -->
          <div class="mb-3">
            <label for="certImage" class="form-label">Upload Image</label>
            <input type="file" class="form-control" id="certImage" name="image">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>



@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@43.2.0/build/ckeditor.min.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .then( editor => {
            window.editor = editor;
        } )
        .catch( error => {
            console.error( 'There was a problem initializing the editor.', error );
        } );
</script>
<script>
  $(document).on('click', '.bx-trash', function () {
      const certId = $(this).data('id');
      const deleteUrl = $(this).data('url');
      $('#delid').val(certId);
      $('#deleteForm').attr('action', deleteUrl);
  });
  $(document).on('click', '.bxs-edit', function () {
     
      const certId = $(this).data('id');
      const updateUrl = $(this).data('url');
      const certImage = $(this).data('image');

      $('#certId').val(certId);
      $('#certImagePreview').remove();
      $('#certImage').after('<img id="certImagePreview" src="' + certImage + '" width="100%" class="mb-3">');

      $('#updateForm').attr('action', updateUrl);
  });
</script>


@endsection