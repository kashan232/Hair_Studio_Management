@extends('layouts.main')

@section('css')
<style>
    :root {
        --salon-gold: #c6a34d;
        --salon-dark-gold: #aa8632;
        --salon-dark: #121212;
        --salon-gray: #1e1e1e;
        --salon-light: #f8f9fa;
        --accent-green: #2ecc71;
        --accent-blue: #3498db;
        --accent-orange: #e67e22;
        --accent-purple: #9b59b6;
    }

    .dashboard-wrap { padding: 0 0 2rem; }

    .dash-hero {
        background: linear-gradient(135deg, #1f1c18 0%, #3a3227 100%);
        border-radius: 16px;
        padding: 2.25rem 2.5rem;
        color: #fff;
        margin-bottom: 2rem;
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
        position: relative;
        overflow: hidden;
        border-left: 5px solid var(--salon-gold);
    }

    .dash-hero::after {
        content: '';
        position: absolute;
        right: -30px;
        top: -30px;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: rgba(198, 163, 77, 0.05);
    }

    .dash-hero h1 {
        font-weight: 800;
        font-size: 1.85rem;
        letter-spacing: 0.5px;
        margin-bottom: 0.35rem;
        color: #fff;
    }

    .dash-hero .subtitle {
        opacity: 0.9;
        font-size: 0.95rem;
        font-weight: 500;
        color: #e0d5c1;
    }

    .kpi-strip .kpi-card {
        background: #fff;
        border-radius: 14px;
        padding: 1.5rem;
        height: 100%;
        border: 1px solid #f1ece1;
        box-shadow: 0 4px 20px rgba(198, 163, 77, 0.05);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .kpi-strip .kpi-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(198, 163, 77, 0.12);
    }

    .kpi-card .kpi-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        margin-bottom: 1rem;
    }

    .kpi-card .kpi-value {
        font-size: 1.85rem;
        font-weight: 800;
        color: var(--salon-dark);
        line-height: 1.1;
    }

    .kpi-card .kpi-label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #8c7e6c;
        margin-top: 0.35rem;
    }

    .panel-card {
        background: #fff;
        border-radius: 14px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        border: 1px solid #f1ece1;
        margin-bottom: 1.5rem;
    }

    .panel-card h5 {
        font-size: 0.85rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: var(--salon-dark-gold);
        margin-bottom: 1.25rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #faf8f5;
    }

    .stylist-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid #faf8f5;
    }

    .stylist-item:last-child {
        border-bottom: none;
    }

    .stylist-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--salon-gold);
    }

    .badge-status {
        font-size: 0.65rem;
        font-weight: 800;
        padding: 0.2rem 0.5rem;
        border-radius: 4px;
    }

    .badge-status.active {
        background: rgba(46, 204, 113, 0.15);
        color: var(--accent-green);
    }

    .badge-status.break {
        background: rgba(230, 126, 34, 0.15);
        color: var(--accent-orange);
    }

    .badge-appt {
        font-size: 0.68rem;
        font-weight: 700;
        padding: 0.25rem 0.6rem;
        border-radius: 50px;
    }

    .badge-appt.completed {
        background: rgba(46, 204, 113, 0.12);
        color: var(--accent-green);
    }

    .badge-appt.progress {
        background: rgba(52, 152, 219, 0.12);
        color: var(--accent-blue);
    }

    .badge-appt.scheduled {
        background: rgba(155, 89, 182, 0.12);
        color: var(--accent-purple);
    }

    .table-responsive {
        border: none;
    }

    .table-appointments th {
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #8c7e6c;
        border-bottom: 2px solid #faf8f5;
        background: #faf8f5;
        padding: 0.75rem 1rem;
    }

    .table-appointments td {
        font-size: 0.85rem;
        padding: 0.85rem 1rem;
        border-bottom: 1px solid #faf8f5;
        vertical-align: middle;
    }

    .table-appointments tr:hover td {
        background: #fffdf9;
    }

    .quick-action-btn {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        background: #faf8f5;
        border: 1px solid #f1ece1;
        border-radius: 8px;
        color: var(--salon-dark);
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.2s;
        margin-bottom: 0.5rem;
    }

    .quick-action-btn:hover {
        background: var(--salon-gold);
        color: #fff;
        border-color: var(--salon-gold);
        transform: translateX(3px);
    }

    .quick-action-btn i {
        font-size: 1.1rem;
    }

    .chart-box {
        position: relative;
        width: 100%;
        min-height: 320px;
    }
