@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">Edit distributary</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('distributaries.index') }}">Distributaries</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0">{{ $distributary->name }}</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('distributaries.update', $distributary) }}" method="post" id="distributary-form">
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
                                    <label class="form-label" for="distributary_id">Distributary</label>
                                    <select name="distributary_id" id="distributary_id" class="form-select @error('distributary_id') is-invalid @enderror" required>
                                        <option value="">Select branch canal</option>
                                        @foreach ($distributaries as $distributary)
                                            <option value="{{ $distributary->id }}" @selected(old('distributary_id', $distributary->distributary_id) == $distributary->id)>{{ $distributary->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Changing barrage reloads distributaries via AJAX.</small>
                                    @error('distributary_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="name">Distributary name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $distributary->name) }}" class="form-control @error('name') is-invalid @enderror" required maxlength="255">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('distributaries.index') }}" class="btn btn-secondary">Cancel</a>
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
        fillSelect($('#distributary_id'), [], 'Select branch canal');
        if (!barrageId) {
            return;
        }
        $.getJSON(baseUrl + '/cascade/distributaries/' + barrageId)
            .done(function (data) {
                fillSelect($('#distributary_id'), data, 'Select branch canal');
                if (selectedBranchCanalId) {
                    $('#distributary_id').val(String(selectedBranchCanalId));
                }
            });
    }

    $('#barrage_id').on('change', function () {
        loadBranchCanals($(this).val(), null);
    });

    @if (old('barrage_id') !== null)
        loadBranchCanals(@json(old('barrage_id')), @json(old('distributary_id', $distributary->distributary_id)));
    @endif
});
</script>
@endsection
