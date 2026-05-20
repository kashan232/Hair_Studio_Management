@extends('layouts.main')

@section('css')
<style>
    :root {
        --salon-gold: #c6a34d;
        --salon-dark: #121212;
        --salon-sand: #f4efe6;
    }

    .page-title {
        font-family: 'Playfair Display', serif;
        font-weight: 400;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--salon-dark);
        margin: 0;
    }

    .btn-luxury-dark {
        background: var(--salon-dark) !important;
        color: #fff !important;
        border: 1px solid var(--salon-dark) !important;
        border-radius: 0px !important;
        font-weight: 600;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        font-size: 0.78rem;
        padding: 0.8rem 1.6rem;
        transition: all 0.3s;
        box-shadow: none !important;
        cursor: pointer;
    }

    .btn-luxury-dark:hover {
        background: var(--salon-gold) !important;
        border-color: var(--salon-gold) !important;
        color: #fff !important;
        transform: translateY(-2px);
    }

    .btn-luxury-light {
        background: #fff !important;
        color: #8c7e6c !important;
        border: 1px solid #dcd3be !important;
        border-radius: 0px !important;
        font-weight: 600;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        font-size: 0.78rem;
        padding: 0.8rem 1.6rem;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-luxury-light:hover {
        border-color: var(--salon-dark) !important;
        color: var(--salon-dark) !important;
    }

    .form-card {
        background: #fff;
        border: 1px solid #eae2d5;
        border-radius: 0px;
        padding: 2.5rem;
        margin-bottom: 2rem;
    }

    .form-section-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.25rem;
        color: var(--salon-dark);
        border-bottom: 1px solid #f4efe6;
        padding-bottom: 0.75rem;
        margin-bottom: 2rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }

    .form-group-luxury {
        position: relative;
        margin-bottom: 2rem;
    }

    .form-group-luxury label {
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #8c7e6c;
        font-weight: 700;
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control-luxury {
        width: 100%;
        border-radius: 0px !important;
        border: 1px solid #dcd3be !important;
        background: #faf8f5 !important;
        font-size: 0.88rem;
        height: 48px;
        padding: 0.5rem 1rem;
        color: var(--salon-dark);
        transition: all 0.3s;
    }

    .form-control-luxury:focus {
        border-color: var(--salon-gold) !important;
        background: #fff !important;
        box-shadow: none !important;
    }
</style>
@endsection

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid py-4">

            <!-- Header Row -->
            <div class="mb-4">
                <p class="mb-1 text-muted text-uppercase fw-semibold" style="letter-spacing: 1.5px; font-size: 0.7rem;">Super Admin Panel</p>
                <h1 class="page-title">Modify Custom Role Name</h1>
            </div>

            <!-- Form Container -->
            <form action="{{ route('roles.update', $role->id) }}" method="POST" class="ajaxForm">
                @csrf
                
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-card">
                            
                            <h3 class="form-section-title">Role Profile Details</h3>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group-luxury">
                                        <label for="name">Role Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control form-control-luxury" placeholder="e.g. Booking Coordinator, Junior Stylist" value="{{ $role->name }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-top border-light d-flex gap-2">
                                <button type="submit" class="btn-luxury-dark">
                                    Update Role Name
                                </button>
                                <a href="{{ route('roles.index') }}" class="btn-luxury-light">
                                    Cancel & Return
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
