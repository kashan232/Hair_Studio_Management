@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">Customers</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Customers</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0">Customer list</h3>
                            <div class="ms-auto">
                                <a href="{{ route('customers.create') }}" class="btn btn-primary btn-sm">Add customer</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-0">Customer records module — ready for CRUD integration.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
