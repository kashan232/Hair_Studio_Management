@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">Bulk import · Location hierarchy</h1>
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
                                <strong>All import types</strong> run as <strong>one database transaction</strong>: if any row fails validation or a parent is missing, <strong>the entire upload is rolled back</strong> (nothing saved).<br>
                                <strong>Districts:</strong> creates districts only — repeats count as “already existed” (no duplicate rows).<br>
                                <strong>Talukas:</strong> district must already exist; creates talukas only.<br>
                                <strong>Tehsils:</strong> district and taluka must already exist; creates tehsils only.<br>
                                <strong>DEHs:</strong> district, taluka, and tehsil must already exist; creates DEHs only.<br>
                                Success summary shows <strong>new records created</strong> vs <strong>already existed</strong> (same spelling — no duplicate rows thanks to <code>firstOrCreate</code>).
                            </p>

                            <form action="{{ route('locations.import.store') }}" method="post" enctype="multipart/form-data" class="mt-4">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label" for="import_type">Import type</label>
                                    <select name="import_type" id="import_type" class="form-select @error('import_type') is-invalid @enderror" required>
                                        <option value="dehs" @selected(old('import_type') === 'dehs')>DEHs (columns: district, taluka, tehsil, deh)</option>
                                        <option value="tehsils" @selected(old('import_type') === 'tehsils')>Tehsils only (district, taluka, tehsil)</option>
                                        <option value="talukas" @selected(old('import_type') === 'talukas')>Talukas only — district must already exist (district name + taluka)</option>
                                        <option value="districts" @selected(old('import_type') === 'districts')>Districts only (district)</option>
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
                                <a href="{{ route('districts.index') }}" class="btn btn-secondary ms-2">Cancel</a>
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
                                <a class="btn btn-outline-primary btn-sm" href="{{ route('locations.import.template', ['type' => 'districts']) }}">Districts template (.xlsx)</a>
                                <a class="btn btn-outline-primary btn-sm" href="{{ route('locations.import.template', ['type' => 'talukas']) }}">Talukas template (.xlsx)</a>
                                <a class="btn btn-outline-primary btn-sm" href="{{ route('locations.import.template', ['type' => 'tehsils']) }}">Tehsils template (.xlsx)</a>
                                <a class="btn btn-outline-primary btn-sm" href="{{ route('locations.import.template', ['type' => 'dehs']) }}">Full hierarchy / DEHs template (.xlsx)</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
