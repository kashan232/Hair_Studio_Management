@extends('layouts.main')

@section('css')
<style>
    .kpi-card {
        background: #fff;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        border: 1px solid #eae2d5;
        transition: transform 0.2s ease;
    }
    .kpi-card:hover {
        transform: translateY(-3px);
    }
    .kpi-card .kpi-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }
    .kpi-value {
        font-size: 2rem;
        font-weight: 700;
        color: #121212;
        margin-bottom: 0.25rem;
    }
    .kpi-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #8c7e6c;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
</style>
@endsection

@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <!-- PAGE-HEADER -->
        <div class="page-header">
            <h1 class="page-title">Advanced Reporting</h1>
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Reports</li>
                </ol>
            </div>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- FILTERS -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex gap-2">
                    <a href="{{ route('reports.index', ['filter' => 'daily']) }}" class="btn btn-sm {{ request('filter') == 'daily' ? 'btn-dark' : 'btn-outline-dark' }}">Daily</a>
                    <a href="{{ route('reports.index', ['filter' => 'weekly']) }}" class="btn btn-sm {{ request('filter') == 'weekly' ? 'btn-dark' : 'btn-outline-dark' }}">Weekly</a>
                    <a href="{{ route('reports.index', ['filter' => 'monthly']) }}" class="btn btn-sm {{ request('filter') == 'monthly' || (!request()->has('filter') && !request()->has('start_date')) ? 'btn-dark' : 'btn-outline-dark' }}">Monthly</a>
                    <a href="{{ route('reports.index', ['filter' => 'yearly']) }}" class="btn btn-sm {{ request('filter') == 'yearly' ? 'btn-dark' : 'btn-outline-dark' }}">Yearly</a>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="card" style="border-radius: 12px; border: 1px solid #eae2d5; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div class="card-body">
                        <form method="GET" action="{{ route('reports.index') }}" class="row align-items-end">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label class="form-label" style="font-size:0.8rem; font-weight:600; color:#8c7e6c; text-transform:uppercase;">From Date</label>
                                <input type="date" name="start_date" class="form-control" value="{{ request('start_date', $startDate->format('Y-m-d')) }}">
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label class="form-label" style="font-size:0.8rem; font-weight:600; color:#8c7e6c; text-transform:uppercase;">To Date</label>
                                <input type="date" name="end_date" class="form-control" value="{{ request('end_date', $endDate->format('Y-m-d')) }}">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn w-100" style="background:#121212; color:#fff; font-weight:600; border-radius:8px; padding:0.6rem;">Generate Report</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPIs -->
        <div class="row mb-4">
            <div class="col-lg-4 col-md-12 mb-4 mb-lg-0">
                <div class="kpi-card">
                    <div class="kpi-icon" style="background: rgba(46, 204, 113, 0.1); color: #2ecc71;">
                        <i class="fe fe-dollar-sign"></i>
                    </div>
                    <div class="kpi-value">£{{ number_format($totalRevenue, 2) }}</div>
                    <div class="kpi-label">Total Revenue</div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 mb-4 mb-lg-0">
                <div class="kpi-card">
                    <div class="kpi-icon" style="background: rgba(52, 152, 219, 0.1); color: #3498db;">
                        <i class="fe fe-calendar"></i>
                    </div>
                    <div class="kpi-value">{{ $totalBookings }}</div>
                    <div class="kpi-label">Total Bookings</div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="kpi-card">
                    <div class="kpi-icon" style="background: rgba(230, 126, 34, 0.1); color: #e67e22;">
                        <i class="fe fe-tag"></i>
                    </div>
                    <div class="kpi-value">£{{ number_format($totalDiscounts, 2) }}</div>
                    <div class="kpi-label">Discounts Given</div>
                </div>
            </div>
        </div>

        <!-- CHART -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card" style="border-radius: 12px; border: 1px solid #eae2d5; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div class="card-header border-bottom-0">
                        <h3 class="card-title">Revenue Trends</h3>
                    </div>
                    <div class="card-body">
                        <div id="revenue-chart"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PREMIUM ANIMATED CHARTS -->
        <div class="row mb-4">
            <!-- Top Customers Column Chart -->
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card h-100" style="border-radius: 12px; border: 1px solid #eae2d5; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div class="card-header border-bottom-0">
                        <h3 class="card-title">Top Customers by Revenue</h3>
                    </div>
                    <div class="card-body">
                        <div id="top-customers-chart"></div>
                    </div>
                </div>
            </div>
            
            <!-- Chair Utilization Bar Chart -->
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card h-100" style="border-radius: 12px; border: 1px solid #eae2d5; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div class="card-header border-bottom-0">
                        <h3 class="card-title">Chair Utilization</h3>
                    </div>
                    <div class="card-body">
                        <div id="chair-utilization-chart"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Booking Status Distribution Donut Chart -->
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card h-100" style="border-radius: 12px; border: 1px solid #eae2d5; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div class="card-header border-bottom-0">
                        <h3 class="card-title">Booking Status Distribution</h3>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <div id="status-distribution-chart" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('JScript')
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.45.1"></script>
<script>
    $(document).ready(function() {

        // Revenue Chart (Clear Bar Chart)
        var trendRevenues = {!! json_encode($trendRevenues) !!}.map(Number);
        var optionsRevenue = {
            series: [{
                name: 'Revenue',
                data: trendRevenues
            }],
            chart: {
                height: 350,
                type: 'bar',
                toolbar: { show: false },
                fontFamily: 'Montserrat, sans-serif'
            },
            colors: ['#2ecc71'],
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    columnWidth: '60%',
                    dataLabels: {
                        position: 'top',
                    },
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function (val) { return val > 0 ? "£" + val : ""; },
                offsetY: -25,
                style: {
                    fontSize: '16px',
                    fontWeight: 700,
                    colors: ["#121212"]
                }
            },
            xaxis: {
                categories: {!! json_encode($trendDates) !!},
                axisBorder: { show: true, color: '#f1ece1' },
                axisTicks: { show: false },
                title: { text: 'Date', style: { color: '#8c7e6c', fontSize: '13px', fontWeight: 600 } }
            },
            yaxis: {
                labels: {
                    formatter: function (value) { return "£" + value; }
                },
                title: { text: 'Revenue Earned', style: { color: '#8c7e6c', fontSize: '13px', fontWeight: 600 } }
            },
            grid: {
                borderColor: '#f1ece1',
                strokeDashArray: 4,
                yaxis: { lines: { show: true } }
            },
            tooltip: {
                theme: 'light',
                y: { formatter: function (val) { return "£" + val; } }
            }
        };
        new ApexCharts(document.querySelector("#revenue-chart"), optionsRevenue).render();

        // Top Customers Chart
        var topCustomersNames = {!! json_encode($topCustomers->pluck('name')) !!};
        var topCustomersSpent = {!! json_encode($topCustomers->pluck('bookings_sum_total_amount')) !!}.map(Number);
        var optionsTopCustomers = {
            series: [{
                name: 'Total Spent',
                data: topCustomersSpent
            }],
            chart: {
                height: 300,
                type: 'bar',
                toolbar: { show: false },
                fontFamily: 'Montserrat, sans-serif'
            },
            colors: ['#121212'],
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    columnWidth: '40%',
                    distributed: true
                }
            },
            dataLabels: { enabled: false },
            legend: { show: false },
            xaxis: {
                categories: topCustomersNames,
                labels: { style: { fontSize: '12px' } }
            },
            yaxis: {
                labels: {
                    formatter: function(val) { return "£" + val; }
                }
            },
            tooltip: {
                theme: 'dark'
            }
        };
        new ApexCharts(document.querySelector("#top-customers-chart"), optionsTopCustomers).render();

        // Chair Utilization Chart
        var chairNames = {!! json_encode($chairUtilization->pluck('name')) !!};
        var chairBookings = {!! json_encode($chairUtilization->pluck('bookings_count')) !!}.map(Number);
        var optionsChairs = {
            series: [{
                name: 'Times Booked',
                data: chairBookings
            }],
            chart: {
                height: 300,
                type: 'bar',
                toolbar: { show: false },
                fontFamily: 'Montserrat, sans-serif'
            },
            colors: ['#3498db', '#9b59b6', '#e74c3c', '#f1c40f', '#1abc9c', '#34495e'],
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: true,
                    distributed: true
                }
            },
            dataLabels: { enabled: true },
            legend: { show: false },
            xaxis: {
                categories: chairNames,
            },
            tooltip: {
                theme: 'light'
            }
        };
        new ApexCharts(document.querySelector("#chair-utilization-chart"), optionsChairs).render();

        // Status Distribution Chart
        var statusKeys = {!! json_encode(array_keys($statusDistribution)) !!};
        var statusValues = {!! json_encode(array_values($statusDistribution)) !!}.map(Number);
        var optionsStatus = {
            series: statusValues,
            chart: {
                height: 300,
                type: 'donut',
                fontFamily: 'Montserrat, sans-serif'
            },
            labels: statusKeys.map(key => key.replace('_', ' ').toUpperCase()),
            colors: ['#2ecc71', '#e74c3c', '#f1c40f', '#3498db', '#95a5a6'],
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: true,
                            name: { show: true },
                            value: { show: true }
                        }
                    }
                }
            },
            dataLabels: { enabled: false },
            legend: {
                position: 'right',
                offsetY: 0,
                height: 230,
            },
            tooltip: {
                theme: 'light'
            }
        };
        new ApexCharts(document.querySelector("#status-distribution-chart"), optionsStatus).render();

    });
</script>
@endsection
