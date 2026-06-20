<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
   <div class="copyright">
      &copy; Copyright <strong><span>{{ frontPage()->name??'' }}</span></strong>. All Rights Reserved
   </div>
   <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://rnvalves.com/"> 
         <img src="{{ url(frontPage()->logo??'') }}" width="40px">
      </a>
   </div>
</footer>
<!-- End Footer -->
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<!-- Vendor JS Files -->

@livewireScripts
<script src="{{ url('admin/assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ url('admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ url('admin/assets/vendor/chart.js/chart.umd.js') }}"></script>
<script src="{{ url('admin/assets/vendor/echarts/echarts.min.js') }}"></script>
<script src="{{ url('admin/assets/vendor/quill/quill.js') }}"></script>
<script src="{{ url('admin/assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{ url('admin/assets/vendor/tinymce/tinymce.min.js') }}"></script>
<script src="{{ url('admin/assets/vendor/php-email-form/validate.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ url('admin/assets/js/toastr.min.js') }}"></script>
<script type="text/javascript" src="{{ url('admin/assets/js/select2.min.js') }}"></script>
<!-- Template Main JS File -->
<script src="{{ url('admin/assets/js/main.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
    $('#datepicker').datepicker({
        weekStart: 1,
        daysOfWeekHighlighted: "6,0",
        autoclose: true,
        todayHighlight: true,
    });
    $('#datepicker').datepicker("setDate", new Date());
</script>
@if(Session::has('success'))
<script type="text/javascript">
   toastr.options = {
     "closeButton":true,
     "progressBar": true,
   }
   toastr.success("{{Session::get('success')}}");
</script>
@endif
@if(Session::has('error'))
<script type="text/javascript">
   toastr.options = {
     "closeButton":true,
     "progressBar": true,
   }
   toastr.error("{{Session::get('error')}}");
</script>
@endif


<script type="text/javascript">
   $("#multiple").select2({
         placeholder: "Select a data",
         allowClear: true
     });
</script>

<!-- <script type="text/javascript">
   CKEDITOR.replace( 'editor' );
</script> -->


<script>
$(document).ready(function () {
   $(".confirm-form").submit(function (e) {
      $("#btn-submit").attr("disabled", true);
      return true;
         
   });
  
});
function validateNumber(input) {
      const regex = /^\d*\.?\d*$/;

      if (!regex.test(input.value)) {
        input.value = input.value.slice(0, -1);
      }
    }
</script>
