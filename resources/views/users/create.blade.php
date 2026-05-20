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
                <h1 class="page-title">Create User & Assign Role</h1>
            </div>

            <!-- Form Container -->
            <form action="{{ route('users.store') }}" method="POST" class="ajaxForm">
                @csrf
                
                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-card">
                            
                            <h3 class="form-section-title">Account Profiles Details</h3>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-luxury">
                                        <label for="name">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control form-control-luxury" placeholder="e.g. Zain Ahmed" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-luxury">
                                        <label for="email">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" name="email" id="email" class="form-control form-control-luxury" placeholder="e.g. zain@eladeuk.com" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-luxury">
                                        <label for="password">Account Password <span class="text-danger">*</span></label>
                                        <input type="password" name="password" id="password" class="form-control form-control-luxury" placeholder="Enter security password" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-luxury">
                                        <label for="mobile">Mobile Number</label>
                                        <input type="text" name="mobile" id="mobile" class="form-control form-control-luxury" placeholder="e.g. +44 7911 987654">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-luxury">
                                        <label for="role_id">Assign System Role <span class="text-danger">*</span></label>
                                        <select name="role_id" id="role_id" class="form-select form-control-luxury" required>
                                            <option value="">-- Choose Role --</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-luxury">
                                        <label for="designation">Designation / Title</label>
                                        <input type="text" name="designation" id="designation" class="form-control form-control-luxury" placeholder="e.g. General Manager, Reception Coordinator">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-luxury">
                                        <label for="cnic">National ID / License Number</label>
                                        <input type="text" name="cnic" id="cnic" class="form-control form-control-luxury" placeholder="e.g. ID-456-GENERAL">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-luxury">
                                        <label for="status">Account Status <span class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-select form-control-luxury" required>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-top border-light d-flex gap-2">
                                <button type="submit" class="btn-luxury-dark">
                                    Create User Account
                                </button>
                                <a href="{{ route('users.index') }}" class="btn-luxury-light">
                                    Cancel & Return
                                </a>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-card text-center d-flex flex-column justify-content-between" style="min-height: 240px;">
                            <div>
                                <h3 class="form-section-title">Role Guideline</h3>
                                <p class="text-muted small text-start mb-0" style="line-height: 1.6;">
                                    <strong>Super Admin:</strong> Full administrative ownership, configured pricing & system. <br><br>
                                    <strong>Admin:</strong> Day-to-day operations, chair reservations, and reports. <br><br>
                                    <strong>Receptionist:</strong> Calendar assistants (No financial view access). <br><br>
                                    <strong>Hairstylist:</strong> Self-service chair bookings and profile showcases.
                                </p>
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
    $(document).ready(function() {
        // AJAX Form Submission
        $('.ajaxForm').submit(function(e) {
            e.preventDefault();
            const btn = $(this).find('button[type="submit"]');
            const originalText = btn.html();
            btn.prop('disabled', true).html('CREATING... <span class="spinner-border spinner-border-sm ms-2"></span>');
            
            var url = $(this).attr('action');
            var formData = new FormData(this);
            
            $.ajax({
                url: url,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                complete: function () {
                    btn.prop('disabled', false).html(originalText);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    ajaxErrorHandling(jqXHR, errorThrown);
                },
                success: function (data) {
                    if (data['redirect'] !== undefined) {
                        toast(data['success'], "Success!", 'success', 1200);
                        setTimeout(function () {
                            window.location = data['redirect'];
                        }, 600);
                    } else if (data['error'] !== undefined) {
                        toast(data['error'], "Error!", 'error');
                    } else if (data['errors'] !== undefined) {
                        multiple_errors_ajax_handling(data['errors']);
                    }
                }
            });
        });
    });
</script>
@endsection
