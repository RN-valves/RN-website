@php $isProductDetail = request()->routeIs('productList.view'); @endphp
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js" defer></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" defer></script>

<script type="text/javascript" src="{{url('users/assets/js/jquery.meanmenu.min.js')}}" defer></script>

@if($isProductDetail)
<script src="{{url('users/assets/js/slick.min.js')}}" defer></script>
<script src="{{url('users/assets/js/imagesloaded.pkgd.min.js')}}" defer></script>
@endif

<script type="text/javascript" src="{{url('users/assets/js/mains.js')}}" defer></script>
<script type="text/javascript" src="{{ url('users/assets/js/custom.js') }}" defer></script>
<script type="text/javascript" src="{{ url('admin/assets/js/toastr.min.js') }}" defer></script>

{{-- ajax form submit alert popup  --}}
<script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js" defer></script>
{{-- ajax form submit alert popup  --}}


<!--Start of Tawk.to Script: deferred until after page load-->
<script type="text/javascript">
window.addEventListener('load', function() {
   setTimeout(function() {
      var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
      var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
      s1.async=true;
      s1.src='https://embed.tawk.to/672b32004304e3196addcfe7/1ic0bmlc9';
      s1.charset='UTF-8';
      s1.setAttribute('crossorigin','*');
      s0.parentNode.insertBefore(s1,s0);
   }, 4000);
});
</script>
<!--End of Tawk.to Script-->

@if(Session::has('success'))
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
   if (typeof toastr === 'undefined') return;
   toastr.options = {
     "closeButton":true,
     "progressBar": true,
   }
   toastr.success("{{Session::get('success')}}");
});
</script>
@endif
@if(Session::has('error'))
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
   if (typeof toastr === 'undefined') return;
   toastr.options = {
     "closeButton":true,
     "progressBar": true,
   }
   toastr.error("{{Session::get('error')}}");
});
</script>
@endif

<script type="text/javascript">
   $(document).ready(function(){
      $(".pinError").hide();
      $(".zipcode").on('keyup', function(){
         var pincode = this.value;

         var zipRegex = /^\d{5}$/;

         if (!zipRegex.test(pincode))
         {
            $(".pinError").show();
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
                  $(".pinError").hide();
                  $("#city_id").val(result.city.name);
                  $("#state_id").val(result.state.name);
               }else{
                  alert('error');
               }
               
            }
         });
      });
   });
</script>

<script type="text/javascript">
   $(document).ready(function(){
      $('#popup_form').on('submit', function(event) {
         event.preventDefault();
         var form = this;
         function submitWithCaptcha() {
            if (typeof grecaptcha === 'undefined') return;
            grecaptcha.ready(function() {
               grecaptcha.execute("{{ env('GOOGLE_RECAPTCHA_KEY') }}", {action: 'subscribe_newsletter'}).then(function(token) {
                  $(form).prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
                  form.submit();
               });
            });
         }
         submitWithCaptcha();
      });
   });
</script>
<script type="text/javascript">
$(document).ready(function () {
   $("#popup_form").submit(function (e) {
      $(".popup_form_disabled").attr("disabled", true);
      return true;
   });
});
</script>

<script type="text/javascript">
    $("#popup_form_btn").click(function(e){
     e.preventDefault();
     let form = $('#popup_form');
     const data = new FormData(document.getElementById("popup_form"));
    
      $.ajax({
        url: '{!! route('store_popup_form_enquiry') !!}',
        type: "POST",
        data : data,
        dataType:"JSON",
        processData : false,
        contentType:false,
        
     success: function(response) {

        if (response.errors) {
            var errorMsg = '';
            $.each(response.errors, function(field, errors) {
                $.each(errors, function(index, error) {
                    errorMsg += error + '<br>';
                });
            });
            iziToast.error({
                message: errorMsg,
                position: 'topRight'
            });
            
        } else {
           iziToast.success({
           message: response.success,
           position: 'topRight'
        
            });

            location.reload(true);
        }
                 
    },
    error: function(xhr, status, error) {
      
        iziToast.error({
            message: 'An error occurred: ' + error,
            position: 'topRight'
        });
    }
 
      });
   
})
</script>
{{-- New website scripts end --}}

@if($isProductDetail)
<!----asr--->
<script src="{{url('users/asr_zoom/jquery.jqzoom.js')}}" type="text/javascript" defer></script>

<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
  if (typeof jQuery !== 'undefined' && jQuery('.jqzoom').length) {
    jQuery('.jqzoom').jqzoom({
         zoomType: 'innerzoom',
            preloadImages: false,
            alwaysOn:false,
            title: false,
             showEffect: 'show'
        });
  }
});
</script>
<!----asr--->
@endif

<!-- sticky script -->
<script>
    $(document).ready(function() {
  
      $(".stikyarrow").click(function() {
        $(".menu_bar_sticky").toggleClass("in")
      });
      $(".actn_enquiry").click(function() {
        $("#leadform__enquiry").modal("show");
        $("#need_help_form").modal("hide");
      });

      $(".actn_help").click(function() {
        $("#need_help_form").modal("show");
        $("#leadform__enquiry").modal("hide")
      });

    })
    function validateNumber(input) {
      input.value = input.value.replace(/\D/g, '');
    }
</script> 
<!-- sticky script --> 
    

<script>
$(document).ready(function() {
    setTimeout(function() { 
    $("body").removeClass("modal-open"); 
}, 3000);

});

