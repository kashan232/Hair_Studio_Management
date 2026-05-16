@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">Create Watercourse</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('watercourses.index') }}">Watercourses</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 col-lg-7">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0">New Watercourse</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('watercourses.store') }}" method="post" id="watercourse-form">
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
                                    @error('main_canal_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="sub_canal_id">Sub canal</label>
                                    <select name="sub_canal_id" id="sub_canal_id" class="form-select @error('sub_canal_id') is-invalid @enderror" required>
                                        <option value="">Select sub canal</option>
                                    </select>
                                    @error('sub_canal_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="branch_canal_id">Branch canal</label>
                                    <select name="branch_canal_id" id="branch_canal_id" class="form-select @error('branch_canal_id') is-invalid @enderror" required>
                                        <option value="">Select branch canal</option>
                                    </select>
                                    @error('branch_canal_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="distributary_id">Distributary</label>
                                    <select name="distributary_id" id="distributary_id" class="form-select @error('distributary_id') is-invalid @enderror" required>
                                        <option value="">Select distributary</option>
                                    </select>
                                    @error('distributary_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="minor_id">Minor</label>
                                    <select name="minor_id" id="minor_id" class="form-select @error('minor_id') is-invalid @enderror" required>
                                        <option value="">Select minor</option>
                                    </select>
                                    @error('minor_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <small id="existing-wc-hint" class="text-muted"></small>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="name">WC No / name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required maxlength="255">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
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

    function fillSelect($el, items, placeholder) {
        $el.empty();
        $el.append($('<option></option>').val('').text(placeholder));
        $.each(items, function (_, row) {
            $el.append($('<option></option>').val(row.id).text(row.name));
        });
    }

    });

    @if (old('barrage_id'))
        $.getJSON(baseUrl + '/cascade/main-canals/' + @json(old('barrage_id')))
            .done(function (data) {
                fillSelect($('#main_canal_id'), data, 'Select main canal');
                var MainCanalVal = @json(old('main_canal_id'));
                if (MainCanalVal) {
                    $('#main_canal_id').val(String(MainCanalVal));
                    $.getJSON(baseUrl + '/cascade/sub-canals/' + MainCanalVal)
                        .done(function (data2) {
                            fillSelect($('#sub_canal_id'), data2, 'Select sub canal');
                            var SubCanalVal = @json(old('sub_canal_id'));
                            if (SubCanalVal) {
                                $('#sub_canal_id').val(String(SubCanalVal));
                                $.getJSON(baseUrl + '/cascade/watercourses/' + SubCanalVal, function (list) {
                                    if (!list.length) {
                                        $('#existing-wc-hint').text('No Existing WCs under this SubCanal yet.');
                                        return;
                                    }
                                    var names = list.map(function (r) { return r.name; }).join(', ');
                                    $('#existing-wc-hint').text('Existing WCs (' + list.length + '): ' + names);
                                });
                            }
                        });
                }
            });
    @endif
});
</script>
@endsection
