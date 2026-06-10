@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <!-- PAGE-HEADER -->
        <div class="page-header">
            <h1 class="page-title">Manage Bookings</h1>
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Bookings</li>
                </ol>
            </div>
        </div>
        <!-- PAGE-HEADER END -->

        <div class="row">
            <div class="col-12">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="card">
                    <div class="card-header border-bottom-0">
                        <h3 class="card-title">All Bookings</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap border-bottom" id="basic-datatable">
                                <thead>
                                    <tr>
                                        <th class="wd-15p border-bottom-0">ID</th>
                                        <th class="wd-15p border-bottom-0">Stylist</th>
                                        <th class="wd-20p border-bottom-0">Time</th>
                                        <th class="wd-15p border-bottom-0">Duration</th>
                                        <th class="wd-10p border-bottom-0">Amount</th>
                                        <th class="wd-10p border-bottom-0">Chairs</th>
                                        <th class="wd-10p border-bottom-0">Status</th>
                                        <th class="wd-10p border-bottom-0">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $b)
                                        <tr>
                                            <td>#{{ $b->id }}</td>
                                            <td>{{ $b->user->name }}<br><small class="text-muted">{{ $b->user->email }}</small></td>
                                            <td>
                                                <strong>Start:</strong> {{ \Carbon\Carbon::parse($b->start_datetime)->format('d M Y, h:i A') }}<br>
                                                <strong>End:</strong> {{ \Carbon\Carbon::parse($b->end_datetime)->format('d M Y, h:i A') }}
                                            </td>
                                            <td>{{ $b->duration_hours }} hrs</td>
                                            <td>
                                                £{{ number_format($b->total_amount, 2) }}
                                                @if($b->coupon_code)
                                                    <br><small class="text-success"><i class="fe fe-tag"></i> {{ $b->coupon_code }} (-£{{ number_format($b->discount_amount, 2) }})</small>
                                                @endif
                                            </td>
                                            <td>
                                                @foreach($b->chairs as $c)
                                                    <span class="badge bg-light text-dark border">{{ $c->name }}</span>
                                                @endforeach
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
                                                @endif
                                            </td>
                                            <td>
                                                @if($b->status === 'pending_approval')
                                                    <form method="POST" action="{{ route('bookings.update_status', $b->id) }}" style="display:inline;">
                                                        @csrf
                                                        <input type="hidden" name="status" value="pending_payment">
                                                        <button type="submit" class="btn btn-sm btn-success" title="Approve">
                                                            <i class="fe fe-check"></i> Approve
                                                        </button>
                                                    </form>
                                                    <form method="POST" action="{{ route('bookings.update_status', $b->id) }}" style="display:inline;">
                                                        @csrf
                                                        <input type="hidden" name="status" value="cancelled">
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Reject">
                                                            <i class="fe fe-x"></i> Reject
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-muted">No actions</span>
                                                @endif
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

@section('JScript')
<script>
    $(document).ready(function() {
        $('#basic-datatable').DataTable({
            "order": [[ 0, "desc" ]],
            "pageLength": 10,
            "language": {
                "search": "",
                "searchPlaceholder": "Search bookings...",
                "paginate": {
                    "next": '<i class="fe fe-chevron-right"></i>',
                    "previous": '<i class="fe fe-chevron-left"></i>'
                }
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        const timers = document.querySelectorAll('.admin-timer');
        if (timers.length > 0) {
            setInterval(() => {
                const now = new Date().getTime();
                timers.forEach(timer => {
                    const expiresAt = new Date(timer.getAttribute('data-expires')).getTime();
                    const distance = expiresAt - now;
                    
                    if (distance <= 0) {
                        timer.innerHTML = "Expired";
                        timer.classList.replace('text-danger', 'text-muted');
                    } else {
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                        timer.innerHTML = (minutes < 10 ? "0" : "") + minutes + ":" + (seconds < 10 ? "0" : "") + seconds;
                        if (minutes < 5) {
                            timer.style.fontWeight = 'bold';
                        }
                    }
                });
            }, 1000);
        }
    });
</script>
@endsection
