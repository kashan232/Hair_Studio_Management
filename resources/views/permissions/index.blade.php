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

    .permission-table-card {
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

    .permission-badge {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        padding: 0.3rem 0.7rem;
        border-radius: 0px;
        display: inline-block;
        background: rgba(198, 163, 77, 0.1);
        color: var(--salon-gold);
        border: 1px solid var(--salon-gold);
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
                    <h1 class="page-title">Granular Permissions List</h1>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('roles.index') }}" class="btn-luxury-dark" style="background: transparent !important; color: var(--salon-dark) !important; border-color: #dcd3be !important;">
                        <i class="fe fe-users"></i> Return to Roles
                    </a>
                </div>
            </div>

            <!-- Permissions Table -->
            <div class="permission-table-card">
                <div class="table-responsive">
                    <table id="permissions-table" class="table table-luxury mb-0">
                        <thead>
                            <tr>
                                <th>Permission Label</th>
                                <th>Slug Identifier</th>
                                <th>Description / Purpose</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($permissions as $p)
                                <tr>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $p->name }}</div>
                                    </td>
                                    <td>
                                        <span class="permission-badge">
                                            {{ $p->slug }}
                                        </span>
                                    </td>
                                    <td class="text-muted" style="max-width: 400px;">
                                        {{ $p->description ?? 'No explanation note provided.' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="fe fe-shield-off display-6 d-block mb-3" style="color: #dcd3be;"></i>
                                        No permissions registered in the system.
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
        $('#permissions-table').DataTable({
            "order": [],
            "pageLength": 10,
            "language": {
                "search": "",
                "searchPlaceholder": "Instant Search...",
                "lengthMenu": "Show _MENU_ permissions",
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
    });
</script>
@endsection
