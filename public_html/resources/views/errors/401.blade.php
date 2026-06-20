@extends('errors::minimal')

@section('title', __('Unauthorized'))
@section('code')
<img src="{{ url('users/images/errors/401.png') }}" width="300px">
@endsection
@section('message', __('Unauthorized'))
