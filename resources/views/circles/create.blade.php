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
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Select Unit</label>
                                    <select name="unit_id" id="unit_id" class="form-control select2" required>
                                        <option value="">Select Unit</option>
                                        @foreach($units as $unit)
                                            <option value="{{ $unit->id }}" {{ (isset($circle) && $circle->region->unit_id == $unit->id) ? 'selected' : '' }}>{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Select Region</label>
                                    <select name="region_id" id="region_id" class="form-control select2" required>
                                        <option value="">Select Region</option>
                                        @if(isset($regions))
                                            @foreach($regions as $region)
                                                <option value="{{ $region->id }}" {{ (isset($circle) && $circle->region_id == $region->id) ? 'selected' : '' }}>{{ $region->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Circle Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $circle->name ?? '' }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Code</label>
                                    <input type="text" class="form-control" name="code" value="{{ $circle->code ?? '' }}">
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
    $('#unit_id').on('change', function() {
        var unit_id = $(this).val();
        if (unit_id) {
            $.ajax({
                url: '{{ url('get-regions') }}/' + unit_id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#region_id').empty();
                    $('#region_id').append('<option value="">Select Region</option>');
                    $.each(data, function(key, value) {
                        $('#region_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        } else {
            $('#region_id').empty();
            $('#region_id').append('<option value="">Select Region</option>');
        }
    });
});
</script>
@endsection
