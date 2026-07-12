@extends('layouts.main')

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <!-- PAGE-HEADER -->
        <div class="page-header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="page-title text-dark fw-bold mb-1">Manage Packages</h1>
                <p class="text-muted">Create and manage prepaid hours packages for stylists.</p>
            </div>
            <div>
                <a href="{{ route('admin.packages.create') }}" class="btn btn-primary rounded-pill shadow-sm px-4 fw-bold">
                    <i class="fa fa-plus me-2"></i>Create Package
                </a>
            </div>
        </div>
        <!-- PAGE-HEADER END -->

        <div class="row">
            <div class="col-12">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-3" role="alert">
                        <strong><i class="fa fa-check-circle me-2"></i>Success!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card border-0 shadow-sm rounded-4 mb-5 overflow-hidden">
                    <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                        <h4 class="card-title mb-0 fw-bold"><i class="fa fa-box me-2 text-primary"></i>Available Packages</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="py-3 px-4 text-uppercase text-muted" style="font-size: 0.8rem; font-weight: 700;">Package Name</th>
                                        <th class="py-3 px-4 text-uppercase text-muted" style="font-size: 0.8rem; font-weight: 700;">Hours</th>
                                        <th class="py-3 px-4 text-uppercase text-muted" style="font-size: 0.8rem; font-weight: 700;">Price (£)</th>
                                        <th class="py-3 px-4 text-uppercase text-muted" style="font-size: 0.8rem; font-weight: 700;">Validity</th>
                                        <th class="py-3 px-4 text-uppercase text-muted" style="font-size: 0.8rem; font-weight: 700;">Status</th>
                                        <th class="py-3 px-4 text-uppercase text-muted" style="font-size: 0.8rem; font-weight: 700;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($packages as $package)
                                    <tr>
                                        <td class="px-4 fw-bold text-dark">{{ $package->name }}</td>
                                        <td class="px-4">
                                            <span class="badge bg-primary rounded-pill px-3">{{ $package->hours }} Hrs</span>
                                        </td>
                                        <td class="px-4 fw-semibold text-success">£{{ number_format($package->price, 2) }}</td>
                                        <td class="px-4 text-muted small">
                                            @if($package->expiry_days)
                                                {{ $package->expiry_days }} Days
                                            @else
                                                <span class="fst-italic opacity-50">No Expiry</span>
                                            @endif
                                        </td>
                                        <td class="px-4">
                                            @if($package->is_active)
                                                <span class="badge bg-success rounded-pill px-3 py-1" style="font-size: 0.75rem;"><i class="fa fa-check me-1"></i> Active</span>
                                            @else
                                                <span class="badge bg-secondary rounded-pill px-3 py-1" style="font-size: 0.75rem;"><i class="fa fa-ban me-1"></i> Inactive</span>
                                            @endif
                                        </td>
                                        <td class="px-4">
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('admin.packages.edit', $package) }}" class="btn btn-sm btn-outline-info rounded-pill px-3">Edit</a>
                                                <form action="{{ route('admin.packages.destroy', $package) }}" method="POST">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Delete this package?')">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <div class="mb-3"><i class="fa fa-box-open fa-3x opacity-50"></i></div>
                                            No packages created yet.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                        <h4 class="card-title mb-0 fw-bold"><i class="fa fa-users me-2 text-primary"></i>User Package Balances</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="py-3 px-4 text-uppercase text-muted" style="font-size: 0.8rem; font-weight: 700;">Stylist</th>
                                        <th class="py-3 px-4 text-uppercase text-muted" style="font-size: 0.8rem; font-weight: 700;">Package</th>
                                        <th class="py-3 px-4 text-uppercase text-muted" style="font-size: 0.8rem; font-weight: 700;">Hours Purchased</th>
                                        <th class="py-3 px-4 text-uppercase text-muted" style="font-size: 0.8rem; font-weight: 700;">Hours Remaining</th>
                                        <th class="py-3 px-4 text-uppercase text-muted" style="font-size: 0.8rem; font-weight: 700;">Expires On</th>
                                        <th class="py-3 px-4 text-uppercase text-muted" style="font-size: 0.8rem; font-weight: 700;">Status</th>
                                        <th class="py-3 px-4 text-uppercase text-muted" style="font-size: 0.8rem; font-weight: 700;">Purchased On</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($userPackages as $up)
                                    <tr>
                                        <td class="px-4">
                                            <div class="fw-bold text-dark">{{ $up->user->name ?? 'Unknown' }}</div>
                                            <div class="text-muted small">{{ $up->user->email ?? '' }}</div>
                                        </td>
                                        <td class="px-4 fw-semibold text-secondary">{{ $up->package->name ?? 'Deleted Package' }}</td>
                                        <td class="px-4 text-muted">{{ $up->hours_purchased }} Hrs</td>
                                        <td class="px-4">
                                            <span class="badge {{ $up->hours_remaining > 0 ? 'bg-success' : 'bg-danger' }} rounded-pill px-3 py-2" style="font-size: 0.85rem;">
                                                {{ $up->hours_remaining }} Hrs
                                            </span>
                                        </td>
                                        <td class="px-4 text-muted small">
                                            @if($up->expires_at)
                                                {{ $up->expires_at->format('M d, Y') }}
                                            @else
                                                <span class="fst-italic opacity-50">No Expiry</span>
                                            @endif
                                        </td>
                                        <td class="px-4">
                                            @if($up->status == 'active')
                                                @if($up->expires_at && $up->expires_at->isPast())
                                                    <span class="badge bg-danger-transparent text-danger rounded-pill px-3 py-1" style="font-size: 0.75rem;"><i class="fa fa-clock me-1"></i> Expired</span>
                                                @else
                                                    <span class="badge bg-success-transparent text-success rounded-pill px-3 py-1" style="font-size: 0.75rem;"><i class="fa fa-check-circle me-1"></i> Active</span>
                                                @endif
                                            @else
                                                <span class="badge bg-danger-transparent text-danger rounded-pill px-3 py-1" style="font-size: 0.75rem;"><i class="fa fa-times-circle me-1"></i> Exhausted</span>
                                            @endif
                                        </td>
                                        <td class="px-4 text-muted small">{{ $up->created_at->format('M d, Y') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <div class="mb-3"><i class="fa fa-users-slash fa-3x opacity-50"></i></div>
                                            No user packages purchased yet.
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
    </div>
</div>
@endsection
