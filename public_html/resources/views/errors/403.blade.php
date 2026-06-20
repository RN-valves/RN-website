@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code')
<img src="{{ url('users/images/errors/403.png') }}" width="300px">
@endsection
@section('message', __($exception->getMessage() ?: 'Forbidden'))
