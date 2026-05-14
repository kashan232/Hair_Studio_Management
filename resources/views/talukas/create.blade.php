@extends('layouts.main')
@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">@if(!isset($taluka)) Create Taluka @else Update Taluka @endif</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('talukas.index')}}">Talukas</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@if(!isset($taluka)) Create @else Update @endif</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Taluka Details</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ isset($taluka) ? route('talukas.update', $taluka->id) : route('talukas.store') }}" class="ajaxForm row">
                                @csrf
                                @if(isset($taluka)) @method('PUT') @endif
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Select Revenue Division</label>
                                    <select id="revenue_division_id" class="form-control form-select" required>
                                        <option value="">Select Division</option>
                                        @foreach($divisions as $division)
                                            <option value="{{ $division->id }}" {{ (isset($taluka) && $taluka->district->revenue_division_id == $division->id) ? 'selected' : '' }}>{{ $division->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Select District</label>
                                    <select name="district_id" id="district_id" class="form-control form-select" required>
                                        <option value="">Select District</option>
                                        @if(isset($districts))
                                            @foreach($districts as $district)
                                                <option value="{{ $district->id }}" {{ (isset($taluka) && $taluka->district_id == $district->id) ? 'selected' : '' }}>{{ $district->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Taluka Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $taluka->name ?? '' }}" required>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Code</label>
                                    <input type="text" class="form-control" name="code" value="{{ $taluka->code ?? '' }}">
                                </div>

                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-primary">Save Taluka</button>
                                    <a href="{{ route('talukas.index') }}" class="btn btn-light">Cancel</a>
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
});
</script>
@endsection
