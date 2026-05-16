@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">Edit DEH</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('dehs.index') }}">DEHs</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 col-lg-7">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0">{{ $deh->name }}</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('dehs.update', $deh) }}" method="post" id="deh-form">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="form-label" for="district_id">District</label>
                                    <select name="district_id" id="district_id" class="form-select @error('district_id') is-invalid @enderror" required>
                                        <option value="">Select district</option>
                                        @foreach ($districts as $district)
                                            <option value="{{ $district->id }}" @selected(old('district_id', $districtId) == $district->id)>{{ $district->name }}</option>
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
                                        @foreach ($talukas as $taluka)
                                            <option value="{{ $taluka->id }}" @selected(old('taluka_id', $talukaId) == $taluka->id)>{{ $taluka->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('taluka_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="tehsil_id">Tehsil</label>
                                    <select name="tehsil_id" id="tehsil_id" class="form-select @error('tehsil_id') is-invalid @enderror" required>
                                        <option value="">Select tehsil</option>
                                        @foreach ($tehsils as $tehsil)
                                            <option value="{{ $tehsil->id }}" @selected(old('tehsil_id', $deh->tehsil_id) == $tehsil->id)>{{ $tehsil->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('tehsil_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <small id="existing-dehs-hint" class="text-muted"></small>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="name">DEH name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $deh->name) }}" class="form-control @error('name') is-invalid @enderror" required maxlength="255">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('dehs.index') }}" class="btn btn-secondary">Cancel</a>
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
    var editDehId = @json($deh->id);

    function fillSelect($el, items, placeholder) {
        $el.empty();
        $el.append($('<option></option>').val('').text(placeholder));
        $.each(items, function (_, row) {
            $el.append($('<option></option>').val(row.id).text(row.name));
        });
    }

    function loadDehHint(tehsilId) {
        $('#existing-dehs-hint').text('');
        if (!tehsilId) {
            return;
        }
        $.getJSON(baseUrl + '/cascade/dehs/' + tehsilId, function (list) {
            if (!list.length) {
                $('#existing-dehs-hint').text('No existing DEHs under this tehsil yet.');
                return;
            }
            var others = list.filter(function (r) { return String(r.id) !== String(editDehId); });
            var label = others.length === list.length
                ? ('Existing DEHs (' + list.length + '): ' + list.map(function (r) { return r.name; }).join(', '))
                : ('Other DEHs under this tehsil (' + others.length + '): ' + others.map(function (r) { return r.name; }).join(', '));
            $('#existing-dehs-hint').text(label);
        });
    }

    $('#district_id').on('change', function () {
        fillSelect($('#taluka_id'), [], 'Select taluka');
        fillSelect($('#tehsil_id'), [], 'Select tehsil');
        $('#existing-dehs-hint').text('');
        var districtId = $(this).val();
        if (!districtId) {
            return;
        }
        $.getJSON(baseUrl + '/cascade/talukas/' + districtId, function (data) {
            fillSelect($('#taluka_id'), data, 'Select taluka');
        });
    });

    $('#taluka_id').on('change', function () {
        fillSelect($('#tehsil_id'), [], 'Select tehsil');
        $('#existing-dehs-hint').text('');
        var talukaId = $(this).val();
        if (!talukaId) {
            return;
        }
        $.getJSON(baseUrl + '/cascade/tehsils/' + talukaId, function (data) {
            fillSelect($('#tehsil_id'), data, 'Select tehsil');
        });
    });

    $('#tehsil_id').on('change', function () {
        loadDehHint($(this).val());
    });

    @if (old('district_id') !== null)
        $.getJSON(baseUrl + '/cascade/talukas/' + @json(old('district_id')))
            .done(function (data) {
                fillSelect($('#taluka_id'), data, 'Select taluka');
                var talukaVal = @json(old('taluka_id'));
                if (talukaVal) {
                    $('#taluka_id').val(String(talukaVal));
                    $.getJSON(baseUrl + '/cascade/tehsils/' + talukaVal)
                        .done(function (data2) {
                            fillSelect($('#tehsil_id'), data2, 'Select tehsil');
                            var tehsilVal = @json(old('tehsil_id'));
                            if (tehsilVal) {
                                $('#tehsil_id').val(String(tehsilVal));
                                loadDehHint(tehsilVal);
                            }
                        });
                }
            });
    @else
        loadDehHint(@json($deh->tehsil_id));
    @endif
});
</script>
@endsection
