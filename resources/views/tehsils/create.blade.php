@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">Create tehsil</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('tehsils.index') }}">Tehsils</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0">New tehsil</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('tehsils.store') }}" method="post" id="tehsil-form">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" for="district_id">District</label>
                                    <select name="district_id" id="district_id" class="form-select @error('district_id') is-invalid @enderror" required>
                                        <option value="">Select district</option>
                                        @foreach ($districts as $district)
                                            <option value="{{ $district->id }}" @selected(old('district_id') == $district->id)>{{ $district->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('district_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="taluka_id">Taluka</label>
                                    <select name="taluka_id" id="taluka_id" class="form-select @error('taluka_id') is-invalid @enderror" required>
                                        <option value="">Select taluka</option>
                                    </select>
                                    <small class="text-muted">Talukas load when you choose a district.</small>
                                    @error('taluka_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="name">Tehsil name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required maxlength="255">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="{{ route('tehsils.index') }}" class="btn btn-secondary">Cancel</a>
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

    function loadTalukas(districtId, selectedTalukaId) {
        fillSelect($('#taluka_id'), [], 'Select taluka');
        if (!districtId) {
            return;
        }
        $.getJSON(baseUrl + '/cascade/talukas/' + districtId)
            .done(function (data) {
                fillSelect($('#taluka_id'), data, 'Select taluka');
                if (selectedTalukaId) {
                    $('#taluka_id').val(String(selectedTalukaId));
                }
            });
    }

    $('#district_id').on('change', function () {
        loadTalukas($(this).val(), null);
    });

    @if (old('district_id'))
        loadTalukas(@json(old('district_id')), @json(old('taluka_id')));
    @endif
});
</script>
@endsection
