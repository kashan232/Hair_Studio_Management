@extends('layouts.main')
@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1 class="page-title">@if(!isset($beat)) Create Beat @else Update Beat @endif</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('beats.index')}}">Beats</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@if(!isset($beat)) Create @else Update @endif</li>
                    </ol>
                </div>
            </div>
            <!-- PAGE HEADER END -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Beat Details</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ isset($beat) ? route('beats.update', $beat->id) : route('beats.store') }}" class="ajaxForm row">
                                @csrf
                                @if(isset($beat)) @method('PUT') @endif
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Select Unit</label>
                                    <select id="unit_id" class="form-control form-select" required>
                                        <option value="">Select Unit</option>
                                        @foreach($units as $unit)
                                            <option value="{{ $unit->id }}" {{ (isset($beat) && $beat->subDivision->irrigationDivision->circle->region->unit_id == $unit->id) ? 'selected' : '' }}>{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Select Region</label>
                                    <select id="region_id" class="form-control form-select" required>
                                        <option value="">Select Region</option>
                                        @if(isset($regions))
                                            @foreach($regions as $r)
                                                <option value="{{ $r->id }}" {{ (isset($beat) && $beat->subDivision->irrigationDivision->circle->region_id == $r->id) ? 'selected' : '' }}>{{ $r->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Select Circle</label>
                                    <select id="circle_id" class="form-control form-select" required>
                                        <option value="">Select Circle</option>
                                        @if(isset($circles))
                                            @foreach($circles as $c)
                                                <option value="{{ $c->id }}" {{ (isset($beat) && $beat->subDivision->irrigationDivision->circle_id == $c->id) ? 'selected' : '' }}>{{ $c->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Select Irrigation Division</label>
                                    <select id="irrigation_division_id" class="form-control form-select" required>
                                        <option value="">Select Division</option>
                                        @if(isset($irrigation_divisions))
                                            @foreach($irrigation_divisions as $idv)
                                                <option value="{{ $idv->id }}" {{ (isset($beat) && $beat->subDivision->irrigation_division_id == $idv->id) ? 'selected' : '' }}>{{ $idv->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Select Sub-Division</label>
                                    <select name="sub_division_id" id="sub_division_id" class="form-control form-select" required>
                                        <option value="">Select Sub-Division</option>
                                        @if(isset($subDivisions))
                                            @foreach($subDivisions as $sd)
                                                <option value="{{ $sd->id }}" {{ (isset($beat) && $beat->sub_division_id == $sd->id) ? 'selected' : '' }}>{{ $sd->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Beat Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $beat->name ?? '' }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Code</label>
                                    <input type="text" class="form-control" name="code" value="{{ $beat->code ?? '' }}">
                                </div>

                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-primary">Save Beat</button>
                                    <a href="{{ route('beats.index') }}" class="btn btn-light">Cancel</a>
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
        $('#circle_id').html('<option value="">Select Circle</option>');
        $('#irrigation_division_id').html('<option value="">Select Division</option>');
        $('#sub_division_id').html('<option value="">Select Sub-Division</option>');
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
        $('#irrigation_division_id').html('<option value="">Select Division</option>');
        $('#sub_division_id').html('<option value="">Select Sub-Division</option>');
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

    $('#circle_id').on('change', function() {
        var circleId = $(this).val();
        $('#irrigation_division_id').html('<option value="">Loading...</option>');
        $('#sub_division_id').html('<option value="">Select Sub-Division</option>');
        if (circleId) {
            $.ajax({
                url: '{{ url('get-irrigation-divisions') }}/' + circleId,
                type: 'GET',
                success: function(data) {
                    $('#irrigation_division_id').html('<option value="">Select Division</option>');
                    $.each(data, function(key, value) {
                        $('#irrigation_division_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        } else {
            $('#irrigation_division_id').html('<option value="">Select Division</option>');
        }
    });

    $('#irrigation_division_id').on('change', function() {
        var divisionId = $(this).val();
        $('#sub_division_id').html('<option value="">Loading...</option>');
        if (divisionId) {
            $.ajax({
                url: '{{ url('get-sub-divisions') }}/' + divisionId,
                type: 'GET',
                success: function(data) {
                    $('#sub_division_id').html('<option value="">Select Sub-Division</option>');
                    $.each(data, function(key, value) {
                        $('#sub_division_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        } else {
            $('#sub_division_id').html('<option value="">Select Sub-Division</option>');
        }
    });
});
</script>
@endsection
