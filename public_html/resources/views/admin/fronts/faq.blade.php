@extends('admin.layout')
@section('seo_title')
<title>Faq Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">FAq</li>
@endsection
@section('content')
<div class="card">
        
   <div class="card-body py-3">
   <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h2>
               <div class="float-end">     
                     <a class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#createModal" href="#"> <i class="bx bx-add-to-queue"></i> Create Faq</a>    
               </div>
            </h2>
         </div>
      </div>
      <livewire:faq-index/>
   </div>
</div>
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createModalTitle">Create FAq Question</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{route('faq.store')}}" method="post">
         @csrf
      <div class="modal-body">
         <div class="col-lg-12 form-group pt-2">
            <label class="mb-1">Question <span class="text-danger">*</span></label>
            <textarea class="form-control" placeholder="Enter question..." name="title" required id="question"></textarea>
            <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('question')" />
         </div>
         <div class="col-lg-12 form-group pt-2">
            <label class="mb-1">Answer <span class="text-danger">*</span></label>
            <textarea class="form-control" placeholder="Enter answer..." name="answer" required id="answer"></textarea>
            <x-input-error class="mt-2 error_ipt text-danger" :messages="$errors->get('answer')" />
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>

@endsection
@section('scripts')
@endsection