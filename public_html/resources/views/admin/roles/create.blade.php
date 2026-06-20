@extends('admin.layout')
@section('seo_title')
<title>Roles Create</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Create User</li>
@endsection

@section('content')

<div class="card">
    <div class="card-body py-3">
        <div class="row">
        <div class="col-lg-12 margin-tb mb-4">
            
        </div>
    </div>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops! </strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card-body">
                    <div class="pull-left">
                        <h4>Create New Role/Designation
                            <div class="float-end">
                                <a class="btn btn-warning btn-sm" href="{{ route('roles.index') }}"> <i class="bx bx-arrow-to-left"></i>  Back</a>
                            </div>
                        </h4>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 py-3 g-3">
                        <div class="form-group">
                            <strong>Enter Name:</strong>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name">
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                        <div class="form-group pt-2">
                            <button type="submit" class="btn btn-success">Submit with Atleast 1 Permission Selected</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered">
                         <tr>
                            <th>Name</th>
                            <th>Created Date</th>
                         </tr>
                         @foreach ($permission as $permission)
                         <tr>
                            <td>
                                <label class="text-uppercase">
                                    <input type="checkbox" name="permission[]" value="{{ $permission->id }}" class="name">
                                    {{ $permission->name }}
                                </label>
                            </td>
                            <td>{{ $permission->created_at->format('d M Y') }}</td>
                         </tr>
                         @endforeach
                      </table>
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </div>
        </div>
    </form>
    </div>
</div>

@endsection

