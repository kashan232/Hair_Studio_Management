@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">Distributaries</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Distributaries</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Distributary list</h3>
                            <div class="ms-auto">
                                <a href="{{ route('distributaries.create') }}" class="btn btn-primary btn-sm">Add Distributary</a>
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
                                            <th>Branch canal</th>
                                            <th>Barrage</th>
                                            <th>Minors</th>
                                            <th style="width: 220px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($distributaries as $distributary)
                                            <tr>
                                                <td>{{ $distributary->name }}</td>
                                                <td>{{ $distributary->branchCanal->name }}</td>
                                                <td>{{ $distributary->branchCanal->barrage->name }}</td>
                                                <td>{{ $distributary->minors_count }}</td>
                                                <td>
                                                    <a href="{{ route('distributaries.show', $distributary) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                                    <a href="{{ route('distributaries.edit', $distributary) }}" class="btn btn-sm btn-primary">Edit</a>
                                                    <a href="{{ route('distributaries.confirm-delete', $distributary) }}" class="btn btn-sm btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">No distributaries yet.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{ $distributaries->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
