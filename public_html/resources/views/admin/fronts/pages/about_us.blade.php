@extends('admin.layout')
@section('seo_title')
<title>Content Setting</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">About Us Setting</li>
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
         <form action="{{ route('page.about_us') }}" method="POST" accept-charset="utf-8" class="row" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{@$data->url_key}}" name="url_key">
            <div class="col-lg-4 form-group pt-2">
               <label class="mb-1">Title</label>
               <input type="text" name="name" value="{{old('title',@$data->name)}}" class="form-control shadow-none" placeholder="Enter Title" autocomplete="off">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('title')" />
            </div>
            <div class="col-lg-8 form-group pt-2">
               <label class="mb-1">Youtube Iframe</label>
               <textarea class="form-control shadow-none  @error('youtube') is-invalid @enderror" id="" name="youtube">{{@$data->youtube_link}} </textarea>
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('youtube')" />
            </div>         
            <div class="col-lg-12 form-group pt-2">
               <label class="mb-1">Description 1</label>
               <textarea class="form-control shadow-none editor @error('desc1') is-invalid @enderror" id="editor1" name="desc1"> {{@$data->desc1}}</textarea>
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('desc1')" />
            </div>         
            <div class="col-lg-4 form-group pt-2">
               <label class="mb-1">Vision</label>
               <textarea class="form-control shadow-none editor @error('vision') is-invalid @enderror" id="editor2" name="vision"> {{@$data->vision}}</textarea>
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('vision')" />
            </div>         
            <div class="col-lg-4 form-group pt-2">
               <label class="mb-1">Mission</label>
               <textarea class="form-control shadow-none editor @error('mission') is-invalid @enderror" id="editor3" name="mission"> {{@$data->mission}}</textarea>
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('mission')" />
            </div>         
            <div class="col-lg-4 form-group pt-2">
               <label class="mb-1">Values</label>
               <textarea class="form-control shadow-none editor @error('values') is-invalid @enderror" id="editor4" name="values"> {{@$data->values}}</textarea>
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('values')" />
            </div>  
            <div class="col-lg-12 form-group pt-2">
               <label class="mb-1">Description 2</label>
               <textarea class="form-control shadow-none editor @error('desc2') is-invalid @enderror" id="editor5" name="desc2"> {{@$data->desc2}}</textarea>
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('desc2')" />
            </div>  
            <div class="col-lg-12 form-group pt-2">
               <label class="mb-1">Description 2</label>
               <textarea class="form-control shadow-none editor @error('desc3') is-invalid @enderror" id="editor6" name="desc3"> {{@$data->desc3}}</textarea>
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('desc3')" />
            </div>  
            <div class="col-lg-6 form-group pt-2">
               <label class="mb-1">Image 1 (Size: 430*378px)</label>
               <input type="file" name="img1" class="form-control" id="file-input1">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('img1')" />
            </div>  
            <div class="col-lg-6 form-group pt-2">
               <label class="mb-1">Image 2 (Size: 430*378px)</label>
               <input type="file" name="img2" class="form-control" id="file-input2">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('img1')" />
            </div> 
            @if($data->img1) 
            <div class="col-lg-6 form-group pt-2" id="image-container1">
                <img src="{{asset($data->img1)}}" id="selected-image1" width="150" height="150">
            </div> 
            @endif 
            @if($data->img2) 
            <div class="col-lg-6 form-group pt-2" id="image-container2">
                 <img src="{{asset($data->img2)}}" id="selected-image2" width="150" height="150">
            </div>  
            @endif
            <div class="col-lg-6 form-group pt-2">
               <label class="mb-1">Catalogue</label>
               <input type="file" name="catalogue" class="form-control" accept=".pdf" id="file-input3">
               <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('catalogue')" />
            </div> 
            <div class="col-lg-6 form-group pt-2" id="pdf-container">
          
               <embed id="pdf-viewer" src="" type="application/pdf">
           
            </div> 
            <hr class="my-2">       
            <div class="col-lg-12 form-group pt-2">
               <h6><strong><i>Milestones</i></strong></h6>
               <table id="dynamic-table" class="table table-bordered table-hover table-striped table-highlight-head">
                <thead>
                    <tr>
                        <th>Year</th>
                        <th>Title</th>
                        <th>Details</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($milestones as $key => $milestone)
                    <tr data-row-id="{{ $key }}">
                        <td>
                            <input type="number" class="form-control" value="{{$milestone['year']}}" name="fields[{{$key}}][year]" placeholder="Enter year" required>
                        </td>
                        <td>
                            <input type="text" class="form-control" value="{{$milestone['title']}}" name="fields[{{$key}}][title]" placeholder="Enter title" required>
                        </td>
                        <td>
                            <textarea class="form-control" name="fields[{{$key}}][description]" rows="2" placeholder="Enter text" required>{{$milestone['description']}}</textarea>
                        </td>
                        <td>
                           
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
               </table>
               <button type="button" id="add-row" class="btn btn-success btn-sm action-btn my-3"><i class="bx bx-plus"></i></button>
            </div>         
            <div class="col-lg-12 form-group py-2 text-center">
               <button class="btn btn-primary btn-sm float-end" type="submit">Update</button>

            </div>
         </form>
      </div>
   </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@43.2.0/build/ckeditor.min.js"></script>
<script>
   ClassicEditor.create(document.querySelector('#editor1')).catch(error => console.error(error));
   ClassicEditor.create(document.querySelector('#editor2')).catch(error => console.error(error));
   ClassicEditor.create(document.querySelector('#editor3')).catch(error => console.error(error));
   ClassicEditor.create(document.querySelector('#editor4')).catch(error => console.error(error));
   ClassicEditor.create(document.querySelector('#editor5')).catch(error => console.error(error));
   ClassicEditor.create(document.querySelector('#editor6')).catch(error => console.error(error));
</script>
<script>
        $(document).ready(function () {
         let rowCount = $('#dynamic-table tbody tr').length; 

            // Add a new row to the table
            $('#add-row').click(function () {
                rowCount++;
                const newRow = `
                    <tr data-row-id="${rowCount}">
                        <td>
                            <input type="number" class="form-control" name="fields[${rowCount}][year]" placeholder="Enter year" required>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="fields[${rowCount}][title]" placeholder="Enter title" required>
                        </td>
                        <td>
                            <textarea class="form-control" name="fields[${rowCount}][description]" rows="2" placeholder="Enter text" required></textarea>
                        </td>
                        <td>
                            <button type="button" class="action-btn btn btn-danger btn-sm remove"><i class="bx bx-trash"></i></button>
                        </td>
                    </tr>
                `;
                $('#dynamic-table tbody').append(newRow);
            });

            // Remove a specific row from the table
            $(document).on('click', '.remove', function () {
               $(this).closest('tr').remove();
             rowCount--;
            });
        });
    </script>
    <script>
        document.getElementById('file-input1').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('selected-image1');
                    img.src = e.target.result;
                    img.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
        document.getElementById('file-input2').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('selected-image2');
                    img.src = e.target.result;
                    img.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('file-input3').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const fileExtension = file.name.split('.').pop().toLowerCase();
            
            if (file && fileExtension === 'pdf') {
                const pdfContainer = document.getElementById('pdf-container');
                const pdfViewer = document.getElementById('pdf-viewer');
                
                pdfViewer.src = URL.createObjectURL(file);
                pdfContainer.style.display = 'block';
            } else {
                alert('Please select a PDF file.');
            }
        });
    </script>
@endsection