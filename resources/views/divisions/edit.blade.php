@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">Edit Division</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('divisions.index') }}">Divisions</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0">Edit Division: {{ $division->name }}</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('divisions.update', $division) }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="form-label" for="circle_id">Circle</label>
                                    <select name="circle_id" id="circle_id" class="form-control form-select @error('circle_id') is-invalid @enderror" required>
                                        <option value="">Select Circle</option>
                                        @foreach($circles as $circle)
                                            <option value="{{ $circle->id }}" {{ old('circle_id', $division->circle_id) == $circle->id ? 'selected' : '' }}>{{ $circle->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('circle_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="name">Division Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $division->name) }}" class="form-control @error('name') is-invalid @enderror" required maxlength="255">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('divisions.index') }}" class="btn btn-secondary">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
