<?php

namespace App\Http\Controllers;

use App\Models\Barrage;
use App\Models\BranchCanal;
use App\Models\Circle;
use App\Models\Deh;
use App\Models\Distributary;
use App\Models\Division;
use App\Models\District;
use App\Models\MainCanal;
use App\Models\Minor;
use App\Models\SubCanal;
use App\Models\SubDivision;
use App\Models\Taluka;
use App\Models\Tehsil;
use App\Models\User;
use App\Models\Watercourse;

class DashboardController extends Controller
{
    public function index()
    {
        $locationTotal = District::count() + Taluka::count() + Tehsil::count() + Deh::count();
        $channelTotal = Barrage::count() + MainCanal::count() + SubCanal::count()
            + BranchCanal::count() + Distributary::count() + Minor::count() + Watercourse::count();
        $irrigationTotal = Circle::count() + Division::count() + SubDivision::count();

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
            'circles' => Circle::count(),
            'divisions' => Division::count(),
            'sub_divisions' => SubDivision::count(),
            'location_total' => $locationTotal,
            'channel_total' => $channelTotal,
            'irrigation_total' => $irrigationTotal,
            'grand_total' => $locationTotal + $channelTotal + $irrigationTotal,
            'recent_districts' => District::latest()->take(5)->get(['id', 'name', 'created_at']),
            'recent_watercourses' => Watercourse::latest()->take(5)->get(['id', 'name', 'created_at']),
            'recent_barrages' => Barrage::latest()->take(3)->get(['id', 'name', 'created_at']),
            'total_users' => User::count(),
        ];

        $stats['channels'] = [
            ['key' => 'barrage', 'label' => 'Distinct Barrage', 'badge' => 'BARRAGE', 'count' => $stats['barrages'], 'hint' => 'Unique barrage values', 'route' => 'barrages.index', 'accent' => '#006837'],
            ['key' => 'main', 'label' => 'Distinct Main Canal', 'badge' => 'MAIN', 'count' => $stats['main_canals'], 'hint' => 'Unique main canal values', 'route' => 'main-canals.index', 'accent' => '#1a237e'],
            ['key' => 'sub', 'label' => 'Distinct Sub Canal', 'badge' => 'SUB', 'count' => $stats['sub_canals'], 'hint' => 'Unique sub canal values', 'route' => 'sub-canals.index', 'accent' => '#c6a34d'],
            ['key' => 'branch', 'label' => 'Distinct Branch Canal', 'badge' => 'BRANCH', 'count' => $stats['branch_canals'], 'hint' => 'Unique branch canal values', 'route' => 'branch-canals.index', 'accent' => '#2c3e50'],
            ['key' => 'dist', 'label' => 'Distinct Distributary', 'badge' => 'DISTRY', 'count' => $stats['distributaries'], 'hint' => 'Unique distributary values', 'route' => 'distributaries.index', 'accent' => '#00897b'],
            ['key' => 'minor', 'label' => 'Distinct Minor', 'badge' => 'MINOR', 'count' => $stats['minors'], 'hint' => 'Unique minor values', 'route' => 'minors.index', 'accent' => '#6a1b9a'],
            ['key' => 'wc', 'label' => 'WC No', 'badge' => 'WC', 'count' => $stats['watercourses'], 'hint' => 'Unique WC No values', 'route' => 'watercourses.index', 'accent' => '#004d2a'],
        ];

        $stats['locations'] = [
            ['label' => 'Districts', 'count' => $stats['districts'], 'route' => 'districts.index', 'icon' => 'fe-map-pin'],
            ['label' => 'Talukas', 'count' => $stats['talukas'], 'route' => 'talukas.index', 'icon' => 'fe-map'],
            ['label' => 'Tehsils', 'count' => $stats['tehsils'], 'route' => 'tehsils.index', 'icon' => 'fe-layers'],
            ['label' => 'DEHs', 'count' => $stats['dehs'], 'route' => 'dehs.index', 'icon' => 'fe-grid'],
        ];

        $stats['irrigation'] = [
            ['label' => 'Circles', 'count' => $stats['circles'], 'route' => 'circles.index'],
            ['label' => 'Divisions', 'count' => $stats['divisions'], 'route' => 'divisions.index'],
            ['label' => 'Sub Divisions', 'count' => $stats['sub_divisions'], 'route' => 'sub-divisions.index'],
        ];

        return view('index', compact('stats'));
    }
}
