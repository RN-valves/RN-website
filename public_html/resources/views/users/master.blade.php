@include('users.partials.header')
@yield('ccs_links')
@yield('seo_tags')
</head>
<body>
@include('users.partials.top')
@include('users.partials.right_sticky')
@yield('content')
@yield('auth_content')

@include('users.partials.bottom')
@include('users.partials.footer')    
@include('users.partials.sidemenu')
@yield('scripts')
</body>

</html>