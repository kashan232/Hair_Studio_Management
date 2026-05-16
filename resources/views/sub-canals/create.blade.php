@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">Create subCanal</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sub-canals.index') }}">Sub canals</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0">New subCanal</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('sub-canals.store') }}" method="post" id="sub-canal-form">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" for="barrage_id">Barrage</label>
                                    <select name="barrage_id" id="barrage_id" class="form-select @error('barrage_id') is-invalid @enderror" required>
                                        <option value="">Select barrage</option>
                                        @foreach ($barrages as $barrage)
                                            <option value="{{ $barrage->id }}" @selected(old('barrage_id') == $barrage->id)>{{ $barrage->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('barrage_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="main_canal_id">Main canal</label>
                                    <select name="main_canal_id" id="main_canal_id" class="form-select @error('main_canal_id') is-invalid @enderror" required>
                                        <option value="">Select main canal</option>
                                    </select>
                                    <small class="text-muted">Main canals load when you choose a barrage.</small>
                                    @error('main_canal_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="name">Sub canal name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required maxlength="255">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="{{ route('sub-canals.index') }}" class="btn btn-secondary">Cancel</a>
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

    function loadMainCanals(barrageId, selectedMainCanalId) {
        fillSelect($('#main_canal_id'), [], 'Select main canal');
        if (!barrageId) {
            return;
        }
        $.getJSON(baseUrl + '/cascade/main-canals/' + barrageId)
            .done(function (data) {
                fillSelect($('#main_canal_id'), data, 'Select main canal');
                if (selectedMainCanalId) {
                    $('#main_canal_id').val(String(selectedMainCanalId));
                }
            });
    }

    $('#barrage_id').on('change', function () {
        loadMainCanals($(this).val(), null);
    });

    @if (old('barrage_id'))
        loadMainCanals(@json(old('barrage_id')), @json(old('main_canal_id')));
    @endif
});
</script>
@endsection
