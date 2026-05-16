@extends('layouts.main')

@section('css')
<style>
    :root {
        --gov-green: #006837;
        --gov-dark-green: #004d2a;
        --gov-gold: #c6a34d;
        --gov-navy: #1a237e;
        --executive-blue: #2c3e50;
    }

    .dashboard-container { padding: 20px 0; }

    .main-heading {
        text-align: center;
        margin-bottom: 40px;
    }

    .main-heading h1 {
        font-weight: 800;
        color: var(--gov-dark-green);
        text-transform: uppercase;
        margin-bottom: 5px;
        letter-spacing: 1.5px;
        font-size: 2.2rem;
    }

    .main-heading h2 {
        font-weight: 600;
        color: var(--gov-navy);
        text-transform: uppercase;
        font-size: 1.2rem;
        letter-spacing: 1px;
    }

    .card-dashboard {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        border-radius: 8px;
        border: none;
        border-top: 4px solid var(--gov-green);
        background: #ffffff;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        padding: 25px;
        transition: all 0.3s ease;
    }

    .card-dashboard:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    }

    .card-navy { border-top-color: var(--gov-navy); }
    .card-gold { border-top-color: var(--gov-gold); }
    .card-dark { border-top-color: var(--executive-blue); background: var(--executive-blue); color: white; }

    .stat-title {
        font-size: 0.75rem;
        font-weight: 800;
        color: #7f8c8d;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        margin-bottom: 10px;
    }

    .card-dark .stat-title { color: #bdc3c7; }

    .stat-number {
        font-size: 2.2rem;
        font-weight: 900;
        color: #2c3e50;
        line-height: 1;
    }

    .card-dark .stat-number { color: white; }

    .section-divider {
        text-align: center;
        margin: 50px 0 30px;
        position: relative;
    }

    .section-divider span {
        background: #f4f7f6;
        padding: 0 20px;
        font-weight: 800;
        color: var(--gov-dark-green);
        text-transform: uppercase;
        letter-spacing: 2px;
        position: relative;
        z-index: 1;
    }

    .section-divider::after {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        width: 100%;
        height: 2px;
        background: #e0e0e0;
        z-index: 0;
    }

    .activity-log {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.03);
    }
</style>
@endsection

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid dashboard-container">
            <div class="main-heading">
                <h1>Nara Canal Area Water Board</h1>
                <h2>Sindh Irrigation And Drainage Authority</h2>
                <div class="mt-2">
                    <span class="badge bg-success text-white px-3">Government of Sindh</span>
                </div>
            </div>

            <div class="section-divider">
                <span>Location hierarchy</span>
            </div>

            <div class="row row-cards">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card-dashboard">
                        <div class="stat-title">Districts</div>
                        <div class="stat-number">{{ $stats['districts'] }}</div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card-dashboard card-navy">
                        <div class="stat-title">Talukas</div>
                        <div class="stat-number">{{ $stats['talukas'] }}</div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card-dashboard card-gold">
                        <div class="stat-title">Tehsils</div>
                        <div class="stat-number">{{ $stats['tehsils'] }}</div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card-dashboard card-dark">
                        <div class="stat-title">DEHs</div>
                        <div class="stat-number">{{ $stats['dehs'] }}</div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-xl-8 mb-4">
                    <div class="bg-white p-4 rounded-3 shadow-sm">
                        <h5 class="fw-bold mb-4 text-uppercase">Hierarchy distribution</h5>
                        <div id="hierarchy-chart" style="height: 380px;"></div>
                    </div>
                </div>
                <div class="col-xl-4 mb-4">
                    <div class="activity-log h-100">
                        <h5 class="fw-bold mb-4 border-bottom pb-2 text-uppercase">Recent districts</h5>
                        <div class="activity-feed">
                            @forelse($stats['recent_districts'] as $recent)
                                <div class="mb-4 pb-2 border-bottom border-light">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="fw-bold mb-0 text-success">{{ $recent->name }}</h6>
                                        <small class="text-muted">{{ $recent->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="text-muted small mb-0">District master record updated.</p>
                                </div>
                            @empty
                                <p class="text-center text-muted">No districts yet.</p>
                            @endforelse

                            <div class="mt-5 text-center">
                                <h3 class="fw-black mb-0">{{ $stats['total_users'] }}</h3>
                                <div class="stat-title">Authorized personnel</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('JScript')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var options = {
        series: [{
            name: 'Records',
            data: [{{ $stats['districts'] }}, {{ $stats['talukas'] }}, {{ $stats['tehsils'] }}, {{ $stats['dehs'] }}]
        }],
        chart: {
            type: 'area',
            height: 380,
            toolbar: { show: false },
            fontFamily: 'Inter, sans-serif'
        },
        colors: ['#006837'],
        dataLabels: { enabled: false },
        stroke: { curve: 'straight', width: 2 },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.3,
                opacityTo: 0.05,
                stops: [0, 90, 100]
            }
        },
        xaxis: {
            categories: ['District', 'Taluka', 'Tehsil', 'DEH'],
        },
        yaxis: { labels: { style: { colors: '#8e8da4' } } },
        grid: { borderColor: '#f1f1f1' },
    };

    var chart = new ApexCharts(document.querySelector("#hierarchy-chart"), options);
    chart.render();
</script>
@endsection