</style>
@endsection

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid dashboard-wrap">

            <!-- Hero Welcome Card -->
            <div class="dash-hero">
                <div class="row align-items-center position-relative" style="z-index: 1">
                    <div class="col-md-8">
                        <h1>Welcome to Hair Studio</h1>
                        <p class="subtitle mb-2">Manage appointments, stylists, services, and check real-time business performance.</p>
                        <span class="badge px-3 py-2" style="background: var(--salon-gold); color: #fff; font-weight: 600; letter-spacing: 0.5px;">PREMIUM SALON PORTAL</span>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <p class="mb-1 small opacity-75">Today's Estimated Revenue</p>
                        <p class="mb-0 display-6 fw-bold" style="color: #fff;">Rs. {{ number_format($stats['today_revenue']) }}</p>
                        <p class="small opacity-75 mb-0">From {{ $stats['today_appointments'] }} bookings</p>
                    </div>
                </div>
            </div>

            <!-- Stats KPI Strip -->
            <div class="row g-3 kpi-strip mb-4">
                <div class="col-sm-6 col-xl-3">
                    <div class="kpi-card">
                        <div class="kpi-icon" style="background: rgba(198,163,77,0.1); color: var(--salon-gold);">
                            <i class="fe fe-calendar"></i>
                        </div>
                        <div class="kpi-value">{{ $stats['today_appointments'] }}</div>
                        <div class="kpi-label">Today's Appointments</div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="kpi-card">
                        <div class="kpi-icon" style="background: rgba(46,204,113,0.1); color: var(--accent-green);">
                            <i class="fe fe-scissors"></i>
                        </div>
                        <div class="kpi-value">{{ $stats['active_stylists'] }}</div>
                        <div class="kpi-label">Active Stylists</div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="kpi-card">
                        <div class="kpi-icon" style="background: rgba(52,152,219,0.1); color: var(--accent-blue);">
                            <i class="fe fe-users"></i>
                        </div>
                        <div class="kpi-value">{{ $stats['total_customers'] }}</div>
                        <div class="kpi-label">Total Customers</div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="kpi-card">
                        <div class="kpi-icon" style="background: rgba(155,89,182,0.1); color: var(--accent-purple);">
                            <i class="fe fe-user-check"></i>
                        </div>
                        <div class="kpi-value">{{ $stats['total_users'] }}</div>
                        <div class="kpi-label">Portal Admin Accounts</div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="row g-4 mb-4">
                <div class="col-xl-8">
                    <div class="panel-card">
                        <h5>Weekly Revenue Analytics (PKR)</h5>
                        <div id="revenue-chart" class="chart-box"></div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="panel-card">
                        <h5>Popular Services Breakdown</h5>
                        <div id="services-chart" class="chart-box" style="min-height: 320px;"></div>
                    </div>
                </div>
            </div>

            <!-- Schedule and Sidebar Info -->
            <div class="row g-4">
                <!-- Appointment Schedule -->
                <div class="col-xl-8">
                    <div class="panel-card">
                        <h5>Today's Appointment Schedule</h5>
                        <div class="table-responsive">
                            <table class="table table-appointments mb-0">
                                <thead>
                                    <tr>
                                        <th>Time</th>
                                        <th>Customer</th>
                                        <th>Service Required</th>
                                        <th>Stylist assigned</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stats['appointments'] as $appt)
                                        <tr>
                                            <td class="fw-bold" style="color: var(--salon-dark-gold);">{{ $appt['time'] }}</td>
                                            <td class="fw-semibold">{{ $appt['customer'] }}</td>
                                            <td>{{ $appt['service'] }}</td>
                                            <td>{{ $appt['stylist'] }}</td>
                                            <td class="fw-bold">Rs. {{ number_format($appt['price']) }}</td>
                                            <td>
                                                @if($appt['status'] == 'Completed')
                                                    <span class="badge-appt completed">{{ $appt['status'] }}</span>
                                                @elseif($appt['status'] == 'In Progress')
                                                    <span class="badge-appt progress">{{ $appt['status'] }}</span>
                                                @else
                                                    <span class="badge-appt scheduled">{{ $appt['status'] }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar Details -->
                <div class="col-xl-4">
                    <!-- Quick Actions -->
                    <div class="panel-card">
                        <h5>Quick Actions</h5>
                        <a href="javascript:void(0)" class="quick-action-btn"><i class="fe fe-plus-circle"></i> Book New Appointment</a>
                        <a href="javascript:void(0)" class="quick-action-btn"><i class="fe fe-user-plus"></i> Add Salon Customer</a>
                        <a href="javascript:void(0)" class="quick-action-btn"><i class="fe fe-scissors"></i> Manage Salon Services</a>
                        <a href="javascript:void(0)" class="quick-action-btn"><i class="fe fe-settings"></i> Edit Salon Settings</a>
                    </div>

                    <!-- Stylists Roster -->
                    <div class="panel-card">
                        <h5>Stylists on Duty</h5>
                        @foreach($stats['stylists'] as $stylist)
                            <div class="stylist-item">
                                <img src="{{ $stylist['avatar'] }}" class="stylist-avatar" alt="{{ $stylist['name'] }}">
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark">{{ $stylist['name'] }}</h6>
                                    <small class="text-muted">{{ $stylist['role'] }}</small>
                                </div>
                                <div class="ms-auto">
                                    @if($stylist['status'] == 'Active')
                                        <span class="badge-status active">Active</span>
                                    @else
                                        <span class="badge-status break">On Break</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
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
        console.error('ApexCharts failed to load.');
        return;
    }

    var gold = '#c6a34d';
    var darkGold = '#aa8632';
    var dark = '#121212';

    // Revenue Spline Chart
    var revenueOptions = {
        series: [{
            name: 'Daily Revenue',
            data: @json($stats['revenue_chart']['data'])
        }],
        chart: {
            type: 'area',
            height: 320,
            toolbar: { show: false },
            fontFamily: 'inherit'
        },
        colors: [gold],
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 3 },
        xaxis: {
            categories: @json($stats['revenue_chart']['categories']),
            labels: { style: { colors: '#8c7e6c', fontWeight: 600 } }
        },
        yaxis: {
            labels: {
                formatter: function (value) { return 'Rs. ' + value.toLocaleString(); },
                style: { colors: '#8c7e6c', fontWeight: 600 }
            }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.45,
                opacityTo: 0.05,
                stops: [0, 90, 100]
            }
        },
        grid: { borderColor: '#f9f6f0' },
        tooltip: {
            y: { formatter: function (val) { return 'Rs. ' + val.toLocaleString(); } }
        }
    };

    var revenueChart = new ApexCharts(document.querySelector("#revenue-chart"), revenueOptions);
    revenueChart.render();

    // Services Donut Chart
    var servicesOptions = {
        series: @json($stats['services_chart']['data']),
        chart: {
            type: 'donut',
            height: 320,
            fontFamily: 'inherit'
        },
        labels: @json($stats['services_chart']['labels']),
        colors: [gold, '#3498db', '#2ecc71', '#e67e22', '#9b59b6'],
        legend: { position: 'bottom', fontSize: '11px', labels: { colors: '#8c7e6c' } },
        dataLabels: { enabled: true },
        plotOptions: {
            pie: {
                donut: {
                    size: '65%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Services Done',
                            color: '#8c7e6c',
                            formatter: function (w) {
                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0) + '%';
                            }
                        }
                    }
                }
            }
        },
        tooltip: {
            y: { formatter: function (val) { return val + '% of all services'; } }
        }
    };

    var servicesChart = new ApexCharts(document.querySelector("#services-chart"), servicesOptions);
    servicesChart.render();
});
</script>
@endsection
