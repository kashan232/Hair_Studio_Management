@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">Delete distributary</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('distributaries.index') }}">Distributaries</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Delete</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 col-lg-6">
                    <div class="card border-danger">
                        <div class="card-header bg-danger text-white">
                            <h3 class="card-title mb-0 text-white">Confirm deletion</h3>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">Delete distributary <strong>{{ $distributary->name }}</strong> ({{ $distributary->distributary->name }}, {{ $distributary->distributary->barrage->name }})?</p>
                            @if ($distributary->dehs_count > 0)
                                <div class="alert alert-warning mb-3">
                                    This distributary has <strong>{{ $distributary->dehs_count }}</strong> DEH(s). They will be removed with cascade.
                                </div>
                            @endif
                            <form action="{{ route('distributaries.destroy', $distributary) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Yes, delete permanently</button>
                            </form>
                            <a href="{{ route('distributaries.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
