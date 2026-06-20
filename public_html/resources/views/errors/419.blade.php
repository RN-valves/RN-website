@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code')
<img src="{{ url('users/images/errors/419.png') }}" width="300px">
@endsection
@section('message', __('Page Expired'))
