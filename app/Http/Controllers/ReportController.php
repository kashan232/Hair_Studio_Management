<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Models\Chair;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Default date range: Last 30 days
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : Carbon::today()->subDays(29)->startOfDay();
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : Carbon::today()->endOfDay();

        // 1. Core Metrics
        $totalBookings = Booking::whereBetween('start_datetime', [$startDate, $endDate])->count();
        
        $totalRevenue = Booking::whereBetween('start_datetime', [$startDate, $endDate])
            ->whereIn('status', ['confirmed', 'completed'])
            ->sum('total_amount');
            
        $totalDiscounts = Booking::whereBetween('start_datetime', [$startDate, $endDate])
            ->whereNotNull('coupon_code')
            ->sum('discount_amount');

        // 2. Revenue Trends (Grouped by Date)
        $revenueTrends = Booking::select(
            DB::raw('DATE(start_datetime) as date'),
            DB::raw('SUM(total_amount) as revenue')
        )
        ->whereBetween('start_datetime', [$startDate, $endDate])
        ->whereIn('status', ['confirmed', 'completed'])
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        $trendDates = $revenueTrends->pluck('date')->map(function($date) {
            return Carbon::parse($date)->format('M d');
        })->toArray();
        $trendRevenues = $revenueTrends->pluck('revenue')->toArray();

        // 3. Top Stylists (Customers) - Since the system currently doesn't link stylist to booking directly,
        // we'll show Top Customers who made the most bookings/revenue in this period.
        $topCustomers = User::whereHas('bookings', function($q) use ($startDate, $endDate) {
                $q->whereBetween('start_datetime', [$startDate, $endDate]);
            })
            ->withCount(['bookings' => function($q) use ($startDate, $endDate) {
                $q->whereBetween('start_datetime', [$startDate, $endDate]);
            }])
            ->withSum(['bookings' => function($q) use ($startDate, $endDate) {
                $q->whereBetween('start_datetime', [$startDate, $endDate])->whereIn('status', ['confirmed', 'completed']);
            }], 'total_amount')
            ->orderByDesc('bookings_sum_total_amount')
            ->take(10)
            ->get();

        // 4. Chair Utilization
        $chairUtilization = Chair::withCount(['bookings' => function($q) use ($startDate, $endDate) {
                $q->whereBetween('start_datetime', [$startDate, $endDate]);
            }])
            ->orderByDesc('bookings_count')
            ->get();

        // 5. Booking Status Distribution
        $statusDistribution = Booking::select('status', DB::raw('count(*) as count'))
            ->whereBetween('start_datetime', [$startDate, $endDate])
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        return view('admin.reports.index', compact(
            'startDate', 'endDate', 'totalBookings', 'totalRevenue', 'totalDiscounts',
            'trendDates', 'trendRevenues', 'topCustomers', 'chairUtilization', 'statusDistribution'
        ));
    }
}
