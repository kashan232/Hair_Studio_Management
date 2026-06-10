<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        // Premium Hair Studio Dashboard Stats
        $today_appointments = Booking::whereDate('start_datetime', $today)->count();
        $today_revenue = Booking::whereDate('start_datetime', $today)
            ->whereIn('status', ['confirmed', 'completed'])
            ->sum('total_amount');
            
        $active_stylists = User::where(function($q) {
            $q->where('role', 'hairstylist')
              ->orWhereHas('roleRelation', function($query) {
                  $query->where('slug', 'hairstylist');
              });
        })->count();
        
        $total_customers = User::where(function($q) {
            $q->whereNotIn('role', ['admin', 'hairstylist'])
              ->whereDoesntHave('roleRelation', function($query) {
                  $query->whereIn('slug', ['admin', 'hairstylist']);
              });
        })->count();

        $stats = [
            'today_appointments' => $today_appointments,
            'active_stylists' => $active_stylists,
            'today_revenue' => $today_revenue,
            'total_customers' => $total_customers,
            'total_users' => User::count(),
            
            // Stylists info
            'stylists' => User::where(function($q) {
                $q->where('role', 'hairstylist')
                  ->orWhereHas('roleRelation', function($query) {
                      $query->where('slug', 'hairstylist');
                  });
            })->take(4)->get()->map(function($user) {
                return [
                    'name' => $user->name,
                    'role' => 'Stylist',
                    'status' => 'Active',
                    'avatar' => 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=c6a34d&color=fff'
                ];
            })->toArray(),

            // Today's appointments schedule
            'appointments' => Booking::with(['user', 'chairs'])
                ->whereDate('start_datetime', $today)
                ->orderBy('start_datetime')
                ->take(6)->get()->map(function($b) {
                    return [
                        'time' => Carbon::parse($b->start_datetime)->format('h:i A'),
                        'customer' => $b->user ? $b->user->name : 'Guest',
                        'service' => $b->chairs->pluck('name')->implode(', '),
                        'stylist' => 'N/A', // Update if bookings have specific stylists assigned
                        'price' => $b->total_amount,
                        'status' => ucfirst(str_replace('_', ' ', $b->status))
                    ];
                })->toArray(),

            // Services distribution (for chart) - static for now or can be derived from chairs booked
            'services_chart' => [
                'labels' => ['Haircut & Beard', 'Hair Coloring', 'Treatments', 'Hair Styling', 'Spa & Massage'],
                'data' => [45, 25, 15, 10, 5],
            ],

            // Revenue chart (weekly) - Calculate last 7 days revenue
            'revenue_chart' => $this->getWeeklyRevenue(),
        ];

        return view('index', compact('stats'));
    }
    
    private function getWeeklyRevenue()
    {
        $categories = [];
        $data = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $categories[] = $date->format('D');
            $data[] = Booking::whereDate('start_datetime', $date)
                ->whereIn('status', ['confirmed', 'completed'])
                ->sum('total_amount');
        }
        
        return [
            'categories' => $categories,
            'data' => $data
        ];
    }
}
