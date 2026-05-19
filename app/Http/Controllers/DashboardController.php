<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Premium Hair Studio Dashboard Stats
        $stats = [
            'today_appointments' => 18,
            'active_stylists' => 6,
            'today_revenue' => 45800,
            'total_customers' => 342,
            'total_users' => User::count(),
            
            // Stylists info
            'stylists' => [
                ['name' => 'Aisha Khan', 'role' => 'Master Stylist', 'status' => 'Active', 'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150'],
                ['name' => 'Zain Ahmed', 'role' => 'Senior Hair Artist', 'status' => 'Active', 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150'],
                ['name' => 'Sara Ali', 'role' => 'Color Specialist', 'status' => 'On Break', 'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150'],
                ['name' => 'Bilal Mustafa', 'role' => 'Barber Expert', 'status' => 'Active', 'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150'],
            ],

            // Today's appointments schedule
            'appointments' => [
                ['time' => '10:00 AM', 'customer' => 'Mariam Saeed', 'service' => 'Balayage & Haircut', 'stylist' => 'Aisha Khan', 'price' => 12500, 'status' => 'Completed'],
                ['time' => '11:30 AM', 'customer' => 'Hamza Lodhi', 'service' => 'Classic Beard Trim', 'stylist' => 'Bilal Mustafa', 'price' => 3500, 'status' => 'Completed'],
                ['time' => '01:00 PM', 'customer' => 'Kinza Bashir', 'service' => 'Deep Conditioning Spa', 'stylist' => 'Sara Ali', 'price' => 6000, 'status' => 'In Progress'],
                ['time' => '02:30 PM', 'customer' => 'Daniyal Shah', 'service' => 'Gentleman Haircut', 'stylist' => 'Zain Ahmed', 'price' => 4000, 'status' => 'Scheduled'],
                ['time' => '04:00 PM', 'customer' => 'Sana Malik', 'service' => 'Global Color & Styling', 'stylist' => 'Aisha Khan', 'price' => 15000, 'status' => 'Scheduled'],
                ['time' => '05:30 PM', 'customer' => 'Omar Farooq', 'service' => 'Keratin Treatment', 'stylist' => 'Zain Ahmed', 'price' => 18000, 'status' => 'Scheduled'],
            ],

            // Services distribution (for chart)
            'services_chart' => [
                'labels' => ['Haircut & Beard', 'Hair Coloring', 'Treatments', 'Hair Styling', 'Spa & Massage'],
                'data' => [45, 25, 15, 10, 5],
            ],

            // Revenue chart (weekly)
            'revenue_chart' => [
                'categories' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                'data' => [32000, 48000, 41000, 55000, 68000, 85000, 72000],
            ]
        ];

        return view('index', compact('stats'));
    }
}
