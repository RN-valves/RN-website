@extends('errors::minimal')

@section('title', __('Payment Required'))
@section('code')
<img src="{{ url('users/images/errors/402.png') }}" width="300px">
@endsection
@section('message', __('Payment Required'))
