@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">District</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('districts.index') }}">Districts</a></li>
                        <li class="breadcrumb-item active" aria-current="page">View</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="card-title mb-0">{{ $district->name }}</h3>
                            <div class="ms-auto">
                                <a href="{{ route('districts.edit', $district) }}" class="btn btn-sm btn-primary">Edit</a>
                                <a href="{{ route('districts.confirm-delete', $district) }}" class="btn btn-sm btn-danger">Delete</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <dl class="row mb-0">
                                <dt class="col-sm-4">Name</dt>
                                <dd class="col-sm-8">{{ $district->name }}</dd>
                                <dt class="col-sm-4">Talukas</dt>
                                <dd class="col-sm-8">{{ $district->talukas_count }}</dd>
                                <dt class="col-sm-4">Created</dt>
                                <dd class="col-sm-8">{{ $district->created_at->format('Y-m-d H:i') }}</dd>
                            </dl>
                            <hr>
                            <a href="{{ route('districts.index') }}" class="btn btn-secondary btn-sm">Back to list</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
