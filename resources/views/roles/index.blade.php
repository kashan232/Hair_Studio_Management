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

    .role-card-grid {
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
        padding: 1.2rem 1.25rem !important;
        vertical-align: middle;
        border-bottom: 1px solid #faf8f5;
    }

    .table-luxury tr:hover td {
        background: #fffdfa;
    }

    .role-badge {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        padding: 0.3rem 0.75rem;
        border-radius: 0px;
        display: inline-block;
        background: #faf8f5;
        border: 1px solid #eae2d5;
        color: var(--salon-dark);
    }

    .role-badge.super-admin {
        background: rgba(198, 163, 77, 0.12);
        color: var(--salon-gold);
        border: 1px solid var(--salon-gold);
    }

    .permission-pill {
        font-size: 0.68rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 0.2rem 0.5rem;
        background: #faf8f5;
        border: 1px solid #eae2d5;
        color: #8c7e6c;
        border-radius: 2px;
        display: inline-block;
        margin: 2px;
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
        border-color: #e74c3c;
        color: #e74c3c;
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
                    <h1 class="page-title">Roles & Access Privileges</h1>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('roles.create') }}" class="btn-luxury-dark">
                        <i class="fe fe-plus"></i> Create New Role
                    </a>
                </div>
            </div>

            <!-- Roles Table -->
            <div class="role-card-grid">
                <div class="table-responsive">
                    <table id="roles-table" class="table table-luxury mb-0">
                        <thead>
                            <tr>
                                <th>Role Name</th>
                                <th>Assigned Users</th>
                                <th>Active Access Permissions</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($roles as $role)
                                <tr>
                                    <td>
                                        <span class="role-badge {{ $role->slug }}">
                                            {{ $role->name }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $role->users_count }} Accounts</div>
                                        <small class="text-muted">Currently active</small>
                                    </td>
                                    <td style="max-width: 450px;">
                                        @forelse($role->permissions as $p)
                                            <span class="permission-pill">{{ $p->name }}</span>
                                        @empty
                                            <span class="text-muted small">No permissions associated.</span>
                                        @endforelse
                                    </td>
                                    <td class="text-end">
                                        <div class="action-btn-group justify-content-end">
                                            <a href="{{ route('roles.assign', $role->id) }}" class="action-btn" title="Assign Permissions" style="border-color: var(--salon-gold); color: var(--salon-gold);">
                                                <i class="fe fe-lock"></i>
                                            </a>
                                            <a href="{{ route('roles.edit', $role->id) }}" class="action-btn" title="Edit Role Name">
                                                <i class="fe fe-edit-3"></i>
                                            </a>
                                            @if($role->slug !== 'super-admin')
                                                <a href="javascript:void(0)" class="action-btn delete-btn delete-role" data-id="{{ $role->id }}" data-name="{{ $role->name }}" title="Delete Role">
                                                    <i class="fe fe-trash-2"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="fe fe-shield-off display-6 d-block mb-3" style="color: #dcd3be;"></i>
                                        No custom roles registered in the database.
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
        $('#roles-table').DataTable({
            "order": [],
            "pageLength": 10,
            "language": {
                "search": "",
                "searchPlaceholder": "Instant Search...",
                "lengthMenu": "Show _MENU_ roles",
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

        $(document).on('click', '.delete-role', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            const name = $(this).data('name');
            const row = $(this).closest('tr');

            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to delete the role "${name}". Users assigned to this role will lose their custom permissions.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#121212',
                cancelButtonColor: '#eae2d5',
                confirmButtonText: 'Yes, Delete Role',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ url('/roles/delete') }}/${id}`,
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
                                Swal.fire('Forbidden!', response.error, 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error!', 'An error occurred while deleting role.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
