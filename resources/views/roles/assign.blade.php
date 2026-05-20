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

    .permission-checkbox-card {
        border: 1px solid #eae2d5;
        background: #faf8f5;
        padding: 1.25rem;
        margin-bottom: 1rem;
        transition: all 0.2s;
        cursor: pointer;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }

    .permission-checkbox-card:hover {
        border-color: var(--salon-gold);
        background: #fff;
    }

    .permission-checkbox-card input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: var(--salon-gold);
        cursor: pointer;
        margin-top: 0.15rem;
    }

    .permission-title {
        font-weight: 700;
        color: var(--salon-dark);
        font-size: 0.82rem;
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .permission-desc {
        color: #8c7e6c;
        font-size: 0.76rem;
        line-height: 1.4;
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
                <h1 class="page-title">Assign Access Permissions</h1>
            </div>

            <!-- Form Container -->
            <form action="{{ route('roles.assign.save', $role->id) }}" method="POST" class="ajaxForm">
                @csrf
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-card">
                            
                            <h3 class="form-section-title">Configure Permissions for: {{ $role->name }}</h3>
                            <p class="text-muted small mb-4">Toggle checkboxes in the grid below to assign specific privilege gates to this role profile.</p>

                            <div class="row">
                                @forelse($permissions as $p)
                                    <div class="col-md-6 col-lg-4">
                                        <div class="permission-checkbox-card" onclick="toggleCheckbox(this)">
                                            <input type="checkbox" name="permissions[]" value="{{ $p->id }}" {{ in_array($p->id, $assignedPermissions) ? 'checked' : '' }} onclick="event.stopPropagation();">
                                            <div>
                                                <div class="permission-title">{{ $p->name }}</div>
                                                <div class="permission-desc">{{ $p->description ?? 'No description.' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12 py-3 text-center text-muted">
                                        No dynamic permissions configured in the roster.
                                    </div>
                                @endforelse
                            </div>

                            <div class="mt-4 pt-3 border-top border-light d-flex gap-2">
                                <button type="submit" class="btn-luxury-dark">
                                    Update Assigned Permissions
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

@section('js')
<script>
    function toggleCheckbox(card) {
        const checkbox = card.querySelector('input[type="checkbox"]');
        checkbox.checked = !checkbox.checked;
    }
</script>
@endsection
