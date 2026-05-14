@extends('layouts.main')
@section('css')
@endsection

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1 class="page-title">@if(!isset($unit)) Create Unit @else Update Unit @endif</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('units.index')}}">Units</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@if(!isset($unit)) Create @else Update @endif</li>
                    </ol>
                </div>
            </div>
            <!-- PAGE HEADER END -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Unit Details</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ isset($unit) ? route('units.update', $unit->id) : route('units.store') }}" class="ajaxForm row">
                                @csrf
                                @if(isset($unit)) @method('PUT') @endif
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Unit Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $unit->name ?? '' }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Code</label>
                                    <input type="text" class="form-control" name="code" value="{{ $unit->code ?? '' }}">
                                </div>

                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-primary">Save Unit</button>
                                    <a href="{{ route('units.index') }}" class="btn btn-light">Cancel</a>
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
    //
});
</script>
@endsection
