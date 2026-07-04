
@extends('admin.layout')
@section('seo_title')
<title>Product Report</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Order Report</li>
@endsection
@section('content')
<div class="card">
   <div class="card-body py-3">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h5>Product Data</h5>
         </div>
      </div>
      <div class="col-lg-12 py-2">
         <form class="row" method="POST" action="{{ route('product.reports.export') }}">
            @csrf
           
            <div class="col-lg-3">
               <label for="">Select Category</label>
               <select class="js-example-basic-multiple js-states form-control" id="category_id" name="category_ids[]" multiple="">
                  <option value="all">All</option>
                  @foreach ($categories as $category)
                  <option value="{{$category->id}}">{{$category->name}}</option>
                  @endforeach
               </select>
            </div>
            <div class="col-lg-3">
               <label for="">Select SubCategory</label>
               <select class="form-control" id="subcategory_id" name="subcategory_ids[]" multiple="">
                  <option value=""></option>
               </select>
            </div>
            <div class="col-lg-3">
               <button class="btn btn-success bt-sm mt-4" type="submit"> <i class="bx bx-excel"></i> Export</button>
            </div>
           
         </form>
      </div>
     
   </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
   $('#to_date').datepicker({
        weekStart: 1,
        daysOfWeekHighlighted: "6,0",
        autoclose: true,
        todayHighlight: true,
        format: "dd/mm/yyyy"
   });
   $('#from_date').datepicker({
        weekStart: 1,
        daysOfWeekHighlighted: "6,0",
        autoclose: true,
        todayHighlight: true,
        format: "dd/mm/yyyy"
   });


$("#category_id").select2({
     theme: "classic"
   });
$("#subcategory_id").select2({
     theme: "classic"
   });
</script>
<script type="text/javascript">
   $(document).ready(function(){
    $("#category_id").on('change', function(){
      let categoryIds = $(this).val(); // Get the value directly

        // Clear the subcategory dropdown
        $("#subcategory_id").html('');
      if (categoryIds && categoryIds.length > 0) {
        $.ajax({
            url: '{{ route('product.reports.subcategory') }}',
            type: 'POST',
            data: {
               category_ids: categoryIds,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(result){
                if(result.length > 0){
                    $.each(result, function(key, subcategory){
                        $("#subcategory_id").append(
                            '<option value="' + subcategory.id + '">' + subcategory.name + '</option>'
                        );
                    });
                } else {
                    $("#subcategory_id").append('<option value="">No Subcategories Found</option>');
                }
            },
            error: function(xhr){
                alert('Something went wrong while fetching subcategories.');
                console.log(xhr.responseText);
            }
        });
      }
    });
});

</script>

@endsection

