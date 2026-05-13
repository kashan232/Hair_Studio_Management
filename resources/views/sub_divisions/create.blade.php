@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">@if(!isset($subDivision)) Create Sub-Division @else Update Sub-Division @endif</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('sub_divisions.index')}}">Sub-Divisions</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@if(!isset($subDivision)) Create @else Update @endif</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Sub-Division Details</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ isset($subDivision) ? route('sub_divisions.update', $subDivision->id) : route('sub_divisions.store') }}" class="ajaxForm row">
                                @csrf
                                @if(isset($subDivision)) @method('PUT') @endif
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Region / Zone</label>
                                    <select id="zone_id" class="form-control form-select" required>
                                        <option value="">Select Zone</option>
                                        @foreach($zones as $zone)
                                            <option value="{{ $zone->id }}" {{ (isset($subDivision) && $subDivision->division->circle->zone_id == $zone->id) ? 'selected' : '' }}>{{ $zone->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Circle</label>
                                    <select id="circle_id" class="form-control form-select" required>
                                        <option value="">Select Circle</option>
                                        @if(isset($circles))
                                            @foreach($circles as $circle)
                                                <option value="{{ $circle->id }}" {{ $subDivision->division->circle_id == $circle->id ? 'selected' : '' }}>{{ $circle->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Division</label>
                                    <select name="division_id" id="division_id" class="form-control form-select" required>
                                        <option value="">Select Division</option>
                                        @if(isset($divisions))
                                            @foreach($divisions as $division)
                                                <option value="{{ $division->id }}" {{ $subDivision->division_id == $division->id ? 'selected' : '' }}>{{ $division->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Sub-Division Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $subDivision->name ?? '' }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Code</label>
                                    <input type="text" class="form-control" name="code" value="{{ $subDivision->code ?? '' }}">
                                </div>

                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-primary">Save Sub-Division</button>
                                    <a href="{{ route('sub_divisions.index') }}" class="btn btn-light">Cancel</a>
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
    $('#zone_id').on('change', function() {
        var zoneId = $(this).val();
        $('#circle_id').html('<option value="">Loading...</option>');
        $('#division_id').html('<option value="">Select Division</option>');
        if (zoneId) {
            $.ajax({
                url: '{{ url('get-circles') }}/' + zoneId,
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

    $('#circle_id').on('change', function() {
        var circleId = $(this).val();
        $('#division_id').html('<option value="">Loading...</option>');
        if (circleId) {
            $.ajax({
                url: '{{ url('get-divisions') }}/' + circleId,
                type: 'GET',
                success: function(data) {
                    $('#division_id').html('<option value="">Select Division</option>');
                    $.each(data, function(key, value) {
                        $('#division_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        } else {
            $('#division_id').html('<option value="">Select Division</option>');
        }
    });
});
</script>
@endsection
