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

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 0; background-color: #d4edda; border-color: #c3e6cb; color: #155724;">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 0;">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
                <div>
                    <p class="mb-1 text-muted text-uppercase fw-semibold" style="letter-spacing: 1.5px; font-size: 0.7rem;">Super Admin Panel</p>
                    <h1 class="page-title">Discount Coupons</h1>
                </div>
                <button type="button" class="btn-luxury-dark" data-bs-toggle="modal" data-bs-target="#createCouponModal">
                    <i class="fe fe-plus"></i> Create New Coupon
                </button>
            </div>

            <div class="user-table-card">
                <div class="table-responsive">
                    <table id="coupons-table" class="table table-luxury mb-0">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Discount</th>
                                <th>Expiry Date</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coupons as $coupon)
                                <tr>
                                    <td><strong>{{ $coupon->code }}</strong></td>
                                    <td>
                                        @if($coupon->discount_type == 'fixed')
                                            £{{ number_format($coupon->discount_value, 2) }}
                                        @else
                                            {{ $coupon->discount_value }}%
                                        @endif
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($coupon->expires_at)->format('d M Y') }}
                                        @if(\Carbon\Carbon::parse($coupon->expires_at)->isPast())
                                            <span class="badge bg-danger ms-2">Expired</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($coupon->is_active)
                                            <span class="badge-status active">Active</span>
                                        @else
                                            <span class="badge-status inactive">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $coupon->created_at->format('d M Y') }}</td>
                                    <td class="text-end">
                                        <div class="action-btn-group justify-content-end">
                                            <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                <button type="button" class="action-btn delete-btn" onclick="confirmDelete(this)" title="Delete Coupon">
                                                    <i class="fe fe-trash-2"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createCouponModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 0;">
            <div class="modal-header" style="background: #faf8f5; border-bottom: 1px solid #eae2d5;">
                <h5 class="modal-title" style="font-family: 'Playfair Display', serif; text-transform: uppercase; letter-spacing: 1px; color: var(--salon-dark);">Create Coupon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('coupons.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-uppercase fw-semibold" style="font-size: 0.75rem; color: #8c7e6c; letter-spacing: 1px;">Coupon Code</label>
                        <input type="text" name="code" class="form-control" style="border-radius: 0; background: #faf8f5;" required placeholder="e.g. SUMMER2026">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-uppercase fw-semibold" style="font-size: 0.75rem; color: #8c7e6c; letter-spacing: 1px;">Discount Type</label>
                            <select name="discount_type" class="form-select" style="border-radius: 0; background: #faf8f5;" required>
                                <option value="fixed">Fixed Amount (£)</option>
                                <option value="percentage">Percentage (%)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-uppercase fw-semibold" style="font-size: 0.75rem; color: #8c7e6c; letter-spacing: 1px;">Discount Value</label>
                            <input type="number" step="0.01" min="0" name="discount_value" class="form-control" style="border-radius: 0; background: #faf8f5;" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-uppercase fw-semibold" style="font-size: 0.75rem; color: #8c7e6c; letter-spacing: 1px;">Expiry Date</label>
                        <input type="date" name="expires_at" class="form-control" style="border-radius: 0; background: #faf8f5;" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" id="isActiveCheck" value="1" checked>
                        <label class="form-check-label" for="isActiveCheck">Is Active</label>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #eae2d5;">
                    <button type="button" class="btn btn-light" style="border-radius: 0;" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-luxury-dark">Save Coupon</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('JScript')
<script>
    function confirmDelete(button) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to delete this coupon. This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#121212',
            cancelButtonColor: '#eae2d5',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.value || result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }

    $(document).ready(function() {
        $('#coupons-table').DataTable({
            "order": [],
            "pageLength": 10,
            "language": {
                "search": "",
                "searchPlaceholder": "Search...",
                "paginate": {
                    "next": '<i class="fe fe-chevron-right"></i>',
                    "previous": '<i class="fe fe-chevron-left"></i>'
                }
            }
        });
    });
</script>
@endsection
