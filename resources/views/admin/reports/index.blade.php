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

        <!-- TABLES -->
        <div class="row">
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card h-100" style="border-radius: 12px; border: 1px solid #eae2d5; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div class="card-header border-bottom-0">
                        <h3 class="card-title">Top Customers</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap border-bottom datatable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Bookings</th>
                                        <th>Spent</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topCustomers as $customer)
                                    <tr>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->bookings_count }}</td>
                                        <td class="text-success font-weight-bold">£{{ number_format($customer->bookings_sum_total_amount, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card h-100" style="border-radius: 12px; border: 1px solid #eae2d5; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div class="card-header border-bottom-0">
                        <h3 class="card-title">Chair Utilization</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap border-bottom datatable">
                                <thead>
                                    <tr>
                                        <th>Chair</th>
                                        <th>Times Booked</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($chairUtilization as $chair)
                                    <tr>
                                        <td>{{ $chair->name }}</td>
                                        <td><span class="badge bg-primary rounded-pill">{{ $chair->bookings_count }}</span></td>
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
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    $(document).ready(function() {
        $('.datatable').DataTable({
            "pageLength": 5,
            "lengthChange": false,
            "language": {
                "search": "",
                "searchPlaceholder": "Search...",
                "paginate": {
                    "next": '<i class="fe fe-chevron-right"></i>',
                    "previous": '<i class="fe fe-chevron-left"></i>'
                }
            }
        });

        // Revenue Chart
        var options = {
            series: [{
                name: 'Revenue',
                data: {!! json_encode($trendRevenues) !!}
            }],
            chart: {
                height: 350,
                type: 'area',
                toolbar: { show: false },
                fontFamily: 'Montserrat, sans-serif'
            },
            colors: ['#c6a34d'],
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 2 },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.05,
                    stops: [0, 90, 100]
                }
            },
            xaxis: {
                categories: {!! json_encode($trendDates) !!},
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: {
                    formatter: function (value) { return "£" + value; }
                }
            },
            grid: {
                borderColor: '#f1ece1',
                strokeDashArray: 4,
            }
        };

        var chart = new ApexCharts(document.querySelector("#revenue-chart"), options);
        chart.render();
    });
</script>
@endsection
