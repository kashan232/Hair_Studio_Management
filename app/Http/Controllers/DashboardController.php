<?php

namespace App\Http\Controllers;

use App\Models\Deh;
use App\Models\District;
use App\Models\Taluka;
use App\Models\Tehsil;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'districts' => District::count(),
            'talukas' => Taluka::count(),
            'tehsils' => Tehsil::count(),
            'dehs' => Deh::count(),
            'recent_districts' => District::latest()->take(5)->get(['id', 'name', 'created_at']),
            'total_users' => User::count(),
        ];

        return view('index', compact('stats'));
    }
}
