@extends('admin.layout')
@section('seo_title')
<title>Permissions Index</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Create User</li>
@endsection

@section('content')

<div class="card">
    <div class="card-body py-3">
        <div class="row">
            <div class="col-md-12">

                @if ($errors->any())
                <ul class="alert alert-warning">
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0"> Edit Permission
                            <a href="{{ url('permissions') }}" class="btn btn-warning float-end">  <i class="bx bx-arrow-to-left"></i>  Back</a>
                        </h4>
                    </div>
                    <div class="card-body p-2">
                        <form action="{{ url('permissions/'.$permission->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="">Permission Name</label>
                                <input type="text" name="name" value="{{ $permission->name }}" class="form-control" />
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

