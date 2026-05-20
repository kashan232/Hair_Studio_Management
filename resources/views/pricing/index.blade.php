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

    .currency-prefix {
        color: var(--salon-dark) !important;
        font-weight: 700;
        border-radius: 0;
        border-color: #dcd3be !important;
        background: #faf8f5 !important;
    }

    .action-btn .currency-symbol {
        color: #8c7e6c !important;
        font-size: 0.85rem;
        font-weight: 700;
    }

    .action-btn:hover .currency-symbol {
        color: var(--salon-dark) !important;
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
                    <h1 class="page-title">Pricing & Slots Setup</h1>
                </div>
                <button type="button" class="btn-luxury-dark" data-bs-toggle="modal" data-bs-target="#createPricingModal">
                    <i class="fe fe-plus"></i> Create Pricing
                </button>
            </div>

            <!-- Chairs Table -->
            <div class="chair-table-card">
                <div class="table-responsive">
                    <table id="pricing-table" class="table table-luxury mb-0">
                        <thead>
                            <tr>
                                <th>Chair Identifier</th>
                                <th>Type</th>
                                <th>Current Pricing (£)</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pricedChairs as $chair)
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
                                        <div style="font-size: 0.75rem; line-height: 1.4;">
                                            @if($chair->price_hourly)<span class="text-muted">Hourly:</span> <span class="fw-bold text-dark">£{{ number_format($chair->price_hourly, 2) }}</span><br>@endif
                                            @if($chair->price_daily)<span class="text-muted">Daily:</span> <span class="fw-bold text-dark">£{{ number_format($chair->price_daily, 2) }}</span><br>@endif
                                            @if($chair->price_monthly)<span class="text-muted">Monthly:</span> <span class="fw-bold text-dark">£{{ number_format($chair->price_monthly, 2) }}</span><br>@endif
                                            @if($chair->price_yearly)<span class="text-muted">Yearly:</span> <span class="fw-bold text-dark">£{{ number_format($chair->price_yearly, 2) }}</span>@endif
                                            @if(!$chair->price_hourly && !$chair->price_daily && !$chair->price_monthly && !$chair->price_yearly)
                                                <span class="text-muted fst-italic">Not Set</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <div class="action-btn-group justify-content-end">
                                            <a href="javascript:void(0)" class="action-btn" title="Setup Pricing" data-bs-toggle="modal" data-bs-target="#editPricingModal{{ $chair->id }}">
                                                <span class="currency-symbol">£</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Create Pricing Modal -->
        <div class="modal fade" id="createPricingModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 0px; border: 1px solid #eae2d5;">
                    <div class="modal-header" style="background: #faf8f5; border-bottom: 1px solid #eae2d5; padding: 1.5rem;">
                        <h5 class="modal-title page-title" style="font-size: 1.1rem;">Create Pricing</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('pricing.store') }}" method="POST" class="ajaxForm">
                        @csrf
                        <div class="modal-body" style="padding: 2rem;">
                            @php
                                $unpricedChairs = $allChairs->filter(fn ($c) => !$c->price_hourly && !$c->price_daily && !$c->price_monthly && !$c->price_yearly);
                            @endphp
                            @if($unpricedChairs->isEmpty())
                                <p class="text-muted text-center mb-0">All chairs already have pricing. Use the edit action on an existing row to update prices.</p>
                            @else
                            <div class="form-group-luxury mb-4">
                                <label for="chair_id">Select Chair <span class="text-danger">*</span></label>
                                <select name="chair_id" id="chair_id" class="form-control form-control-luxury form-select" required>
                                    <option value="" disabled selected>Select Chair</option>
                                    @foreach($unpricedChairs as $chair)
                                        <option value="{{ $chair->id }}">{{ $chair->name }} ({{ $chair->type ?? 'N/A' }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-luxury mb-3">
                                        <label>Hourly Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text currency-prefix">£</span>
                                            <input type="number" step="0.01" name="price_hourly" class="form-control form-control-luxury" placeholder="0.00" min="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-luxury mb-3">
                                        <label>Daily Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text currency-prefix">£</span>
                                            <input type="number" step="0.01" name="price_daily" class="form-control form-control-luxury" placeholder="0.00" min="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-luxury mb-0">
                                        <label>Monthly Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text currency-prefix">£</span>
                                            <input type="number" step="0.01" name="price_monthly" class="form-control form-control-luxury" placeholder="0.00" min="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-luxury mb-0">
                                        <label>Yearly Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text currency-prefix">£</span>
                                            <input type="number" step="0.01" name="price_yearly" class="form-control form-control-luxury" placeholder="0.00" min="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="modal-footer" style="border-top: 1px solid #eae2d5; padding: 1.5rem;">
                            <button type="button" class="btn-luxury-light" data-bs-dismiss="modal">Cancel</button>
                            @if($unpricedChairs->isNotEmpty())
                            <button type="submit" class="btn-luxury-dark">Save Pricing</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @foreach ($pricedChairs as $chair)
        <!-- Edit Pricing Modal -->
        <div class="modal fade" id="editPricingModal{{ $chair->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 0px; border: 1px solid #eae2d5;">
                    <div class="modal-header" style="background: #faf8f5; border-bottom: 1px solid #eae2d5; padding: 1.5rem;">
                        <h5 class="modal-title page-title" style="font-size: 1.1rem;">Setup Pricing - {{ $chair->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('pricing.update', $chair->id) }}" method="POST" class="ajaxForm">
                        @csrf
                        <div class="modal-body" style="padding: 2rem;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-luxury mb-3">
                                        <label>Hourly Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text currency-prefix">£</span>
                                            <input type="number" step="0.01" name="price_hourly" class="form-control form-control-luxury" placeholder="0.00" value="{{ $chair->price_hourly }}" min="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-luxury mb-3">
                                        <label>Daily Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text currency-prefix">£</span>
                                            <input type="number" step="0.01" name="price_daily" class="form-control form-control-luxury" placeholder="0.00" value="{{ $chair->price_daily }}" min="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-luxury mb-0">
                                        <label>Monthly Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text currency-prefix">£</span>
                                            <input type="number" step="0.01" name="price_monthly" class="form-control form-control-luxury" placeholder="0.00" value="{{ $chair->price_monthly }}" min="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-luxury mb-0">
                                        <label>Yearly Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text currency-prefix">£</span>
                                            <input type="number" step="0.01" name="price_yearly" class="form-control form-control-luxury" placeholder="0.00" value="{{ $chair->price_yearly }}" min="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="border-top: 1px solid #eae2d5; padding: 1.5rem;">
                            <button type="button" class="btn-luxury-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn-luxury-dark">Save Pricing</button>
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
        $('#pricing-table').DataTable({
            "order": [],
            "pageLength": 10,
            "language": {
                "emptyTable": "No pricing profiles registered.",
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
    });
</script>
@endsection
