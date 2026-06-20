@include('admin.partials.header')

<body  class="antialiased h-screen">

  @include('admin.partials.top')
  <!-- ======= Sidebar ======= -->
  @include('admin.partials.navbar')
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
          @yield('breadcrumbs')
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->

    @yield('content')
  </main>
  <!-- End #main -->
  @include('admin.partials.footer')
  @yield('scripts')
</body>

</html>

  