@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">Sub Divisions</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Sub Divisions</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Sub Division list</h3>
                            <div class="ms-auto">
                                <a href="{{ route('sub-divisions.create') }}" class="btn btn-primary btn-sm">Add Sub Division</a>
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
                                            <th>Division</th>
                                            <th>Sub Division Name</th>
                                            <th style="width: 220px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($subDivisions as $subDivision)
                                            <tr>
                                                <td>{{ $subDivision->division->circle->name ?? 'N/A' }}</td>
                                                <td>{{ $subDivision->division->name ?? 'N/A' }}</td>
                                                <td>{{ $subDivision->name }}</td>
                                                <td>
                                                    <a href="{{ route('sub-divisions.show', $subDivision) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                                    <a href="{{ route('sub-divisions.edit', $subDivision) }}" class="btn btn-sm btn-primary">Edit</a>
                                                    <a href="{{ route('sub-divisions.confirm-delete', $subDivision) }}" class="btn btn-sm btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">No sub divisions yet.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{ $subDivisions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
