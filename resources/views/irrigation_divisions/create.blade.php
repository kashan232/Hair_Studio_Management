@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">@if(!isset($irrigation_division)) Create Irrigation Division @else Update Irrigation Division @endif</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('irrigation_divisions.index')}}">Irrigation Divisions</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@if(!isset($irrigation_division)) Create @else Update @endif</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Irrigation Division Details</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ isset($irrigation_division) ? route('irrigation_divisions.update', $irrigation_division->id) : route('irrigation_divisions.store') }}" class="ajaxForm row">
                                @csrf
                                @if(isset($irrigation_division)) @method('PUT') @endif
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Select Unit</label>
                                    <select id="unit_id" class="form-control form-select" required>
                                        <option value="">Select Unit</option>
                                        @foreach($units as $unit)
                                            <option value="{{ $unit->id }}" {{ (isset($irrigation_division) && $irrigation_division->circle->region->unit_id == $unit->id) ? 'selected' : '' }}>{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Select Region</label>
                                    <select id="region_id" class="form-control form-select" required>
                                        <option value="">Select Region</option>
                                        @if(isset($regions))
                                            @foreach($regions as $region)
                                                <option value="{{ $region->id }}" {{ (isset($irrigation_division) && $irrigation_division->circle->region_id == $region->id) ? 'selected' : '' }}>{{ $region->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Select Circle</label>
                                    <select name="circle_id" id="circle_id" class="form-control form-select" required>
                                        <option value="">Select Circle</option>
                                        @if(isset($circles))
                                            @foreach($circles as $circle)
                                                <option value="{{ $circle->id }}" {{ (isset($irrigation_division) && $irrigation_division->circle_id == $circle->id) ? 'selected' : '' }}>{{ $circle->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Irrigation Division Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $irrigation_division->name ?? '' }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Code</label>
                                    <input type="text" class="form-control" name="code" value="{{ $irrigation_division->code ?? '' }}">
                                </div>

                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-primary">Save Irrigation Division</button>
                                    <a href="{{ route('irrigation_divisions.index') }}" class="btn btn-light">Cancel</a>
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
    $('#unit_id').on('change', function() {
        var unitId = $(this).val();
        $('#region_id').html('<option value="">Loading...</option>');
        if (unitId) {
            $.ajax({
                url: '{{ url('get-regions') }}/' + unitId,
                type: 'GET',
                success: function(data) {
                    $('#region_id').html('<option value="">Select Region</option>');
                    $.each(data, function(key, value) {
                        $('#region_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        } else {
            $('#region_id').html('<option value="">Select Region</option>');
        }
    });

    $('#region_id').on('change', function() {
        var regionId = $(this).val();
        $('#circle_id').html('<option value="">Loading...</option>');
        if (regionId) {
            $.ajax({
                url: '{{ url('get-circles') }}/' + regionId,
                type: 'GET',
                success: function(data) {
                    $('#circle_id').html('<option value="">Select Circle</option>');
                    $.each(data, function(key, value) {
                        $('#circle_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        } else {
            $('#circle_id').html('<option value="">Select Circle</option>');
        }
    });
});
</script>
@endsection
