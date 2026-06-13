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
        $filter = $request->input('filter');
        if ($filter) {
            $endDate = Carbon::today()->endOfDay();
            if ($filter === 'daily') {
                $startDate = Carbon::today()->startOfDay();
            } elseif ($filter === 'weekly') {
                $startDate = Carbon::today()->subDays(6)->startOfDay();
            } elseif ($filter === 'monthly') {
                $startDate = Carbon::today()->subDays(29)->startOfDay();
            } elseif ($filter === 'yearly') {
                $startDate = Carbon::today()->subDays(364)->startOfDay();
            } else {
                $startDate = Carbon::today()->subDays(29)->startOfDay();
            }
        } else {
            $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : Carbon::today()->subDays(29)->startOfDay();
            $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : Carbon::today()->endOfDay();
        }

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
        ->pluck('revenue', 'date')
        ->toArray();

        $trendDates = [];
        $trendRevenues = [];

        // Generate all dates in the range
        $currentDate = $startDate->copy()->startOfDay();
        $end = $endDate->copy()->startOfDay();

        while ($currentDate->lte($end)) {
            $dateString = $currentDate->format('Y-m-d');
            $trendDates[] = $currentDate->format('M d');
            // If we have revenue for this date, use it, else 0
            $trendRevenues[] = isset($revenueTrends[$dateString]) ? (float) $revenueTrends[$dateString] : 0.0;
            
            $currentDate->addDay();
        }

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

        // 6. Peak Hours
        $peakHoursData = Booking::select(DB::raw('HOUR(start_datetime) as hour'), DB::raw('count(*) as count'))
            ->whereBetween('start_datetime', [$startDate, $endDate])
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();
            
        $peakHours = [];
        foreach($peakHoursData as $row) {
            $amPm = Carbon::createFromTime($row->hour, 0, 0)->format('g A');
            $peakHours[$amPm] = $row->count;
        }

        // 7. Common Durations
        $commonDurationsData = Booking::select('duration_hours', DB::raw('count(*) as count'))
            ->whereBetween('start_datetime', [$startDate, $endDate])
            ->groupBy('duration_hours')
            ->orderBy('duration_hours')
            ->get();
            
        $commonDurations = [];
        foreach($commonDurationsData as $row) {
            $commonDurations[$row->duration_hours . ' Hours'] = $row->count;
        }

        return view('admin.reports.index', compact(
            'startDate', 'endDate', 'totalBookings', 'totalRevenue', 'totalDiscounts',
            'trendDates', 'trendRevenues', 'topCustomers', 'chairUtilization', 'statusDistribution',
            'peakHours', 'commonDurations'
        ));
    }
}
