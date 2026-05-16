@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">Bulk import · Irrigation hierarchy</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Excel import</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('warning'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {{ session('warning') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('import_errors') && is_array(session('import_errors')))
                        <div class="alert alert-danger mb-4">
                            <strong>Row messages</strong>
                            <ul class="mb-0 mt-2 small">
                                @foreach (session('import_errors') as $line)
                                    <li>{{ $line }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0">Upload spreadsheet</h3>
                        </div>
                        <div class="card-body">
                            <p class="text-muted small">
                                Columns must include a header row.<br>
                                <strong>All import types</strong> run as <strong>one database transaction</strong>.<br>
                                <strong>Circles:</strong> creates circles only.<br>
                                <strong>Divisions:</strong> circle must already exist; creates divisions only.<br>
                                <strong>Sub Divisions:</strong> circle and division must already exist; creates sub divisions only.
                            </p>

                            <form action="{{ route('irrigation.import.store') }}" method="post" enctype="multipart/form-data" class="mt-4">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label" for="import_type">Import type</label>
                                    <select name="import_type" id="import_type" class="form-select @error('import_type') is-invalid @enderror" required>
                                        <option value="sub_divisions" @selected(old('import_type') === 'sub_divisions')>Sub Divisions (columns: circle, division, sub_division)</option>
                                        <option value="divisions" @selected(old('import_type') === 'divisions')>Divisions only (circle, division)</option>
                                        <option value="circles" @selected(old('import_type') === 'circles')>Circles only (circle)</option>
                                    </select>
                                    @error('import_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="file">Excel / CSV file</label>
                                    <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" accept=".xlsx,.xls,.csv" required>
                                    @error('file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Max 40&nbsp;MB. Formats: .xlsx, .xls, .csv</small>
                                </div>

                                <button type="submit" class="btn btn-primary">Run import</button>
                                <a href="{{ route('circles.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-primary mb-4">
                        <div class="card-header bg-light">
                            <h3 class="card-title mb-0">Templates</h3>
                        </div>
                        <div class="card-body">
                            <p class="small text-muted mb-3">Download a sample file that matches column headers exactly.</p>
                            <div class="d-grid gap-2">
                                <a class="btn btn-outline-primary btn-sm" href="{{ route('irrigation.import.template', ['type' => 'circles']) }}">Circles template (.xlsx)</a>
                                <a class="btn btn-outline-primary btn-sm" href="{{ route('irrigation.import.template', ['type' => 'divisions']) }}">Divisions template (.xlsx)</a>
                                <a class="btn btn-outline-primary btn-sm" href="{{ route('irrigation.import.template', ['type' => 'sub_divisions']) }}">Sub Divisions template (.xlsx)</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
