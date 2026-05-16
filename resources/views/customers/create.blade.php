@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">Add customer</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Customers</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0">New customer</h3>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3">Customer registration form will be added here.</p>
                            <a href="{{ route('customers.index') }}" class="btn btn-secondary">Back to list</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
