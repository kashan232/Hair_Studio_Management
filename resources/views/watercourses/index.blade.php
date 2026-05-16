@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">Watercourses</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Watercourses</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Watercourse list</h3>
                            <div class="ms-auto">
                                <a href="{{ route('watercourses.create') }}" class="btn btn-primary btn-sm">Add Watercourse</a>
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
                                            <th>Sub canal</th>
                                            <th>Main canal</th>
                                            <th>Barrage</th>
                                            <th style="width: 220px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($watercourses as $watercourse)
                                            <tr>
                                                <td>{{ $watercourse->name }}</td>
                                                <td>{{ $watercourse->subCanal->name }}</td>
                                                <td>{{ $watercourse->subCanal->mainCanal->name }}</td>
                                                <td>{{ $watercourse->subCanal->mainCanal->barrage->name }}</td>
                                                <td>
                                                    <a href="{{ route('watercourses.show', $watercourse) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                                    <a href="{{ route('watercourses.edit', $watercourse) }}" class="btn btn-sm btn-primary">Edit</a>
                                                    <a href="{{ route('watercourses.confirm-delete', $watercourse) }}" class="btn btn-sm btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">No Watercourses yet.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{ $watercourses->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
