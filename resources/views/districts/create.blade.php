@extends('layouts.main')
@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">@if(!isset($district)) Create District @else Update District @endif</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('districts.index')}}">Districts</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@if(!isset($district)) Create @else Update @endif</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">District Details</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ isset($district) ? route('districts.update', $district->id) : route('districts.store') }}" class="ajaxForm row">
                                @csrf
                                @if(isset($district)) @method('PUT') @endif
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Select Revenue Division</label>
                                    <select name="revenue_division_id" class="form-control form-select" required>
                                        <option value="">Select Division</option>
                                        @foreach($divisions as $division)
                                            <option value="{{ $division->id }}" {{ (isset($district) && $district->revenue_division_id == $division->id) ? 'selected' : '' }}>{{ $division->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">District Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $district->name ?? '' }}" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Code</label>
                                    <input type="text" class="form-control" name="code" value="{{ $district->code ?? '' }}">
                                </div>

                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-primary">Save District</button>
                                    <a href="{{ route('districts.index') }}" class="btn btn-light">Cancel</a>
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
