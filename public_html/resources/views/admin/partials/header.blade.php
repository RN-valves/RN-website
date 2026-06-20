<!DOCTYPE html>
<html
    x-data="{ darkMode: localStorage.getItem('darkMode') == 'true' ?? true }"
    x-init="() => {
        toggleDark = () => {
            darkMode = !darkMode
            localStorage.setItem('darkMode', darkMode)
        }
    }"
    x-bind:class="{ 'dark': darkMode }"
>

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link rel="canonical" href="{{ url()->current() }}">

  @yield('seo_title')

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ url('admin/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ url('admin/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ url('admin/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ url('admin/assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ url('admin/assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ url('admin/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ url('admin/assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="{{ url('admin/assets/css/toastr.min.css') }}">
  <!-- Template Main CSS File -->
  <link href="{{ url('admin/assets/css/style.css') }}" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{ url('admin/assets/css/select2.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('admin/assets/css/select2-bootstrap.min.css') }}">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet"/>


  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  @livewireStyles

  {{-- @powerGridStyles --}}
</head>
<style type="text/css">
  .bx{font-size:font-size:25px!important;}
  li .select2-search-choice-close{background-color:red!important;}
  .select2-search-choice-close{background-image:url({{ url('admin/assests/img/select2.png') }})!important;}
  li .active{
    background-color:rgb(240, 240, 240);
    border-left:4px solid grey;
    border-radius:10px;
  }
  .left-menu{
    width:180px;
  }
  .right-menu {
    margin-right: 10px;
    background-color: lightgrey;
    padding: 0px 10px;
    color:black;
    border-radius:5px;
    font-weight:bold;
  }
   label{
      font-size:12px;
      font-weight:600;
   }
   .error_ipt{
      font-size:12px;
      font-weight:200px;
   }
   th{
      font-size:12px;
      font-weight:600;
   }
   td{
      font-size:13px;
      font-weight:400;
   }
   input{
    height:32px;
   }
   select{
    height:32px;
   }
   input::placeholder {
    font-size:12px;
  }
  input[type="file"]{
    font-size:12px;
  }
  input[type="number"]{
    font-size:12px;
  }
</style>