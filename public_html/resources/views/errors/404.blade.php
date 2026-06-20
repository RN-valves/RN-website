@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code')
<img src="{{ url('users/images/errors/404.png') }}" width="300px">
@endsection
@section('message', __('Not Found'))
