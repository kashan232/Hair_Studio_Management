<?php

namespace App\Http\Controllers;

use App\Models\Barrage;
use App\Models\BranchCanal;
use App\Models\Deh;
use App\Models\Distributary;
use App\Models\District;
use App\Models\MainCanal;
use App\Models\Minor;
use App\Models\SubCanal;
use App\Models\Taluka;
use App\Models\Tehsil;
use App\Models\User;
use App\Models\Watercourse;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'districts' => District::count(),
            'talukas' => Taluka::count(),
            'tehsils' => Tehsil::count(),
            'dehs' => Deh::count(),
            'barrages' => Barrage::count(),
            'main_canals' => MainCanal::count(),
            'sub_canals' => SubCanal::count(),
            'branch_canals' => BranchCanal::count(),
            'distributaries' => Distributary::count(),
            'minors' => Minor::count(),
            'watercourses' => Watercourse::count(),
            'recent_districts' => District::latest()->take(5)->get(['id', 'name', 'created_at']),
            'total_users' => User::count(),
        ];

        return view('index', compact('stats'));
    }
}
