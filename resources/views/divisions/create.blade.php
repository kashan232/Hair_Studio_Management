@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">@if(!isset($division)) Create Division @else Update Division @endif</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('divisions.index')}}">Divisions</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@if(!isset($division)) Create @else Update @endif</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Division Details</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ isset($division) ? route('divisions.update', $division->id) : route('divisions.store') }}" class="ajaxForm row">
                                @csrf
                                @if(isset($division)) @method('PUT') @endif
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Region / Zone</label>
                                    <select id="zone_id" class="form-control form-select" required>
                                        <option value="">Select Zone</option>
                                        @foreach($zones as $zone)
                                            <option value="{{ $zone->id }}" {{ (isset($division) && $division->circle->zone_id == $zone->id) ? 'selected' : '' }}>{{ $zone->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Circle</label>
                                    <select name="circle_id" id="circle_id" class="form-control form-select" required>
                                        <option value="">Select Circle</option>
                                        @if(isset($circles))
                                            @foreach($circles as $circle)
                                                <option value="{{ $circle->id }}" {{ $division->circle_id == $circle->id ? 'selected' : '' }}>{{ $circle->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Division Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $division->name ?? '' }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Code</label>
                                    <input type="text" class="form-control" name="code" value="{{ $division->code ?? '' }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" name="full_name" value="{{ $division->full_name ?? '' }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Job Title</label>
                                    <input type="text" class="form-control" name="job_title" value="{{ $division->job_title ?? '' }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Cell No</label>
                                    <input type="text" class="form-control" name="cell_no" value="{{ $division->cell_no ?? '' }}">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Full Address</label>
                                    <textarea class="form-control" name="full_address" rows="3">{{ $division->full_address ?? '' }}</textarea>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-primary">Save Division</button>
                                    <a href="{{ route('divisions.index') }}" class="btn btn-light">Cancel</a>
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
});
</script>
@endsection
