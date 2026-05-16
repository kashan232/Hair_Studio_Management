@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">Bulk import · Channels hierarchy</h1>
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
                                <strong>Barrages:</strong> creates barrages only — repeats count as “already existed” (no duplicate rows).<br>
                                <strong>Main canals:</strong> barrage must already exist; creates main canals only.<br>
                                <strong>Sub canals:</strong> barrage and main canal must already exist; creates sub canals only.<br>
                                <strong>Watercourses:</strong> full parent chain must exist; creates WC records only.<br>
                                Success summary shows <strong>new records created</strong> vs <strong>already existed</strong> (same spelling — no duplicate rows thanks to <code>firstOrCreate</code>).
                            </p>

                            <form action="{{ route('channels.import.store') }}" method="post" enctype="multipart/form-data" class="mt-4">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label" for="import_type">Import type</label>
                                    <select name="import_type" id="import_type" class="form-select @error('import_type') is-invalid @enderror" required>
                                        <option value="watercourses" @selected(old('import_type', 'watercourses') === 'watercourses')>Watercourses — full hierarchy</option>
                                        <option value="minors" @selected(old('import_type') === 'minors')>Minors (through minor)</option>
                                        <option value="distributaries" @selected(old('import_type') === 'distributaries')>Distributaries (through distributary)</option>
                                        <option value="branch_canals" @selected(old('import_type') === 'branch_canals')>Branch canals (through branch_canal)</option>
                                        <option value="sub_canals" @selected(old('import_type') === 'sub_canals')>Sub canals (barrage, main_canal, sub_canal)</option>
                                        <option value="main_canals" @selected(old('import_type') === 'main_canals')>Main canals (barrage + main_canal)</option>
                                        <option value="barrages" @selected(old('import_type') === 'barrages')>Barrages only</option>
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
                                <a href="{{ route('barrages.index') }}" class="btn btn-secondary ms-2">Cancel</a>
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
                                <a class="btn btn-outline-primary btn-sm" href="{{ route('channels.import.template', ['type' => 'barrages']) }}">Barrages template (.xlsx)</a>
                                <a class="btn btn-outline-primary btn-sm" href="{{ route('channels.import.template', ['type' => 'main_canals']) }}">Main canals template (.xlsx)</a>
                                <a class="btn btn-outline-primary btn-sm" href="{{ route('channels.import.template', ['type' => 'sub_canals']) }}">Sub canals template (.xlsx)</a>
                                <a class="btn btn-outline-primary btn-sm" href="{{ route('channels.import.template', ['type' => 'branch_canals']) }}">Branch canals template (.xlsx)</a>
                                <a class="btn btn-outline-primary btn-sm" href="{{ route('channels.import.template', ['type' => 'distributaries']) }}">Distributaries template (.xlsx)</a>
                                <a class="btn btn-outline-primary btn-sm" href="{{ route('channels.import.template', ['type' => 'minors']) }}">Minors template (.xlsx)</a>
                                <a class="btn btn-outline-primary btn-sm" href="{{ route('channels.import.template', ['type' => 'watercourses']) }}">Full hierarchy / WC template (.xlsx)</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
