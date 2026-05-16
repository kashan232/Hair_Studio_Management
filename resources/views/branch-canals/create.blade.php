@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">Create branchCanal</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('branch-canals.index') }}">Branch canals</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0">New branchCanal</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('branch-canals.store') }}" method="post" id="branch-canal-form">
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
                                    <label class="form-label" for="branch_canal_id">Branch canal</label>
                                    <select name="branch_canal_id" id="branch_canal_id" class="form-select @error('branch_canal_id') is-invalid @enderror" required>
                                        <option value="">Select sub canal</option>
                                    </select>
                                    <small class="text-muted">Branch canals load when you choose a barrage.</small>
                                    @error('branch_canal_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="name">Branch canal name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required maxlength="255">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="{{ route('branch-canals.index') }}" class="btn btn-secondary">Cancel</a>
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

    function loadSubCanals(barrageId, selectedSubCanalId) {
        fillSelect($('#branch_canal_id'), [], 'Select sub canal');
        if (!barrageId) {
            return;
        }
        $.getJSON(baseUrl + '/cascade/branch-canals/' + barrageId)
            .done(function (data) {
                fillSelect($('#branch_canal_id'), data, 'Select sub canal');
                if (selectedSubCanalId) {
                    $('#branch_canal_id').val(String(selectedSubCanalId));
                }
            });
    }

    $('#barrage_id').on('change', function () {
        loadSubCanals($(this).val(), null);
    });

    @if (old('barrage_id'))
        loadSubCanals(@json(old('barrage_id')), @json(old('branch_canal_id')));
    @endif
});
</script>
@endsection
