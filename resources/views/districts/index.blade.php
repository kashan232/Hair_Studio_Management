@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">Districts</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Districts</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">District list</h3>
                            <div class="ms-auto">
                                <a href="{{ route('districts.create') }}" class="btn btn-primary btn-sm">Add District</a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Talukas</th>
                                            <th style="width: 220px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($districts as $district)
                                            <tr>
                                                <td>{{ $district->name }}</td>
                                                <td>{{ $district->talukas_count }}</td>
                                                <td>
                                                    <a href="{{ route('districts.show', $district) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                                    <a href="{{ route('districts.edit', $district) }}" class="btn btn-sm btn-primary">Edit</a>
                                                    <a href="{{ route('districts.confirm-delete', $district) }}" class="btn btn-sm btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted">No districts yet.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{ $districts->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
