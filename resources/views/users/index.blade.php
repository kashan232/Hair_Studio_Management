@extends('layouts.main')

@section('css')
<style>
    :root {
        --salon-gold: #c6a34d;
        --salon-dark: #121212;
        --salon-sand: #f4efe6;
        --accent-green: #2ecc71;
        --accent-blue: #3498db;
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

    .user-table-card {
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

    .user-avatar {
        width: 44px;
        height: 44px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid var(--salon-gold);
    }

    .user-meta {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .user-name {
        font-weight: 600;
        color: var(--salon-dark);
        margin: 0;
        font-size: 0.9rem;
    }

    .user-designation {
        font-size: 0.75rem;
        color: #8c7e6c;
    }

    /* Branded Role Badges */
    .badge-role {
        font-size: 0.68rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        padding: 0.3rem 0.75rem;
        border-radius: 0px;
        display: inline-block;
    }

    .badge-role.super_admin {
        background: rgba(198, 163, 77, 0.12);
        color: var(--salon-gold);
        border: 1px solid var(--salon-gold);
    }

    .badge-role.admin {
        background: rgba(18, 18, 18, 0.08);
        color: var(--salon-dark);
        border: 1px solid var(--salon-dark);
    }

    .badge-role.receptionist {
        background: rgba(52, 152, 219, 0.1);
        color: var(--accent-blue);
        border: 1px solid var(--accent-blue);
    }

    .badge-role.hairstylist {
        background: rgba(46, 204, 113, 0.1);
        color: var(--accent-green);
        border: 1px solid var(--accent-green);
    }

    .badge-status {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        padding: 0.25rem 0.6rem;
        border-radius: 0px;
        display: inline-block;
    }

    .badge-status.active {
        background: rgba(46, 204, 113, 0.12);
        color: var(--accent-green);
    }

    .badge-status.inactive {
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
                    <h1 class="page-title">Users & Roles Management</h1>
                </div>
                <a href="{{ route('users.create') }}" class="btn-luxury-dark">
                    <i class="fe fe-plus"></i> Create New User
                </a>
            </div>

            <!-- Search & Filters -->
            <div class="search-filter-card">
                <form method="GET" action="{{ route('users.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control form-control-luxury" placeholder="Search by name, email, or designation..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="role" class="form-select form-control-luxury">
                            <option value="">-- All System Roles --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select form-control-luxury">
                            <option value="">-- All Statuses --</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn-luxury-dark w-100 h-100 justify-content-center">
                            <i class="fe fe-search"></i> Apply
                        </button>
                    </div>
                </form>
            </div>

            <!-- Users Table -->
            <div class="user-table-card">
                <div class="table-responsive">
                    <table id="users-table" class="table table-luxury mb-0">
                        <thead>
                            <tr>
                                <th>User Profile</th>
                                <th>System Role</th>
                                <th>Designation</th>
                                <th>Mobile Number</th>
                                <th>Joined Date</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $u)
                                <tr>
                                    <td>
                                        <div class="user-meta">
                                            <div style="width: 44px; height: 44px; border-radius: 50%; border: 2px solid var(--salon-gold); background: #faf8f5; display: flex; align-items: center; justify-content: center; color: var(--salon-gold); flex-shrink: 0;">
                                                <i class="fe fe-user" style="font-size: 1.2rem;"></i>
                                            </div>
                                            <div>
                                                <h4 class="user-name">{{ $u->name }}</h4>
                                                <span class="small text-muted">{{ $u->email }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($u->roleRelation && $u->roleRelation->slug === 'super-admin')
                                            <span class="badge-role super_admin">{{ $u->roleRelation->name }}</span>
                                        @elseif($u->roleRelation && $u->roleRelation->slug === 'admin')
                                            <span class="badge-role admin">{{ $u->roleRelation->name }}</span>
                                        @elseif($u->roleRelation && $u->roleRelation->slug === 'receptionist')
                                            <span class="badge-role receptionist">{{ $u->roleRelation->name }}</span>
                                        @elseif($u->roleRelation && $u->roleRelation->slug === 'hairstylist')
                                            <span class="badge-role hairstylist">{{ $u->roleRelation->name }}</span>
                                        @else
                                            <span class="badge-role admin">{{ $u->roleRelation->name ?? 'No Role' }}</span>
                                        @endif
                                    </td>
                                    <td class="fw-semibold text-dark">
                                        {{ $u->designation ?? 'User Profile' }}
                                    </td>
                                    <td class="text-muted">
                                        {{ $u->mobile ?? 'Not specified' }}
                                    </td>
                                    <td>
                                        {{ $u->joining_date ?? 'Not recorded' }}
                                    </td>
                                    <td>
                                        @if ($u->status == 1)
                                            <span class="badge-status active">Active</span>
                                        @else
                                            <span class="badge-status inactive">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="action-btn-group justify-content-end">
                                            <a href="{{ route('users.edit', $u->id) }}" class="action-btn" title="Edit Account">
                                                <i class="fe fe-edit-3"></i>
                                            </a>
                                            <a href="javascript:void(0)" class="action-btn delete-btn delete-user" data-id="{{ $u->id }}" data-name="{{ $u->name }}" title="Delete Account">
                                                <i class="fe fe-trash-2"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fe fe-user-minus display-6 d-block mb-3" style="color: #dcd3be;"></i>
                                        No registered accounts found matching the criteria.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('JScript')
<script>
    $(document).ready(function() {
        // Initialize dynamic DataTable
        $('#users-table').DataTable({
            "order": [],
            "pageLength": 10,
            "language": {
                "search": "",
                "searchPlaceholder": "Instant Search...",
                "lengthMenu": "Show _MENU_ accounts",
                "paginate": {
                    "next": '<i class="fe fe-chevron-right"></i>',
                    "previous": '<i class="fe fe-chevron-left"></i>'
                }
            },
            "drawCallback": function() {
                // Apply luxury styling to generated DataTable elements
                $('.dataTables_filter input').addClass('form-control form-control-luxury d-inline-block').css({
                    'width': '250px',
                    'margin-bottom': '1rem'
                });
                $('.dataTables_length select').addClass('form-select form-control-luxury d-inline-block').css({
                    'width': 'auto',
                    'padding': '0.3rem 1.5rem',
                    'height': 'auto'
                });
                $('.paginate_button').addClass('btn btn-sm btn-luxury-light mx-1').css('border-radius', '0');
            }
        });

        $(document).on('click', '.delete-user', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            const name = $(this).data('name');
            const row = $(this).closest('tr');

            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to delete user ${name}. This action is irreversible.`,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#121212',
                cancelButtonColor: '#eae2d5',
                confirmButtonText: 'Yes, Delete User',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.value || result.isConfirmed) {
                    $.ajax({
                        url: `{{ url('/users/delete') }}/${id}`,
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        success: function(response) {
                            console.log('Delete response:', response);
                            if (response.success) {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: response.success,
                                    type: 'success',
                                    confirmButtonColor: '#121212'
                                });
                                row.fadeOut(500, function() {
                                    $(this).remove();
                                });
                            } else if (response.error) {
                                Swal.fire('Action Denied', response.error, 'error');
                            } else {
                                Swal.fire('Warning', 'Unexpected response format.', 'warning');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Delete error:', xhr.responseText);
                            let errorMsg = 'An error occurred while deleting user.';
                            if (xhr.status === 419) errorMsg = 'Session expired. Please refresh the page.';
                            else if (xhr.responseJSON && xhr.responseJSON.message) errorMsg = xhr.responseJSON.message;
                            
                            Swal.fire('Error!', errorMsg, 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
