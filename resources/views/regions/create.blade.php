@extends('layouts.main')
@section('css')
@endsection

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1 class="page-title">@if(!isset($region)) Create Region @else Update Region @endif</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('regions.index')}}">Regions</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@if(!isset($region)) Create @else Update @endif</li>
                    </ol>
                </div>
            </div>
            <!-- PAGE HEADER END -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Region Details</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ isset($region) ? route('regions.update', $region->id) : route('regions.store') }}" class="ajaxForm row">
                                @csrf
                                @if(isset($region)) @method('PUT') @endif
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Select Unit</label>
                                    <select name="unit_id" class="form-control select2" required>
                                        <option value="">Select Unit</option>
                                        @foreach($units as $unit)
                                            <option value="{{ $unit->id }}" {{ (isset($region) && $region->unit_id == $unit->id) ? 'selected' : '' }}>{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Region Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $region->name ?? '' }}" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Code</label>
                                    <input type="text" class="form-control" name="code" value="{{ $region->code ?? '' }}">
                                </div>

                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-primary">Save Region</button>
                                    <a href="{{ route('regions.index') }}" class="btn btn-light">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('JScript')
<script>
$(document).ready(function() {
    // Other scripts if needed
});
</script>
@endsection
