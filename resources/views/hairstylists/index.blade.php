@extends('layouts.main')

@section('css')
<style>
    :root {
        --salon-gold: #c6a34d;
        --salon-dark: #121212;
        --salon-sand: #f4efe6;
        --accent-green: #2ecc71;
        --accent-orange: #e67e22;
        --accent-red: #e74c3c;
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
        font-size: 0.75rem;
        padding: 0.7rem 1.4rem;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: none !important;
    }

    .btn-luxury-dark:hover {
        background: var(--salon-gold) !important;
        border-color: var(--salon-gold) !important;
        color: #fff !important;
        transform: translateY(-2px);
    }

    .search-filter-card {
        background: #fff;
        border: 1px solid #eae2d5;
        border-radius: 0px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .form-control-luxury {
        border-radius: 0px !important;
        border: 1px solid #dcd3be !important;
        font-size: 0.85rem;
        height: 44px;
        background: #faf8f5;
        transition: all 0.3s;
    }

    .form-control-luxury:focus {
        border-color: var(--salon-gold) !important;
        background: #fff;
        box-shadow: none !important;
    }

    .stylist-table-card {
        background: #fff;
        border: 1px solid #eae2d5;
        border-radius: 0px;
        overflow: hidden;
    }

    .table-luxury th {
        font-weight: 700 !important;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.72rem;
        color: #8c7e6c !important;
        background: #faf8f5 !important;
        border-bottom: 2px solid #eae2d5 !important;
        padding: 1rem 1.25rem !important;
    }

    .table-luxury td {
        font-size: 0.85rem;
        padding: 1rem 1.25rem !important;
        vertical-align: middle;
        border-bottom: 1px solid #faf8f5;
    }

    .table-luxury tr:hover td {
        background: #fffdfa;
    }

    .stylist-avatar {
        width: 46px;
        height: 46px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid var(--salon-gold);
    }

    .stylist-meta {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .stylist-name {
        font-weight: 600;
        color: var(--salon-dark);
        margin: 0;
        font-size: 0.9rem;
    }

    .stylist-role {
        font-size: 0.75rem;
        color: #8c7e6c;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .specialization-tag {
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 0.25rem 0.6rem;
        border-radius: 2px;
        background: #f4efe6;
        color: #6d5b47;
        display: inline-block;
    }

    .instagram-link {
        font-size: 0.8rem;
        color: var(--salon-gold);
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        transition: color 0.2s;
    }

    .instagram-link:hover {
        color: var(--salon-dark);
    }

    .badge-status {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        padding: 0.3rem 0.7rem;
        border-radius: 0px;
        display: inline-block;
    }

    .badge-status.active {
        background: rgba(46, 204, 113, 0.12);
        color: var(--accent-green);
    }

    .badge-status.break {
        background: rgba(230, 126, 34, 0.12);
        color: var(--accent-orange);
    }

    .badge-status.suspended {
        background: rgba(231, 76, 60, 0.12);
        color: var(--accent-red);
    }

    .action-btn-group {
        display: flex;
        gap: 0.5rem;
    }

    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 0px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #dcd3be;
        background: #fff;
        color: #8c7e6c;
        transition: all 0.2s;
        text-decoration: none;
    }

    .action-btn:hover {
        border-color: var(--salon-dark);
        color: var(--salon-dark);
        background: #faf8f5;
    }

    .action-btn.delete-btn:hover {
        border-color: var(--accent-red);
        color: var(--accent-red);
        background: rgba(231, 76, 60, 0.05);
    }
</style>
@endsection

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid py-4">

            <!-- Header Row -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
                <div>
                    <p class="mb-1 text-muted text-uppercase fw-semibold" style="letter-spacing: 1.5px; font-size: 0.7rem;">Super Admin Panel</p>
                    <h1 class="page-title">Hairstylist Management</h1>
                </div>
                <a href="{{ route('hairstylists.create') }}" class="btn-luxury-dark">
                    <i class="fe fe-plus"></i> Add New Stylist
                </a>
            </div>

            <!-- Search & Filters -->
            <div class="search-filter-card">
                <form method="GET" action="{{ route('hairstylists.index') }}" class="row g-3">
                    <div class="col-md-5">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control form-control-luxury" placeholder="Search by name, email, or specialization..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select name="status" class="form-select form-control-luxury">
                            <option value="">-- All Statuses --</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                            <option value="2" {{ request('status') === '2' ? 'selected' : '' }}>On Break</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Suspended</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn-luxury-dark w-100 h-100 justify-content-center">
                            <i class="fe fe-search"></i> Apply Filters
                        </button>
                    </div>
                </form>
            </div>

            <!-- Roster Table -->
            <div class="stylist-table-card">
                <div class="table-responsive">
                    <table class="table table-luxury mb-0">
                        <thead>
                            <tr>
                                <th>Hairstylist Profile</th>
                                <th>Contact Information</th>
                                <th>Specialization</th>
                                <th>Experience</th>
                                <th>Instagram</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($stylists as $stylist)
                                <tr>
                                    <td>
                                        <div class="stylist-meta">
                                            <img src="{{ filter_var($stylist->avatar, FILTER_VALIDATE_URL) ? $stylist->avatar : asset($stylist->avatar) }}" alt="{{ $stylist->name }}" class="stylist-avatar">
                                            <div>
                                                <h4 class="stylist-name">{{ $stylist->name }}</h4>
                                                <p class="stylist-role mb-0">{{ $stylist->designation ?? 'Artist' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $stylist->email }}</div>
                                        <div class="small text-muted">{{ $stylist->mobile ?? 'No phone' }}</div>
                                    </td>
                                    <td>
                                        <span class="specialization-tag">
                                            {{ $stylist->specialization ?? 'General Stylist' }}
                                        </span>
                                    </td>
                                    <td class="fw-semibold text-dark">
                                        {{ $stylist->experience_years ?? '0' }} Years
                                    </td>
                                    <td>
                                        @if($stylist->instagram_handle)
                                            <a href="https://instagram.com/{{ ltrim($stylist->instagram_handle, '@') }}" target="_blank" class="instagram-link">
                                                <i class="fe fe-instagram"></i> @<span>{{ ltrim($stylist->instagram_handle, '@') }}</span>
                                            </a>
                                        @else
                                            <span class="text-muted small">Not provided</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($stylist->status == 1)
                                            <span class="badge-status active">Active</span>
                                        @elseif ($stylist->status == 2)
                                            <span class="badge-status break">On Break</span>
                                        @else
                                            <span class="badge-status suspended">Suspended</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="action-btn-group justify-content-end">
                                            <a href="{{ route('hairstylists.edit', $stylist->id) }}" class="action-btn" title="Edit Profile">
                                                <i class="fe fe-edit-3"></i>
                                            </a>
                                            <a href="javascript:void(0)" class="action-btn delete-btn delete-stylist" data-id="{{ $stylist->id }}" data-name="{{ $stylist->name }}" title="Delete Account">
                                                <i class="fe fe-trash-2"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fe fe-users display-6 d-block mb-3" style="color: #dcd3be;"></i>
                                        No registered hairstylists found matching the filters.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($stylists->hasPages())
                    <div class="p-3 border-top border-light d-flex justify-content-end">
                        {{ $stylists->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $(document).on('click', '.delete-stylist', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            const name = $(this).data('name');
            const row = $(this).closest('tr');

            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to delete ${name}'s hairstylist profile and credentials.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#121212',
                cancelButtonColor: '#eae2d5',
                confirmButtonText: 'Yes, Delete Account',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'btn-luxury-dark',
                    cancelButton: 'btn-light'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ url('/hairstylists/delete') }}/${id}`,
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: response.success,
                                    icon: 'success',
                                    confirmButtonColor: '#121212'
                                });
                                row.fadeOut(500, function() {
                                    $(this).remove();
                                });
                            } else if (response.error) {
                                Swal.fire('Error!', response.error, 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error!', 'Something went wrong while processing deletion.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
