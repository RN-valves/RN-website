@extends('admin.layout')
@section('seo_title')
<title>Pincode - {{ $pincode->code??'' }}</title>
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item active">Pincode</li>
@endsection

@section('content')
<div class="card">
    <div class="card-body py-3">
<div class="row">
    <div class="col-lg-12 margin-tb mb-4">
        <div class="pull-left">
            <h2>Pincode {{ $pincode->code??'' }}</h2>
            <div class="float-end">
                @can('pincode-edit')
                <a class="btn btn-primary" href="{{ route('pincodes.edit',$pincode) }}"><i class="bx bx-edit-alt"></i> Edit</a>
                @endcan
                @can('pincode-list')
                <a class="btn btn-warning" href="{{ route('pincodes.index') }}"> <i class="bx bx-arrow-to-left"></i> Back</a>
                @endcan
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xs-12 mb-3">
        <div class="form-group">
            <strong>Name:</strong>
            {{ $pincode->name }}
        </div>
    </div>
    <div class="col-xs-12 mb-3">
        <div class="form-group">
            <strong>Pincode:</strong>
            {{ $pincode->code }}
        </div>
    </div>
</div>
</div>
</div>
@endsection

