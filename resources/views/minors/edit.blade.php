@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">Edit minor</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('minors.index') }}">Minors</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0">{{ $minor->name }}</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('minors.update', $minor) }}" method="post" id="minor-form">
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
                                    <label class="form-label" for="minor_id">Minor</label>
                                    <select name="minor_id" id="minor_id" class="form-select @error('minor_id') is-invalid @enderror" required>
                                        <option value="">Select branch canal</option>
                                        @foreach ($minors as $minor)
                                            <option value="{{ $minor->id }}" @selected(old('minor_id', $minor->minor_id) == $minor->id)>{{ $minor->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Changing barrage reloads minors via AJAX.</small>
                                    @error('minor_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="name">Minor name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $minor->name) }}" class="form-control @error('name') is-invalid @enderror" required maxlength="255">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('minors.index') }}" class="btn btn-secondary">Cancel</a>
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

    function loadBranchCanals(barrageId, selectedBranchCanalId) {
        fillSelect($('#minor_id'), [], 'Select branch canal');
        if (!barrageId) {
            return;
        }
        $.getJSON(baseUrl + '/cascade/minors/' + barrageId)
            .done(function (data) {
                fillSelect($('#minor_id'), data, 'Select branch canal');
                if (selectedBranchCanalId) {
                    $('#minor_id').val(String(selectedBranchCanalId));
                }
            });
    }

    $('#barrage_id').on('change', function () {
        loadBranchCanals($(this).val(), null);
    });

    @if (old('barrage_id') !== null)
        loadBranchCanals(@json(old('barrage_id')), @json(old('minor_id', $minor->minor_id)));
    @endif
});
</script>
@endsection
