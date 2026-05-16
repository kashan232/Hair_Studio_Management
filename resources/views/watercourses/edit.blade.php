@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">Edit Watercourse</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('watercourses.index') }}">Watercourses</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 col-lg-7">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0">{{ $watercourse->name }}</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('watercourses.update', $watercourse) }}" method="post" id="watercourse-form">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="form-label" for="barrage_id">Barrage</label>
                                    <select name="barrage_id" id="barrage_id" class="form-select @error('barrage_id') is-invalid @enderror" required>
                                        <option value="">Select barrage</option>
                                        @foreach ($barrages as $barrage)
                                            <option value="{{ $barrage->id }}" @selected(old('barrage_id', $barrageId) == $barrage->id)>{{ $barrage->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('barrage_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="main_canal_id">Main canal</label>
                                    <select name="main_canal_id" id="main_canal_id" class="form-select @error('main_canal_id') is-invalid @enderror" required>
                                        <option value="">Select mainCanal</option>
                                        @foreach ($mainCanals as $mainCanal)
                                            <option value="{{ $mainCanal->id }}" @selected(old('main_canal_id', $mainCanalId) == $mainCanal->id)>{{ $mainCanal->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('main_canal_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="sub_canal_id">Sub canal</label>
                                    <select name="sub_canal_id" id="sub_canal_id" class="form-select @error('sub_canal_id') is-invalid @enderror" required>
                                        <option value="">Select subCanal</option>
                                        @foreach ($subCanals as $subCanal)
                                            <option value="{{ $subCanal->id }}" @selected(old('sub_canal_id', $watercourse->sub_canal_id) == $subCanal->id)>{{ $subCanal->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('sub_canal_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <small id="existing-watercourses-hint" class="text-muted"></small>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="name">WC No / name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $watercourse->name) }}" class="form-control @error('name') is-invalid @enderror" required maxlength="255">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('watercourses.index') }}" class="btn btn-secondary">Cancel</a>
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
    var editDehId = @json($watercourse->id);

    function fillSelect($el, items, placeholder) {
        $el.empty();
        $el.append($('<option></option>').val('').text(placeholder));
        $.each(items, function (_, row) {
            $el.append($('<option></option>').val(row.id).text(row.name));
        });
    }

    function loadDehHint(subCanalId) {
        $('#existing-watercourses-hint').text('');
        if (!subCanalId) {
            return;
        }
        $.getJSON(baseUrl + '/cascade/watercourses/' + subCanalId, function (list) {
            if (!list.length) {
                $('#existing-watercourses-hint').text('No existing watercourses under this subCanal yet.');
                return;
            }
            var others = list.filter(function (r) { return String(r.id) !== String(editDehId); });
            var label = others.length === list.length
                ? ('Existing watercourses (' + list.length + '): ' + list.map(function (r) { return r.name; }).join(', '))
                : ('Other Watercourses under this subCanal (' + others.length + '): ' + others.map(function (r) { return r.name; }).join(', '));
            $('#existing-watercourses-hint').text(label);
        });
    }

    $('#barrage_id').on('change', function () {
        fillSelect($('#main_canal_id'), [], 'Select mainCanal');
        fillSelect($('#sub_canal_id'), [], 'Select subCanal');
        $('#existing-watercourses-hint').text('');
        var barrageId = $(this).val();
        if (!barrageId) {
            return;
        }
        $.getJSON(baseUrl + '/cascade/main-canals/' + barrageId, function (data) {
            fillSelect($('#main_canal_id'), data, 'Select mainCanal');
        });
    });

    $('#main_canal_id').on('change', function () {
        fillSelect($('#sub_canal_id'), [], 'Select subCanal');
        $('#existing-watercourses-hint').text('');
        var mainCanalId = $(this).val();
        if (!mainCanalId) {
            return;
        }
        $.getJSON(baseUrl + '/cascade/sub-canals/' + mainCanalId, function (data) {
            fillSelect($('#sub_canal_id'), data, 'Select subCanal');
        });
    });

    $('#sub_canal_id').on('change', function () {
        loadDehHint($(this).val());
    });

    @if (old('barrage_id') !== null)
        $.getJSON(baseUrl + '/cascade/main-canals/' + @json(old('barrage_id')))
            .done(function (data) {
                fillSelect($('#main_canal_id'), data, 'Select mainCanal');
                var mainCanalVal = @json(old('main_canal_id'));
                if (mainCanalVal) {
                    $('#main_canal_id').val(String(mainCanalVal));
                    $.getJSON(baseUrl + '/cascade/sub-canals/' + mainCanalVal)
                        .done(function (data2) {
                            fillSelect($('#sub_canal_id'), data2, 'Select subCanal');
                            var subCanalVal = @json(old('sub_canal_id'));
                            if (subCanalVal) {
                                $('#sub_canal_id').val(String(subCanalVal));
                                loadDehHint(subCanalVal);
                            }
                        });
                }
            });
    @else
        loadDehHint(@json($watercourse->sub_canal_id));
    @endif
});
</script>
@endsection
