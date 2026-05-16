@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">Edit Sub Division</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sub-divisions.index') }}">Sub Divisions</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0">Edit Sub Division: {{ $subDivision->name }}</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('sub-divisions.update', $subDivision) }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="form-label" for="circle_id">Circle</label>
                                    <select name="circle_id" id="circle_id" class="form-control form-select" required>
                                        <option value="">Select Circle</option>
                                        @foreach($circles as $circle)
                                            <option value="{{ $circle->id }}" {{ old('circle_id', $circleId) == $circle->id ? 'selected' : '' }}>{{ $circle->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="division_id">Division</label>
                                    <select name="division_id" id="division_id" class="form-control form-select @error('division_id') is-invalid @enderror" required>
                                        <option value="">Select Division</option>
                                        @foreach($divisions as $division)
                                            <option value="{{ $division->id }}" {{ old('division_id', $subDivision->division_id) == $division->id ? 'selected' : '' }}>{{ $division->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Changing Circle reloads Divisions via AJAX.</small>
                                    @error('division_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="name">Sub Division Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $subDivision->name) }}" class="form-control @error('name') is-invalid @enderror" required maxlength="255">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('sub-divisions.index') }}" class="btn btn-secondary">Cancel</a>
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
$(function () {
    var baseUrl = @json(url('/'));

    function fillSelect($el, items, placeholder) {
        $el.empty();
        $el.append($('<option></option>').val('').text(placeholder));
        $.each(items, function (_, row) {
            $el.append($('<option></option>').val(row.id).text(row.name));
        });
    }

    function loadDivisions(circleId, selectedDivisionId) {
        fillSelect($('#division_id'), [], 'Select Division');
        if (!circleId) {
            return;
        }
        $.getJSON(baseUrl + '/cascade/divisions/' + circleId)
            .done(function (data) {
                fillSelect($('#division_id'), data, 'Select Division');
                if (selectedDivisionId) {
                    $('#division_id').val(String(selectedDivisionId));
                }
            });
    }

    $('#circle_id').on('change', function () {
        loadDivisions($(this).val(), null);
    });

    @if (old('circle_id') !== null)
        loadDivisions(@json(old('circle_id')), @json(old('division_id', $subDivision->division_id)));
    @endif
});
</script>
@endsection