</script>
<!-- sticky script --> 
<script type="text/javascript">
    $(document).ready(function() {
    $(".epayment-tab-menu>div.list-group>a").click(function(e) {
        e.preventDefault();
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $(".epayment-tab>.epayment-tab-content").removeClass("active");
        $(".epayment-tab>.epayment-tab-content").eq(index).addClass("active");
    });

    $(document).ready(function () {
  function showLoginError(message) {
    if (typeof iziToast !== 'undefined') {
      iziToast.error({position: 'topRight', message: message});
    } else {
      alert(message);
    }
  }

  // Send OTP
  $("#sendOtpBtn").on("click", function () {
    const mobileNumber = $("#mobileNumber").val();
    if(mobileNumber === ''){
      $('.mobile-error').css('display','block')
      return false;
    }
    $('.mobile-error').css('display','none')
    $.ajax({
      url: "{{route('send.login.otp')}}",
      method: "POST",
      data: { mobile_number: mobileNumber, _token: "{{ csrf_token() }}" },
      success: function (response) {
        if (response.success) {
          $("#mobileForm").hide();
          $("#otpForm").show();
          $(".resendOtp-count").show();
          if (typeof iziToast !== 'undefined') {
            iziToast.success({timeout: 5000, position: 'topRight', title: 'OK', message: response.message});
          }
          startCountdown(30);
        } else {
          showLoginError(response.message || 'Unable to send OTP. Please try again.');
        }
      },
      error: function (xhr) {
        if (xhr.status === 419) {
          showLoginError('Session expired. Please refresh the page and try again.');
        } else {
          showLoginError('Unable to send OTP. Please try again.');
        }
      }
    });
  });

  let countdownInterval;

  // Function to start the countdown
  function startCountdown(duration) {
    let timer = duration;
    $("#resendOtpBtn").prop("disabled", true);
    countdownInterval = setInterval(function () {
      $("#countdown").text(timer);
      timer--;

      if (timer < 0) {
        clearInterval(countdownInterval);
        $("#resendOtpBtn").prop("disabled", false);
        $("#countdown").text(30);
      }
    }, 1000);
  }

    // Resend OTP
    $("#resendOtpBtn").on("click", function () {
    const mobileNumber = $("#mobileNumber").val();
    $.ajax({
      url: "{{route('resend.login.otp')}}",
      method: "POST",
      data: { mobile_number: mobileNumber, _token: "{{ csrf_token() }}" },
      success: function (response) {
        if (response.success) {
            if (typeof iziToast !== 'undefined') {
              iziToast.success({timeout: 5000, position: 'topRight', title: 'OK', message: response.message});
            }
            startCountdown(30);
        } else {
            showLoginError(response.message || 'Unable to resend OTP.');
        }
      },
      error: function () {
        showLoginError('Unable to resend OTP. Please try again.');
      }
    });
  });

  // Verify OTP
  $("#verifyOtpBtn").on("click", function () {
    const otp = $("#otp").val();
    if(otp === ''){
      $('.otp-error').css('display','block')
      return false;
    }
    const mobileNumber = $("#mobileNumber").val();
    $('.otp-error').css('display','none')
    $.ajax({
      url: "{{route('verify.login.otp')}}",
      method: "POST",
      data: { otp: otp, mobile_number: mobileNumber, _token: "{{ csrf_token() }}" },
      success: function (response) {
        if (response.success) {
          if (typeof iziToast !== 'undefined') {
            iziToast.success({timeout: 5000, position: 'topRight', title: 'OK', message: response.message});
          }
          setTimeout(function () {
              window.location.href = response.redirect;
          }, 1000);
        } else {    
          showLoginError(response.message || 'Invalid OTP. Please try again.');
        }
      },
      error: function (xhr) {
        if (xhr.status === 419) {
          showLoginError('Session expired. Please refresh the page and try again.');
        } else {
          showLoginError('Unable to verify OTP. Please try again.');
        }
      }
    });
  });
 
});
});


</script>     
    
{{-- <script>
$(document).on({
    "contextmenu": function (e) {
        console.log("ctx menu button:", e.which); 

        // Stop the context menu
        e.preventDefault();
    },
    "mousedown": function(e) { 
        console.log("normal mouse down:", e.which); 
    },
    "mouseup": function(e) { 
        console.log("normal mouse up:", e.which); 
    }
});     
</script>  --}}

{{-- Global: Disable browser autofill on ALL input fields --}}
<script>
(function() {
    function disableAutofill(root) {
        var elements = (root || document).querySelectorAll('input, textarea, select, form');
        for (var i = 0; i < elements.length; i++) {
            elements[i].setAttribute('autocomplete', 'off');
        }
    }
    // Apply on page load
    document.addEventListener('DOMContentLoaded', disableAutofill);
    // Apply to dynamically added elements (modals, AJAX content)
    if (typeof MutationObserver !== 'undefined') {
        var observer = new MutationObserver(function(mutations) {
            for (var i = 0; i < mutations.length; i++) {
                for (var j = 0; j < mutations[i].addedNodes.length; j++) {
                    var node = mutations[i].addedNodes[j];
                    if (node.nodeType === 1) {
                        if (node.matches && node.matches('input, textarea, select, form')) {
                            node.setAttribute('autocomplete', 'off');
                        }
                        disableAutofill(node);
                    }
                }
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            observer.observe(document.body, { childList: true, subtree: true });
        });
    }
})();
</script>

