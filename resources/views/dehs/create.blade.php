@extends('layouts.main')
@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">@if(!isset($deh)) Create Deh @else Update Deh @endif</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('dehs.index')}}">Dehs</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@if(!isset($deh)) Create @else Update @endif</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Deh Details</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ isset($deh) ? route('dehs.update', $deh->id) : route('dehs.store') }}" class="ajaxForm row">
                                @csrf
                                @if(isset($deh)) @method('PUT') @endif
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Select Revenue Division</label>
                                    <select id="revenue_division_id" class="form-control form-select" required>
                                        <option value="">Select Division</option>
                                        @foreach($divisions as $division)
                                            <option value="{{ $division->id }}" {{ (isset($deh) && $deh->tappa->revenueCircle->taluka->district->revenue_division_id == $division->id) ? 'selected' : '' }}>{{ $division->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Select District</label>
                                    <select id="district_id" class="form-control form-select" required>
                                        <option value="">Select District</option>
                                        @if(isset($districts))
                                            @foreach($districts as $district)
                                                <option value="{{ $district->id }}" {{ (isset($deh) && $deh->tappa->revenueCircle->taluka->district_id == $district->id) ? 'selected' : '' }}>{{ $district->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Select Taluka</label>
                                    <select id="taluka_id" class="form-control form-select" required>
                                        <option value="">Select Taluka</option>
                                        @if(isset($talukas))
                                            @foreach($talukas as $taluka)
                                                <option value="{{ $taluka->id }}" {{ (isset($deh) && $deh->tappa->revenueCircle->taluka_id == $taluka->id) ? 'selected' : '' }}>{{ $taluka->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Select Revenue Circle</label>
                                    <select id="revenue_circle_id" class="form-control form-select" required>
                                        <option value="">Select Circle</option>
                                        @if(isset($circles))
                                            @foreach($circles as $circle)
                                                <option value="{{ $circle->id }}" {{ (isset($deh) && $deh->tappa->revenue_circle_id == $circle->id) ? 'selected' : '' }}>{{ $circle->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Select Tappa</label>
                                    <select name="tappa_id" id="tappa_id" class="form-control form-select" required>
                                        <option value="">Select Tappa</option>
                                        @if(isset($tappas))
                                            @foreach($tappas as $tappa)
                                                <option value="{{ $tappa->id }}" {{ (isset($deh) && $deh->tappa_id == $tappa->id) ? 'selected' : '' }}>{{ $tappa->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Deh Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $deh->name ?? '' }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Code</label>
                                    <input type="text" class="form-control" name="code" value="{{ $deh->code ?? '' }}">
                                </div>

                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-primary">Save Deh</button>
                                    <a href="{{ route('dehs.index') }}" class="btn btn-light">Cancel</a>
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
    $('#revenue_division_id').on('change', function() {
        var divisionId = $(this).val();
        $('#district_id').html('<option value="">Loading...</option>');
        $('#taluka_id').html('<option value="">Select Taluka</option>');
        $('#revenue_circle_id').html('<option value="">Select Circle</option>');
        $('#tappa_id').html('<option value="">Select Tappa</option>');
        if (divisionId) {
            $.ajax({
                url: '{{ url('get-districts') }}/' + divisionId,
                type: 'GET',
                success: function(data) {
                    $('#district_id').html('<option value="">Select District</option>');
                    $.each(data, function(key, value) {
                        $('#district_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        } else {
            $('#district_id').html('<option value="">Select District</option>');
        }
    });

    $('#district_id').on('change', function() {
        var districtId = $(this).val();
        $('#taluka_id').html('<option value="">Loading...</option>');
        $('#revenue_circle_id').html('<option value="">Select Circle</option>');
        $('#tappa_id').html('<option value="">Select Tappa</option>');
        if (districtId) {
            $.ajax({
                url: '{{ url('get-talukas') }}/' + districtId,
                type: 'GET',
                success: function(data) {
                    $('#taluka_id').html('<option value="">Select Taluka</option>');
                    $.each(data, function(key, value) {
                        $('#taluka_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        } else {
            $('#taluka_id').html('<option value="">Select Taluka</option>');
        }
    });

    $('#taluka_id').on('change', function() {
        var talukaId = $(this).val();
        $('#revenue_circle_id').html('<option value="">Loading...</option>');
        $('#tappa_id').html('<option value="">Select Tappa</option>');
        if (talukaId) {
            $.ajax({
                url: '{{ url('get-revenue-circles') }}/' + talukaId,
                type: 'GET',
                success: function(data) {
                    $('#revenue_circle_id').html('<option value="">Select Circle</option>');
                    $.each(data, function(key, value) {
                        $('#revenue_circle_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        } else {
            $('#revenue_circle_id').html('<option value="">Select Circle</option>');
        }
    });

    $('#revenue_circle_id').on('change', function() {
        var circleId = $(this).val();
        $('#tappa_id').html('<option value="">Loading...</option>');
        if (circleId) {
            $.ajax({
                url: '{{ url('get-tappas') }}/' + circleId,
                type: 'GET',
                success: function(data) {
                    $('#tappa_id').html('<option value="">Select Tappa</option>');
                    $.each(data, function(key, value) {
                        $('#tappa_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        } else {
            $('#tappa_id').html('<option value="">Select Tappa</option>');
        }
    });
});
</script>
@endsection
