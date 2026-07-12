@extends('layouts.stylist-app')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Outfit', sans-serif;
        background-color: #fcf9f8;
    }
    :root {
        --salon-theme: #461111e6;
        --salon-theme-solid: #461111;
        --salon-accent: #c39b77;
    }
    .page-title {
        font-weight: 700;
        color: var(--salon-theme-solid);
        letter-spacing: -0.5px;
    }
    
    /* Balance Card */
    .balance-card {
        background: linear-gradient(135deg, var(--salon-theme-solid) 0%, #2a0a0a 100%);
        border: none;
        border-radius: 20px;
        color: white;
        box-shadow: 0 12px 24px rgba(70, 17, 17, 0.2);
        position: relative;
        overflow: hidden;
    }
    .balance-card::before {
        content: "";
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 60%);
        transform: rotate(45deg);
    }
    .balance-card .display-3 {
        color: white !important;
        font-weight: 700;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
    
    /* Package Cards */
    .pkg-card {
        border: 1px solid rgba(0,0,0,0.05);
        border-radius: 20px;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        background: white;
        overflow: hidden;
    }
    .pkg-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(70, 17, 17, 0.1) !important;
        border-color: rgba(70, 17, 17, 0.2);
    }
    .pkg-card-header {
        background-color: var(--salon-theme-solid);
        color: white;
        font-weight: 600;
        letter-spacing: 1px;
        padding: 1rem;
        border-bottom: none;
    }
    .pkg-price {
        font-weight: 700;
        color: var(--salon-theme-solid);
    }
    .btn-theme {
        background-color: var(--salon-theme-solid);
        color: white;
        border-radius: 50px;
        font-weight: 600;
        padding: 0.6rem 2rem;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    .btn-theme:hover {
        background-color: transparent;
        color: var(--salon-theme-solid);
        border-color: var(--salon-theme-solid);
    }

    /* History Table */
    .history-card {
        border-radius: 20px;
        border: none;
        overflow: hidden;
        background: white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    .table > :not(caption) > * > * {
        padding: 1rem;
        border-bottom-color: #f0f0f0;
    }
    .table thead th {
        border-bottom: none;
        background-color: #f8f9fa;
        color: #555;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }
</style>
@endsection

@section('content')
<div class="container my-5" style="max-width: 1000px;">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h2 class="page-title mb-0">My Bundles</h2>
        <a href="{{ route('stylist.my_bookings') }}" class="btn btn-outline-secondary rounded-pill px-4">Back to Bookings</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-pill px-4 border-0 shadow-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger rounded-pill px-4 border-0 shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="card balance-card mb-5 p-4 text-center">
        <div class="card-body position-relative" style="z-index: 1;">
            <h6 class="text-uppercase mb-3" style="color: rgba(255,255,255,0.8); letter-spacing: 1.5px;">Available Booking Hours</h6>
            <h1 class="display-3 mb-2">{{ $totalBalance }} <span style="font-size: 1.5rem; opacity: 0.8;">hrs</span></h1>
            <p class="mb-0" style="color: rgba(255,255,255,0.7);">These hours will be automatically deducted when you book your next session.</p>
        </div>
    </div>

    <h4 class="mb-4 page-title" style="font-size: 1.5rem;">Purchase a Bundle</h4>
    <div class="row mb-5 g-4">
        @foreach($packages as $package)
        <div class="col-md-4">
            <div class="card h-100 pkg-card text-center shadow-sm">
                <div class="card-header pkg-card-header text-uppercase">
                    {{ $package->name }}
                </div>
                <div class="card-body d-flex flex-column justify-content-center p-4">
                    <h2 class="mb-3 pkg-price">£{{ number_format($package->price, 2) }}</h2>
                    <p class="text-muted mb-2" style="font-size: 1.1rem;">{{ $package->hours }} Booking Hours</p>
                    <p class="small mb-4" style="color: #28a745; font-weight: 600; background: rgba(40,167,69,0.1); padding: 5px 15px; border-radius: 20px; display: inline-block; margin: 0 auto;">
                        £{{ number_format($package->price / $package->hours, 2) }} / hr
                    </p>
                    @if($package->expiry_days)
                        <p class="text-muted small mb-4"><i class="fa fa-calendar-alt me-1"></i> Valid for {{ $package->expiry_days }} days</p>
                    @else
                        <p class="text-muted small mb-4"><i class="fa fa-infinity me-1"></i> No Expiry</p>
                    @endif
                    <a href="{{ route('stylist.packages.checkout', $package) }}" class="btn btn-theme mt-auto">Buy Now</a>
                </div>
            </div>
        </div>
        @endforeach
        @if($packages->isEmpty())
            <div class="col-12"><p class="text-muted text-center p-5 bg-white rounded-4 shadow-sm">No bundles are currently available for purchase.</p></div>
        @endif
    </div>

    <h4 class="mb-4 page-title" style="font-size: 1.5rem;">Purchase History</h4>
    <div class="history-card">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="ps-4">Package</th>
                        <th>Hours Purchased</th>
                        <th>Hours Remaining</th>
                        <th>Status</th>
                        <th>Expires On</th>
                        <th class="pe-4">Date Purchased</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($myPackages as $up)
                    <tr>
                        <td class="ps-4 font-weight-bold">{{ $up->package->name ?? 'Deleted Package' }}</td>
                        <td>{{ $up->hours_purchased }} hrs</td>
                        <td><strong style="color: var(--salon-theme-solid);">{{ $up->hours_remaining }} hrs</strong></td>
                        <td>
                            @if($up->status == 'active')
                                @if($up->expires_at && $up->expires_at->isPast())
                                    <span class="badge rounded-pill bg-danger px-3 py-2">Expired</span>
                                @else
                                    <span class="badge rounded-pill bg-success px-3 py-2">Active</span>
                                @endif
                            @else
                                <span class="badge rounded-pill bg-secondary px-3 py-2">Exhausted</span>
                            @endif
                        </td>
                        <td class="text-muted">
                            @if($up->expires_at)
                                {{ $up->expires_at->format('M d, Y') }}
                            @else
                                <span class="opacity-50">Never</span>
                            @endif
                        </td>
                        <td class="pe-4 text-muted">{{ $up->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                    @if($myPackages->isEmpty())
                        <tr><td colspan="5" class="text-center text-muted p-5">You haven't purchased any bundles yet.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
