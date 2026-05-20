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

    /* Unique Boutique Input Styling */
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

    textarea.form-control-luxury {
        height: auto !important;
        min-height: 120px;
        resize: vertical;
    }

    /* Avatar Upload Styling */
    .avatar-upload-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border: 2px dashed #dcd3be;
        background: #faf8f5;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        height: 100%;
        min-height: 240px;
    }

    .avatar-upload-box:hover {
        border-color: var(--salon-gold);
        background: #fff;
    }

    .avatar-preview-img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid var(--salon-gold);
        margin-bottom: 1rem;
        display: none;
    }

    .avatar-upload-icon {
        font-size: 2.5rem;
        color: #b8ac95;
        margin-bottom: 0.75rem;
    }

    .avatar-upload-text {
        font-size: 0.8rem;
        color: #8c7e6c;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
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
                <h1 class="page-title">Register Hairstylist</h1>
            </div>

            <!-- Form Container -->
            <form action="{{ route('hairstylists.store') }}" method="POST" class="ajaxForm" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-card">
                            
                            <h3 class="form-section-title">Credentials & Personal Info</h3>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-luxury">
                                        <label for="name">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control form-control-luxury" placeholder="e.g. Aisha Khan" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-luxury">
                                        <label for="email">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" name="email" id="email" class="form-control form-control-luxury" placeholder="e.g. aisha@eladeuk.com" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-luxury">
                                        <label for="password">Portal Password <span class="text-danger">*</span></label>
                                        <input type="password" name="password" id="password" class="form-control form-control-luxury" placeholder="Enter secure login password" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-luxury">
                                        <label for="mobile">Mobile Number</label>
                                        <input type="text" name="mobile" id="mobile" class="form-control form-control-luxury" placeholder="e.g. +44 7911 123456">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group-luxury">
                                        <label for="cnic">National ID / License Number</label>
                                        <input type="text" name="cnic" id="cnic" class="form-control form-control-luxury" placeholder="e.g. GB-12345-ARTIST">
                                    </div>
                                </div>
                            </div>

                            <h3 class="form-section-title mt-4">Professional Portfolio</h3>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-luxury">
                                        <label for="specialization">Artist Specialization</label>
                                        <select name="specialization" id="specialization" class="form-select form-control-luxury">
                                            <option value="">-- Select Specialty --</option>
                                            <option value="Master Stylist">Master Stylist</option>
                                            <option value="Hair Color Specialist">Hair Color Specialist</option>
                                            <option value="Hair Extension Artist">Hair Extension Artist</option>
                                            <option value="Treatment Expert">Treatment Expert</option>
                                            <option value="Barbering Professional">Barbering Professional</option>
                                            <option value="Bridal Hair Specialist">Bridal Hair Specialist</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-luxury">
                                        <label for="experience_years">Experience (Years)</label>
                                        <input type="number" name="experience_years" id="experience_years" min="0" max="50" class="form-control form-control-luxury" placeholder="e.g. 5">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-luxury">
                                        <label for="instagram_handle">Instagram Username</label>
                                        <div class="input-group">
                                            <span class="input-group-text border-end-0" style="border-radius: 0; border: 1px solid #dcd3be; background: #faf8f5; color: #8c7e6c; font-weight: 600;">@</span>
                                            <input type="text" name="instagram_handle" id="instagram_handle" class="form-control form-control-luxury border-start-0" placeholder="eladestudio">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-luxury">
                                        <label for="status">Account Status <span class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-select form-control-luxury" required>
                                            <option value="1">Active</option>
                                            <option value="2">On Break</option>
                                            <option value="0">Suspended</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group-luxury">
                                        <label for="bio">Hairstylist Bio / Details</label>
                                        <textarea name="bio" id="bio" class="form-control form-control-luxury" placeholder="Briefly describe the stylist's professional background, special salon techniques, and portfolio notes..."></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-4">
                        <!-- Photo Upload Card -->
                        <div class="form-card text-center d-flex flex-column justify-content-between h-100" style="min-height: 380px;">
                            <div>
                                <h3 class="form-section-title">Profile Photo</h3>
                                <p class="text-muted small mb-4">Upload a high-resolution headshot for their public studio profile.</p>
                            </div>
                            
                            <div class="form-group mb-0">
                                <input type="file" name="avatar" id="avatar" class="d-none" accept="image/*">
                                <div class="avatar-upload-box" onclick="document.getElementById('avatar').click()">
                                    <img id="previewImg" src="#" alt="Preview" class="avatar-preview-img">
                                    <div id="uploadContent">
                                        <i class="fe fe-image avatar-upload-icon"></i>
                                        <div class="avatar-upload-text">Choose Portrait Image</div>
                                        <small class="text-muted mt-2 d-block">Max File Size: 2MB (JPG, PNG)</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-top border-light d-flex flex-column gap-2">
                                <button type="submit" class="btn-luxury-dark w-100">
                                    Register Artist Profile
                                </button>
                                <a href="{{ route('hairstylists.index') }}" class="btn-luxury-light w-100">
                                    Return to Roster
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
    $(document).ready(function() {
        // Image preview logic
        $('#avatar').change(function() {
            const file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    $('#previewImg').attr('src', event.target.result).show();
                    $('#uploadContent').hide();
                }
                reader.readAsDataURL(file);
            }
        });

        // AJAX Form Submission
        $('.ajaxForm').submit(function(e) {
            e.preventDefault();
            const btn = $(this).find('button[type="submit"]');
            const originalText = btn.html();
            btn.prop('disabled', true).html('REGISTERING... <span class="spinner-border spinner-border-sm ms-2"></span>');
            
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
