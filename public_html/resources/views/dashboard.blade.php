@extends('admin.layout')
@section('seo_title')
<title>Dashboard</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Dashboard</li>
@endsection
@section('content')
@include('admin.dashboards.admin_dashboard')
@endsection