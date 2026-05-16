@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">Main canals</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Main canals</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Main canal list</h3>
                            <div class="ms-auto">
                                <a href="{{ route('main-canals.create') }}" class="btn btn-primary btn-sm">Add Main canal</a>
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
                                            <th>Barrage</th>
                                            <th>Sub canals</th>
                                            <th style="width: 220px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($mainCanals as $mainCanal)
                                            <tr>
                                                <td>{{ $mainCanal->name }}</td>
                                                <td>{{ $mainCanal->barrage->name }}</td>
                                                <td>{{ $mainCanal->sub_canals_count }}</td>
                                                <td>
                                                    <a href="{{ route('main-canals.show', $mainCanal) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                                    <a href="{{ route('main-canals.edit', $mainCanal) }}" class="btn btn-sm btn-primary">Edit</a>
                                                    <a href="{{ route('main-canals.confirm-delete', $mainCanal) }}" class="btn btn-sm btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">No mainCanals yet.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{ $mainCanals->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
