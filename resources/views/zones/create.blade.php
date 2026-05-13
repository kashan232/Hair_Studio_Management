@extends('layouts.main')
@section('css')
@endsection

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1 class="page-title">@if(!isset($zone)) Create Zone @else Update Zone @endif</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('zones.index')}}">Zones</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@if(!isset($zone)) Create @else Update @endif</li>
                    </ol>
                </div>
            </div>
            <!-- PAGE HEADER END -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Zone Details</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ isset($zone) ? route('zones.update', $zone->id) : route('zones.store') }}" class="ajaxForm row">
                                @csrf
                                @if(isset($zone)) @method('PUT') @endif
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Region / Zone Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $zone->name ?? '' }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Code</label>
                                    <input type="text" class="form-control" name="code" value="{{ $zone->code ?? '' }}">
                                </div>

                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-primary">Save Zone</button>
                                    <a href="{{ route('zones.index') }}" class="btn btn-light">Cancel</a>
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
    // Other scripts if needed
});
</script>
@endsection
