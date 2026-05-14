@extends('layouts.main')
@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">@if(!isset($circle)) Create Revenue Circle @else Update Revenue Circle @endif</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('revenue_circles.index')}}">Revenue Circles</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@if(!isset($circle)) Create @else Update @endif</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Revenue Circle Details</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ isset($circle) ? route('revenue_circles.update', $circle->id) : route('revenue_circles.store') }}" class="ajaxForm row">
                                @csrf
                                @if(isset($circle)) @method('PUT') @endif
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Select Revenue Division</label>
                                    <select id="revenue_division_id" class="form-control form-select" required>
                                        <option value="">Select Division</option>
                                        @foreach($divisions as $division)
                                            <option value="{{ $division->id }}" {{ (isset($circle) && $circle->taluka->district->revenue_division_id == $division->id) ? 'selected' : '' }}>{{ $division->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Select District</label>
                                    <select id="district_id" class="form-control form-select" required>
                                        <option value="">Select District</option>
                                        @if(isset($districts))
                                            @foreach($districts as $district)
                                                <option value="{{ $district->id }}" {{ (isset($circle) && $circle->taluka->district_id == $district->id) ? 'selected' : '' }}>{{ $district->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Select Taluka</label>
                                    <select name="taluka_id" id="taluka_id" class="form-control form-select" required>
                                        <option value="">Select Taluka</option>
                                        @if(isset($talukas))
                                            @foreach($talukas as $taluka)
                                                <option value="{{ $taluka->id }}" {{ (isset($circle) && $circle->taluka_id == $taluka->id) ? 'selected' : '' }}>{{ $taluka->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Circle Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $circle->name ?? '' }}" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Code</label>
                                    <input type="text" class="form-control" name="code" value="{{ $circle->code ?? '' }}">
                                </div>

                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-primary">Save Circle</button>
                                    <a href="{{ route('revenue_circles.index') }}" class="btn btn-light">Cancel</a>
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
});
</script>
@endsection
