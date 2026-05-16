@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">Divisions</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Divisions</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Division list</h3>
                            <div class="ms-auto">
                                <a href="{{ route('divisions.create') }}" class="btn btn-primary btn-sm">Add Division</a>
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
                                            <th>Circle</th>
                                            <th>Division Name</th>
                                            <th>Sub Divisions</th>
                                            <th style="width: 220px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($divisions as $division)
                                            <tr>
                                                <td>{{ $division->circle->name ?? 'N/A' }}</td>
                                                <td>{{ $division->name }}</td>
                                                <td>{{ $division->sub_divisions_count }}</td>
                                                <td>
                                                    <a href="{{ route('divisions.show', $division) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                                    <a href="{{ route('divisions.edit', $division) }}" class="btn btn-sm btn-primary">Edit</a>
                                                    <a href="{{ route('divisions.confirm-delete', $division) }}" class="btn btn-sm btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">No divisions yet.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{ $divisions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
