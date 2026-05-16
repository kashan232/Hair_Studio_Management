@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">Tehsil</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('tehsils.index') }}">Tehsils</a></li>
                        <li class="breadcrumb-item active" aria-current="page">View</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="card-title mb-0">{{ $tehsil->name }}</h3>
                            <div class="ms-auto">
                                <a href="{{ route('tehsils.edit', $tehsil) }}" class="btn btn-sm btn-primary">Edit</a>
                                <a href="{{ route('tehsils.confirm-delete', $tehsil) }}" class="btn btn-sm btn-danger">Delete</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <dl class="row mb-0">
                                <dt class="col-sm-4">Name</dt>
                                <dd class="col-sm-8">{{ $tehsil->name }}</dd>
                                <dt class="col-sm-4">Taluka</dt>
                                <dd class="col-sm-8">{{ $tehsil->taluka->name }}</dd>
                                <dt class="col-sm-4">District</dt>
                                <dd class="col-sm-8">{{ $tehsil->taluka->district->name }}</dd>
                                <dt class="col-sm-4">DEHs</dt>
                                <dd class="col-sm-8">{{ $tehsil->dehs_count }}</dd>
                                <dt class="col-sm-4">Created</dt>
                                <dd class="col-sm-8">{{ $tehsil->created_at->format('Y-m-d H:i') }}</dd>
                            </dl>
                            <hr>
                            <a href="{{ route('tehsils.index') }}" class="btn btn-secondary btn-sm">Back to list</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
