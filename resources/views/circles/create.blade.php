@extends('layouts.main')
@section('css')
@endsection

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1 class="page-title">@if(!isset($circle)) Create Circle @else Update Circle @endif</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('circles.index')}}">Circles</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@if(!isset($circle)) Create @else Update @endif</li>
                    </ol>
                </div>
            </div>
            <!-- PAGE HEADER END -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Circle Details</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ isset($circle) ? route('circles.update', $circle->id) : route('circles.store') }}" class="ajaxForm row">
                                @csrf
                                @if(isset($circle)) @method('PUT') @endif
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Region / Zone</label>
                                    <select name="zone_id" class="form-control form-select" required>
                                        <option value="">Select Region / Zone</option>
                                        @foreach($zones as $zone)
                                            <option value="{{ $zone->id }}" {{ (isset($circle) && $circle->zone_id == $zone->id) ? 'selected' : '' }}>{{ $zone->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Circle Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $circle->name ?? '' }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Code</label>
                                    <input type="text" class="form-control" name="code" value="{{ $circle->code ?? '' }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" name="full_name" value="{{ $circle->full_name ?? '' }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Job Title</label>
                                    <input type="text" class="form-control" name="job_title" value="{{ $circle->job_title ?? '' }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Cell No</label>
                                    <input type="text" class="form-control" name="cell_no" value="{{ $circle->cell_no ?? '' }}">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Full Address</label>
                                    <textarea class="form-control" name="full_address" rows="3">{{ $circle->full_address ?? '' }}</textarea>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-primary">Save Circle</button>
                                    <a href="{{ route('circles.index') }}" class="btn btn-light">Cancel</a>
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
    //
});
</script>
@endsection
