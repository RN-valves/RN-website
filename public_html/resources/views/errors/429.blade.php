@extends('errors::minimal')

@section('title', __('Too Many Requests'))
@section('code')
<img src="{{ url('users/images/errors/429.png') }}" width="300px">
@endsection
@section('message', __('Too Many Requests'))
