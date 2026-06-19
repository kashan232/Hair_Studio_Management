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
            
            // Stylists info (Dynamic status based on active confirmed bookings today)
            'stylists' => User::where(function($q) {
                $q->where('role', 'hairstylist')
                  ->orWhereHas('roleRelation', function($query) {
                      $query->where('slug', 'hairstylist');
                  });
            })->with(['bookings' => function($q) use ($today) {
                $q->whereDate('start_datetime', $today)->where('status', 'confirmed');
            }])->get()->map(function($user) {
                $now = now();
                $isActive = $user->bookings->contains(function($booking) use ($now) {
                    return $now->between(Carbon::parse($booking->start_datetime), Carbon::parse($booking->end_datetime));
                });

                return [
                    'name' => $user->name,
                    'role' => 'Stylist',
                    'status' => $isActive ? 'Active' : 'On Break',
                    'avatar' => 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=c6a34d&color=fff'
                ];
            })->sortByDesc(function($stylist) {
                return $stylist['status'] === 'Active' ? 1 : 0;
            })->take(4)->values()->toArray(),

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
