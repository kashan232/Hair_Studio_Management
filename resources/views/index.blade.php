@extends('layouts.main')

@section('css')
<style>
    :root {
        --gov-green: #006837;
        --gov-dark-green: #004d2a;
        --gov-gold: #c6a34d;
        --gov-navy: #1a237e;
        --executive-blue: #2c3e50;
        --dash-bg: #f0f4f3;
    }

    .dashboard-wrap { padding: 0 0 2rem; }

    .dash-hero {
        background: linear-gradient(135deg, var(--gov-dark-green) 0%, var(--gov-green) 55%, #0d7a47 100%);
        border-radius: 16px;
        padding: 2rem 2.25rem;
        color: #fff;
        margin-bottom: 1.75rem;
        box-shadow: 0 12px 40px rgba(0, 77, 42, 0.25);
        position: relative;
        overflow: hidden;
    }

    .dash-hero::after {
        content: '';
        position: absolute;
        right: -40px;
        top: -40px;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.06);
    }

    .dash-hero h1 {
        font-weight: 800;
        font-size: 1.65rem;
        letter-spacing: 0.5px;
        margin-bottom: 0.35rem;
        text-transform: uppercase;
    }

    .dash-hero .subtitle {
        opacity: 0.92;
        font-size: 0.95rem;
        font-weight: 500;
    }

    .dash-hero .badge-gov {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.35);
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .kpi-strip .kpi-card {
        background: #fff;
        border-radius: 12px;
        padding: 1.25rem 1.35rem;
        height: 100%;
        border: 1px solid #e8eeec;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.04);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .kpi-strip .kpi-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 28px rgba(0, 0, 0, 0.08);
    }

    .kpi-card .kpi-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        margin-bottom: 0.75rem;
    }

    .kpi-card .kpi-value {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--executive-blue);
        line-height: 1.1;
    }

    .kpi-card .kpi-label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #7f8c8d;
        margin-top: 0.25rem;
    }

    .section-head {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        margin-bottom: 1.25rem;
    }

    .section-head h2 {
        font-size: 0.85rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: var(--gov-dark-green);
        margin: 0;
    }

    .channel-breadcrumb {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.72rem;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .channel-breadcrumb span.sep { color: #adb5bd; }

    .channel-summary-card {
        background: #fff;
        border-radius: 12px;
        padding: 1.35rem 1.25rem;
        height: 100%;
        border: 1px solid #e8eeec;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
        transition: all 0.25s ease;
        text-decoration: none;
        color: inherit;
        display: block;
        position: relative;
        overflow: hidden;
    }

    .channel-summary-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--card-accent, var(--gov-green));
    }

    .channel-summary-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 32px rgba(0, 0, 0, 0.1);
        color: inherit;
    }

    .channel-summary-card .cs-badge {
        display: inline-block;
        font-size: 0.65rem;
        font-weight: 800;
        letter-spacing: 1px;
        padding: 0.2rem 0.55rem;
        border-radius: 4px;
        background: var(--card-accent, var(--gov-green));
        color: #fff;
        margin-bottom: 0.85rem;
    }

    .channel-summary-card .cs-title {
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #7f8c8d;
        margin-bottom: 0.35rem;
    }

    .channel-summary-card .cs-count {
        font-size: 2rem;
        font-weight: 900;
        color: var(--executive-blue);
        line-height: 1;
    }

    .channel-summary-card .cs-hint {
        font-size: 0.75rem;
        color: #95a5a6;
        margin-top: 0.5rem;
        margin-bottom: 0;
    }

    .loc-mini-card {
        background: #fff;
        border-radius: 12px;
        padding: 1.15rem;
        height: 100%;
        border-left: 4px solid var(--gov-green);
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04);
        text-decoration: none;
        color: inherit;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.2s ease;
    }

    .loc-mini-card:hover { color: inherit; box-shadow: 0 8px 22px rgba(0,0,0,0.08); }
    .loc-mini-card.card-navy { border-left-color: var(--gov-navy); }
    .loc-mini-card.card-gold { border-left-color: var(--gov-gold); }
    .loc-mini-card.card-dark { border-left-color: var(--executive-blue); }

    .loc-mini-card .icon-wrap {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        background: #f0f4f3;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        color: var(--gov-green);
    }

    .loc-mini-card .loc-count { font-size: 1.65rem; font-weight: 800; color: var(--executive-blue); }
    .loc-mini-card .loc-label { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #7f8c8d; }

    .panel-card {
        background: #fff;
        border-radius: 12px;
        padding: 1.35rem;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.04);
        border: 1px solid #e8eeec;
        height: auto;
        overflow: hidden;
        position: relative;
        z-index: 1;
        margin-bottom: 0;
    }

    .dashboard-wrap .row {
        position: relative;
        z-index: auto;
    }

    .dashboard-wrap .row > [class*="col-"] {
        position: relative;
        z-index: auto;
    }

    .chart-box {
        position: relative;
        width: 100%;
        overflow: hidden;
        isolation: isolate;
    }

    .chart-box--sm { min-height: 300px; height: 300px; }
    .chart-box--lg { min-height: 360px; height: 360px; }

    .dashboard-wrap .apexcharts-canvas,
    .dashboard-wrap .apexcharts-svg {
        max-width: 100% !important;
    }

    .sidebar-stack .panel-card + .panel-card {
        margin-top: 1rem;
    }

    .dashboard-analytics {
        clear: both;
        margin-top: 0.5rem;
    }

    .panel-card h5 {
        font-size: 0.8rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: var(--gov-dark-green);
        margin-bottom: 1rem;
        padding-bottom: 0.65rem;
        border-bottom: 2px solid #f0f4f3;
    }

    .activity-item {
        padding: 0.75rem 0;
        border-bottom: 1px solid #f0f4f3;
    }

    .activity-item:last-child { border-bottom: none; }

    .quick-link {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        padding: 0.65rem 0.85rem;
        border-radius: 8px;
        text-decoration: none;
        color: var(--executive-blue);
        font-weight: 600;
        font-size: 0.875rem;
        transition: background 0.15s;
    }

    .quick-link:hover { background: #f0f4f3; color: var(--gov-dark-green); }
    .quick-link i { color: var(--gov-green); font-size: 1.1rem; }

    .irr-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 50px;
        text-decoration: none;
        color: var(--executive-blue);
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s;
    }

    .irr-pill:hover { border-color: var(--gov-green); color: var(--gov-dark-green); background: #f8fbf9; }
    .irr-pill strong { color: var(--gov-green); }
</style>
@endsection

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid dashboard-wrap">

            <div class="dash-hero">
                <div class="row align-items-center position-relative" style="z-index: 1">
                    <div class="col-lg-8">
                        <h1>Nara Canal Area Water Board</h1>
                        <p class="subtitle mb-2">Sindh Irrigation And Drainage Authority · E-ABIANA Digitization</p>
                        <span class="badge badge-gov px-3 py-2">Government of Sindh</span>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                        <p class="mb-1 small opacity-75">Master records overview</p>
                        <p class="mb-0 display-6 fw-bold">{{ number_format($stats['grand_total']) }}</p>
                        <p class="small opacity-75 mb-0">Total hierarchy entries</p>
                    </div>
                </div>
            </div>

            <div class="row g-3 kpi-strip mb-4">
                <div class="col-sm-6 col-xl-3">
                    <div class="kpi-card">
                        <div class="kpi-icon" style="background: rgba(0,104,55,0.12); color: var(--gov-green);">
                            <i class="fe fe-map-pin"></i>
                        </div>
                        <div class="kpi-value">{{ number_format($stats['location_total']) }}</div>
                        <div class="kpi-label">Location records</div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="kpi-card">
                        <div class="kpi-icon" style="background: rgba(26,35,126,0.1); color: var(--gov-navy);">
                            <i class="fe fe-git-branch"></i>
                        </div>
                        <div class="kpi-value">{{ number_format($stats['channel_total']) }}</div>
                        <div class="kpi-label">Channel records</div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="kpi-card">
                        <div class="kpi-icon" style="background: rgba(198,163,77,0.15); color: #9a7b2e;">
                            <i class="fe fe-droplet"></i>
                        </div>
                        <div class="kpi-value">{{ number_format($stats['irrigation_total']) }}</div>
                        <div class="kpi-label">Irrigation admin</div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="kpi-card">
                        <div class="kpi-icon" style="background: rgba(44,62,80,0.1); color: var(--executive-blue);">
                            <i class="fe fe-users"></i>
                        </div>
                        <div class="kpi-value">{{ number_format($stats['total_users']) }}</div>
                        <div class="kpi-label">System users</div>
                    </div>
                </div>
            </div>

            <div class="section-head">
                <h2>Channels summary</h2>
                <div class="channel-breadcrumb">
                    <span>Barrage</span><span class="sep">/</span>
                    <span>Main Canal</span><span class="sep">/</span>
                    <span>Sub Canal</span><span class="sep">/</span>
                    <span>Branch Canal</span><span class="sep">/</span>
                    <span>Distributary</span><span class="sep">/</span>
                    <span>Minor</span><span class="sep">/</span>
                    <span>WC</span>
                </div>
            </div>

            <div class="row row-cols-2 row-cols-sm-3 row-cols-lg-4 row-cols-xl-7 g-3 mb-4">
                @foreach ($stats['channels'] as $ch)
                    <div class="col">
                        <a href="{{ route($ch['route']) }}" class="channel-summary-card" style="--card-accent: {{ $ch['accent'] }}">
                            <span class="cs-badge">{{ $ch['badge'] }}</span>
                            <div class="cs-title">{{ $ch['label'] }}</div>
                            <div class="cs-count">{{ number_format($ch['count']) }}</div>
                            <p class="cs-hint">{{ $ch['hint'] }}</p>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="row g-4 mb-4 align-items-start">
                <div class="col-xl-8">
                    <div class="section-head">
                        <h2>Location hierarchy</h2>
                        <a href="{{ route('locations.import') }}" class="btn btn-sm btn-outline-success">Bulk import</a>
                    </div>
                    <div class="row g-3">
                        @php $locStyles = ['', 'card-navy', 'card-gold', 'card-dark']; @endphp
                        @foreach ($stats['locations'] as $i => $loc)
                            <div class="col-sm-6">
                                <a href="{{ route($loc['route']) }}" class="loc-mini-card {{ $locStyles[$i] ?? '' }}">
                                    <div class="icon-wrap"><i class="fe {{ $loc['icon'] }}"></i></div>
                                    <div>
                                        <div class="loc-count">{{ number_format($loc['count']) }}</div>
                                        <div class="loc-label">{{ $loc['label'] }}</div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-xl-4 sidebar-stack">
                    <div class="panel-card">
                        <h5>Quick actions</h5>
                        <a href="{{ route('districts.create') }}" class="quick-link"><i class="fe fe-plus-circle"></i> Add district</a>
                        <a href="{{ route('barrages.create') }}" class="quick-link"><i class="fe fe-plus-circle"></i> Add barrage</a>
                        <a href="{{ route('watercourses.create') }}" class="quick-link"><i class="fe fe-plus-circle"></i> Add watercourse</a>
                        <a href="{{ route('channels.import') }}" class="quick-link"><i class="fe fe-upload"></i> Channel bulk import</a>
                        <a href="{{ route('locations.import') }}" class="quick-link"><i class="fe fe-upload"></i> Location bulk import</a>
                        <a href="{{ route('customers.index') }}" class="quick-link"><i class="fe fe-user"></i> Customer management</a>
                    </div>

                    <div class="panel-card">
                        <h5>Recent districts</h5>
                        @forelse($stats['recent_districts'] as $recent)
                            <div class="activity-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h6 class="fw-bold mb-0 text-success">{{ $recent->name }}</h6>
                                    <small class="text-muted">{{ $recent->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted small mb-0">No districts yet.</p>
                        @endforelse
                    </div>

                    <div class="panel-card">
                        <h5>Recent watercourses</h5>
                        @forelse($stats['recent_watercourses'] as $wc)
                            <div class="activity-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h6 class="fw-bold mb-0" style="color: var(--gov-navy)">{{ $wc->name }}</h6>
                                    <small class="text-muted">{{ $wc->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted small mb-0">No watercourses yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="section-head">
                <h2>Administration irrigation</h2>
                <a href="{{ route('irrigation.import') }}" class="btn btn-sm btn-outline-primary">Bulk import</a>
            </div>
            <div class="d-flex flex-wrap gap-2 mb-4">
                @foreach ($stats['irrigation'] as $irr)
                    <a href="{{ route($irr['route']) }}" class="irr-pill">
                        {{ $irr['label'] }} <strong>{{ number_format($irr['count']) }}</strong>
                    </a>
                @endforeach
            </div>

            <div class="section-head dashboard-analytics">
                <h2>Analytics</h2>
            </div>
            <div class="row g-4 mb-4">
                <div class="col-12">
                    <div class="panel-card">
                        <h5>Hierarchy comparison</h5>
                        <div id="comparison-chart" class="chart-box chart-box--lg"></div>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="panel-card">
                        <h5>Location distribution</h5>
                        <div id="location-chart" class="chart-box chart-box--sm"></div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="panel-card">
                        <h5>Channels distribution</h5>
                        <div id="channels-chart" class="chart-box chart-box--sm"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('JScript')
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.49.1/dist/apexcharts.min.js" crossorigin="anonymous"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof ApexCharts === 'undefined') {
        console.error('ApexCharts failed to load from CDN.');
        return;
    }

    var green = '#006837';
    var navy = '#1a237e';
    var gold = '#c6a34d';
    var staticLocation = [6, 18, 42, 312];
    var staticChannels = [1, 1, 1, 2, 11, 35, 21];

    function renderChart(selector, options) {
        var el = document.querySelector(selector);
        if (!el) {
            return null;
        }
        var chart = new ApexCharts(el, options);
        chart.render();
        return chart;
    }

    renderChart('#location-chart', {
        series: staticLocation,
        chart: { type: 'donut', height: 300, fontFamily: 'inherit' },
        labels: ['District', 'Taluka', 'Tehsil', 'DEH'],
        colors: [green, navy, gold, '#2c3e50'],
        legend: { position: 'bottom', fontSize: '12px' },
        dataLabels: { enabled: true },
        plotOptions: { pie: { donut: { size: '62%' } } },
        tooltip: { y: { formatter: function (v) { return v + ' records'; } } }
    });

    renderChart('#channels-chart', {
        series: [{ name: 'Distinct values', data: staticChannels }],
        chart: { type: 'bar', height: 300, toolbar: { show: false }, fontFamily: 'inherit' },
        plotOptions: { bar: { borderRadius: 6, columnWidth: '55%', distributed: true } },
        dataLabels: { enabled: true, style: { fontSize: '11px', fontWeight: 700 } },
        xaxis: {
            categories: ['Barrage', 'Main', 'Sub', 'Branch', 'Disty', 'Minor', 'WC'],
            labels: { style: { fontSize: '11px' } }
        },
        colors: [green, navy, gold, '#2c3e50', '#00897b', '#6a1b9a', '#004d2a'],
        grid: { borderColor: '#f1f1f1' },
        yaxis: { title: { text: 'Count', style: { fontSize: '11px' } } }
    });

    renderChart('#comparison-chart', {
        series: [
            { name: 'Location hierarchy', data: [6, 18, 42, 312, 0, 0, 0] },
            { name: 'Channels hierarchy', data: staticChannels }
        ],
        chart: { type: 'line', height: 360, toolbar: { show: false }, fontFamily: 'inherit' },
        colors: [green, navy],
        stroke: { curve: 'smooth', width: 3 },
        markers: { size: 5 },
        xaxis: {
            categories: ['Level 1', 'Level 2', 'Level 3', 'Level 4', 'Level 5', 'Level 6', 'Level 7'],
            title: { text: 'District→DEH vs Barrage→WC (static sample)', style: { fontSize: '11px' } }
        },
        legend: { position: 'top' },
        grid: { borderColor: '#f1f1f1' },
        tooltip: { shared: true, intersect: false }
    });
});
</script>
@endsection
