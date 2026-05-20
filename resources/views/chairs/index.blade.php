@extends('layouts.main')

@section('css')
<style>
    :root {
        --salon-gold: #c6a34d;
        --salon-dark: #121212;
        --salon-sand: #f4efe6;
        --accent-green: #2e7d32;
        --accent-gold-dark: #b8860b;
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

    .chair-table-card {
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

    /* Branded Availability Badges */
    .badge-status {
        font-size: 0.68rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        padding: 0.35rem 0.8rem;
        border-radius: 0px;
        display: inline-block;
    }

    .badge-status.available {
        background: rgba(46, 125, 50, 0.1);
        color: var(--accent-green);
        border: 1px solid var(--accent-green);
    }

    .badge-status.booked {
        background: rgba(198, 163, 77, 0.12);
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

    .btn-luxury-light {
        background: #fff !important;
        color: #8c7e6c !important;
        border: 1px solid #dcd3be !important;
        border-radius: 0px !important;
        font-weight: 600;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        font-size: 0.75rem;
        padding: 0.7rem 1.4rem;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-luxury-light:hover {
        border-color: var(--salon-dark) !important;
        color: var(--salon-dark) !important;
    }

    .form-group-luxury {
        position: relative;
        margin-bottom: 1.5rem;
        text-align: left;
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
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
                <div>
                    <p class="mb-1 text-muted text-uppercase fw-semibold" style="letter-spacing: 1.5px; font-size: 0.7rem;">Workspace Inventory</p>
                    <h1 class="page-title">Studio Chairs Rental</h1>
                </div>
                <button type="button" class="btn-luxury-dark" data-bs-toggle="modal" data-bs-target="#createChairModal">
                    <i class="fe fe-plus"></i> Create New Chair
                </button>
            </div>

            <!-- Chairs Table -->
            <div class="chair-table-card">
                <div class="table-responsive">
                    <table id="chairs-table" class="table table-luxury mb-0">
                        <thead>
                            <tr>
                                <th>Chair Identifier</th>
                                <th>Type</th>
                                <th>Rental Status</th>
                                <th>Last Maintenance Update</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($chairs as $chair)
                                <tr>
                                    <td>
                                        <div class="fw-bold text-dark" style="font-size: 0.95rem; letter-spacing: 0.5px;">
                                            {{ $chair->name }}
                                        </div>
                                        <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.65rem; letter-spacing: 0.8px;">Styling Chair</small>
                                    </td>
                                    <td>
                                        <span class="text-dark fw-semibold">{{ $chair->type ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        @if($chair->status === 'available')
                                            <span class="badge-status available">Available</span>
                                        @else
                                            <span class="badge-status booked">Booked</span>
                                        @endif
                                    </td>
                                    <td class="text-muted">
                                        {{ $chair->updated_at->format('d M Y | h:i A') }}
                                    </td>
                                    <td class="text-end">
                                        <div class="action-btn-group justify-content-end">
                                            <a href="javascript:void(0)" class="action-btn" title="Modify Details & Status" data-bs-toggle="modal" data-bs-target="#editChairModal{{ $chair->id }}">
                                                <i class="fe fe-edit-3"></i>
                                            </a>
                                            <a href="javascript:void(0)" class="action-btn delete-btn delete-chair" data-id="{{ $chair->id }}" data-name="{{ $chair->name }}" title="Delete Chair">
                                                <i class="fe fe-trash-2"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fe fe-grid display-6 d-block mb-3" style="color: #dcd3be;"></i>
                                        No styling chairs registered in the inventory.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Create Chair Modal -->
        <div class="modal fade" id="createChairModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 0px; border: 1px solid #eae2d5;">
                    <div class="modal-header" style="background: #faf8f5; border-bottom: 1px solid #eae2d5; padding: 1.5rem;">
                        <h5 class="modal-title page-title" style="font-size: 1.1rem;">Register Styling Chair</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('chairs.store') }}" method="POST" class="ajaxForm">
                        @csrf
                        <div class="modal-body" style="padding: 2rem;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-luxury">
                                        <label for="name">Chair Name / Code <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control form-control-luxury" placeholder="e.g. Chair A, Station 1" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-luxury">
                                        <label for="type">Chair Type <span class="text-danger">*</span></label>
                                        <select name="type" class="form-control form-control-luxury form-select" required>
                                            <option value="" disabled selected>Select Type</option>
                                            <option value="Hair">Hair</option>
                                            <option value="Makeup">Makeup</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="border-top: 1px solid #eae2d5; padding: 1.5rem;">
                            <button type="button" class="btn-luxury-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn-luxury-dark">Save Chair</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @foreach ($chairs as $chair)
        <!-- Edit Chair Modal -->
        <div class="modal fade" id="editChairModal{{ $chair->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 0px; border: 1px solid #eae2d5;">
                    <div class="modal-header" style="background: #faf8f5; border-bottom: 1px solid #eae2d5; padding: 1.5rem;">
                        <h5 class="modal-title page-title" style="font-size: 1.1rem;">Modify Styling Chair</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('chairs.update', $chair->id) }}" method="POST" class="ajaxForm">
                        @csrf
                        <div class="modal-body" style="padding: 2rem;">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group-luxury">
                                        <label>Chair Name / Code <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control form-control-luxury" placeholder="e.g. Chair A, Station 1" value="{{ $chair->name }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-luxury">
                                        <label>Chair Type <span class="text-danger">*</span></label>
                                        <select name="type" class="form-control form-control-luxury form-select" required>
                                            <option value="Hair" {{ $chair->type === 'Hair' ? 'selected' : '' }}>Hair</option>
                                            <option value="Makeup" {{ $chair->type === 'Makeup' ? 'selected' : '' }}>Makeup</option>
                                            <option value="Wash" {{ $chair->type === 'Wash' ? 'selected' : '' }}>Wash</option>
                                            <option value="Other" {{ $chair->type === 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-luxury">
                                        <label>Rental Status <span class="text-danger">*</span></label>
                                        <select name="status" class="form-control form-control-luxury form-select" required>
                                            <option value="available" {{ $chair->status === 'available' ? 'selected' : '' }}>Available</option>
                                            <option value="booked" {{ $chair->status === 'booked' ? 'selected' : '' }}>Booked</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="border-top: 1px solid #eae2d5; padding: 1.5rem;">
                            <button type="button" class="btn-luxury-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn-luxury-dark">Update Chair</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>
@endsection

@section('JScript')
<script>
    $(document).ready(function() {
        // Initialize dynamic DataTable
        $('#chairs-table').DataTable({
            "order": [],
            "pageLength": 10,
            "language": {
                "search": "",
                "searchPlaceholder": "Instant Search...",
                "lengthMenu": "Show _MENU_ chairs",
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

        $(document).on('click', '.delete-chair', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            const name = $(this).data('name');
            const row = $(this).closest('tr');

            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to remove chair "${name}". Existing active styling bookings may be affected.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#121212',
                cancelButtonColor: '#eae2d5',
                confirmButtonText: 'Yes, Delete Chair',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ url('/chairs/delete') }}/${id}`,
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
                            Swal.fire('Error!', 'An error occurred while deleting chair.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
