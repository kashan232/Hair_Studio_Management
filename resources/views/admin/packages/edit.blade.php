@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <!-- PAGE-HEADER -->
        <div class="page-header">
            <h1 class="page-title">Edit Package: {{ $package->name }}</h1>
            <div>
                <a href="{{ route('admin.packages.index') }}" class="btn btn-secondary">&larr; Back to Packages</a>
            </div>
        </div>
        <!-- PAGE-HEADER END -->

        <div class="row">
            <div class="col-xl-6 col-lg-8">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.packages.update', $package) }}" method="POST">
                @csrf @method('PUT')
                <div class="form-group">
                    <label>Package Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $package->name }}" required>
                </div>
                
                <div class="form-group">
                    <label>Total Hours</label>
                    <input type="number" step="1" name="hours" class="form-control" value="{{ $package->hours }}" required>
                </div>

                <div class="form-group">
                    <label>Price (£)</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="{{ $package->price }}" required>
                </div>

                <div class="form-group">
                    <label>Validity in Days (Leave blank for no expiry)</label>
                    <input type="number" step="1" name="expiry_days" class="form-control" value="{{ $package->expiry_days }}" placeholder="e.g. 30">
                </div>

                <div class="form-group form-check">
                    <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive" {{ $package->is_active ? 'checked' : '' }}>
                    <label class="form-check-label" for="isActive">Active (visible to users)</label>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Update Package</button>
            </form>
        </div>
    </div>
            </div>
        </div>
    </div>
</div>
@endsection
