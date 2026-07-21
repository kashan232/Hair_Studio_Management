@extends('layouts.main')

@section('css')
<style>
    .bookings-toolbar {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }
    .bookings-toolbar .card-title {
        margin: 0;
    }
</style>
@endsection

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="page-header">
            <h1 class="page-title">Manage Bookings</h1>
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Bookings</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="card">
                    <div class="card-header border-bottom-0">
                        <div class="bookings-toolbar w-100">
                            <h3 class="card-title">All Bookings</h3>
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <span class="text-muted small">{{ $bookings->count() }} record(s)</span>
                                @if(auth()->user()?->canManageChairBookings())
                                    <a href="{{ route('stylist.book') }}" class="btn btn-dark btn-sm">
                                        <i class="fe fe-plus"></i> Add Booking Manually
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="dt-wrapper">
                            <table class="table table-bordered border-bottom" id="basic-datatable">
                                <thead>
                                    <tr>
                                        <th class="wd-10p border-bottom-0">ID</th>
                                        <th class="wd-10p border-bottom-0">Stylist</th>
                                        <th class="wd-20p border-bottom-0">Time</th>
                                        <th class="wd-10p border-bottom-0">Duration</th>
                                        <th class="wd-10p border-bottom-0">Amount</th>
                                        <th class="wd-10p border-bottom-0">Chairs</th>
                                        <th class="wd-15p border-bottom-0">Status</th>
                                        <th class="wd-15p border-bottom-0">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $b)
                                        <tr>
                                            <td data-order="{{ $b->id }}">
                                                @if(auth()->user()?->canManageChairBookings())
                                                    <a href="{{ route('bookings.show', $b->id) }}">#{{ $b->id }}</a>
                                                @else
                                                    #{{ $b->id }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($b->user)
                                                    {{ $b->user->name }}
                                                    <br>
                                                    <small class="text-muted">{{ $b->user->email }}</small>
                                                @else
                                                    {{ $b->guest_name ?? 'Guest' }}
                                                    <span class="badge bg-secondary ms-1" style="font-size:0.6rem;">Guest</span>
                                                    <br>
                                                    <small class="text-muted">{{ $b->guest_email }}</small>
                                                @endif
                                                <br>
                                                @if($b->consent_photography)
                                                    <span class="badge bg-success mt-1" style="font-size: 0.65rem;"><i class="fe fe-camera"></i> Consented to Photography</span>
                                                @else
                                                    <span class="badge bg-light text-muted mt-1 border" style="font-size: 0.65rem;"><i class="fe fe-camera-off"></i> No Photo Consent</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small>
                                                    <strong>Start:</strong> {{ optional($b->start_datetime)->format('d M Y, h:i A') ?? '—' }}<br>
                                                    <strong>End:</strong> {{ optional($b->end_datetime)->format('d M Y, h:i A') ?? '—' }}
                                                </small>
                                            </td>
                                            <td>{{ $b->duration_hours }} hrs</td>
                                            <td>
                                                £{{ number_format((float) $b->total_amount, 2) }}
                                                @if($b->coupon_code)
                                                    <br><small class="text-success"><i class="fe fe-tag"></i> {{ $b->coupon_code }} (-£{{ number_format((float) $b->discount_amount, 2) }})</small>
                                                @endif
                                            </td>
                                            <td>
                                                @forelse($b->chairs as $c)
                                                    <span class="badge bg-light text-dark border">{{ $c->name }}</span>
                                                @empty
                                                    <span class="text-muted">—</span>
                                                @endforelse
                                                @if($b->setup_type && $b->setup_type !== 'any')
                                                    <br><small class="text-muted"><strong>Setup:</strong> {{ $b->setup_type === 'makeup' ? 'Make-up Chair' : 'Hair Stylist Chair' }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if($b->status === 'pending_approval')
                                                    <span class="badge bg-warning text-dark">Pending Approval</span>
                                                @elseif($b->status === 'pending_payment')
                                                    <span class="badge bg-info text-dark">Pending Payment</span>
                                                    @if($b->expires_at)
                                                        <br><small class="text-danger admin-timer" data-expires="{{ \Carbon\Carbon::parse($b->expires_at)->toIso8601String() }}">Wait: --:--</small>
                                                    @endif
                                                @elseif($b->status === 'confirmed')
                                                    <span class="badge bg-success">Confirmed</span>
                                                @elseif($b->status === 'cancelled')
                                                    <span class="badge bg-danger">Cancelled</span>
                                                @elseif($b->status === 'cancelled_late_response')
                                                    <span class="badge bg-danger">Cancelled (Late Response)</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $b->status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $canStaffCancel = auth()->user()?->canManageChairBookings()
                                                        && !in_array($b->status, ['cancelled', 'cancelled_late_response'], true);
                                                    $canOpenRefund = auth()->user()?->canManageChairBookings()
                                                        && (float) $b->total_amount > 0;
                                                @endphp
                                                <div class="d-flex flex-column gap-2">
                                                    @if(auth()->user()?->canManageChairBookings())
                                                        <a href="{{ route('bookings.show', $b->id) }}" class="btn btn-sm btn-dark w-100">
                                                            <i class="fe fe-eye"></i> View / Refund
                                                        </a>
                                                    @endif

                                                    @if($b->status === 'pending_approval')
                                                        <form method="POST" action="{{ route('bookings.update_status', $b->id) }}">
                                                            @csrf
                                                            <input type="hidden" name="status" value="pending_payment">
                                                            <button type="submit" class="btn btn-sm btn-success w-100" title="Approve">
                                                                <i class="fe fe-check"></i> Approve
                                                            </button>
                                                        </form>
                                                        <form method="POST" action="{{ route('bookings.update_status', $b->id) }}">
                                                            @csrf
                                                            <input type="hidden" name="status" value="cancelled">
                                                            <button type="submit" class="btn btn-sm btn-danger w-100" title="Reject">
                                                                <i class="fe fe-x"></i> Reject
                                                            </button>
                                                        </form>
                                                    @elseif($canStaffCancel)
                                                        <form method="POST" action="{{ route('bookings.cancel', $b->id) }}" class="admin-cancel-booking-form" data-booking-id="{{ $b->id }}">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                                                <i class="fe fe-slash"></i> Cancel Booking
                                                            </button>
                                                        </form>
                                                    @elseif(!$canOpenRefund)
                                                        <span class="text-muted">No actions</span>
                                                    @endif

                                                    @if($b->refunded_at)
                                                        <small class="text-success d-block" style="font-size:0.7rem;">
                                                            Refunded £{{ number_format((float) $b->refunded_amount, 2) }}
                                                        </small>
                                                    @endif
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
    </div>
</div>
@endsection

@section('JScript')
<script>
    $(document).ready(function() {
        try {
            if ($.fn.DataTable.isDataTable('#basic-datatable')) {
                $('#basic-datatable').DataTable().destroy();
            }

            $('#basic-datatable').DataTable({
                order: [[0, 'desc']],
                pageLength: 25,
                deferRender: true,
                autoWidth: false,
                language: {
                    emptyTable: 'No bookings found.',
                    search: '',
                    searchPlaceholder: 'Search bookings...',
                    lengthMenu: 'Show _MENU_ bookings',
                    paginate: {
                        next: '<i class="fe fe-chevron-right"></i>',
                        previous: '<i class="fe fe-chevron-left"></i>'
                    }
                }
            });
        } catch (e) {
            console.error('Bookings DataTable init failed:', e);
        }

        $(document).on('submit', '.admin-cancel-booking-form', function(e) {
            e.preventDefault();
            var form = this;
            var id = $(form).data('booking-id');
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Cancel booking #' + id + '?',
                    text: 'This frees the chair. Paid bookings 24h+ before start will be refunded automatically.',
                    type: 'warning',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#461111',
                    confirmButtonText: 'Yes, cancel',
                    cancelButtonText: 'Keep'
                }).then(function(result) {
                    if (result.value || result.isConfirmed) form.submit();
                });
            } else if (confirm('Cancel booking #' + id + '?')) {
                form.submit();
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const timers = document.querySelectorAll('.admin-timer');
        if (!timers.length) return;

        setInterval(function() {
            const now = new Date().getTime();
            timers.forEach(function(timer) {
                const expiresAt = new Date(timer.getAttribute('data-expires')).getTime();
                const distance = expiresAt - now;

                if (distance <= 0) {
                    timer.innerHTML = 'Expired';
                    timer.classList.remove('text-danger');
                    timer.classList.add('text-muted');
                } else {
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    timer.innerHTML = (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
                    if (minutes < 5) timer.style.fontWeight = 'bold';
                }
            });
        }, 1000);
    });
</script>
@endsection
