<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Region;
use App\Models\Circle;
use App\Models\IrrigationDivision;
use App\Models\SubDivision;
use App\Models\Beat;
use App\Models\RevenueDivision;
use App\Models\District;
use App\Models\Taluka;
use App\Models\RevenueCircle;
use App\Models\Tappa;
use App\Models\Deh;
use App\Models\SurveyNumber;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'irrigation' => [
                'units' => Unit::count(),
                'regions' => Region::count(),
                'circles' => Circle::count(),
                'divisions' => IrrigationDivision::count(),
                'sub_divisions' => SubDivision::count(),
                'beats' => Beat::count(),
            ],
            'revenue' => [
                'divisions' => RevenueDivision::count(),
                'districts' => District::count(),
                'talukas' => Taluka::count(),
                'circles' => RevenueCircle::count(),
                'tappas' => Tappa::count(),
                'dehs' => Deh::count(),
                'survey_numbers' => SurveyNumber::count(),
            ],
            'total_users' => \App\Models\User::count(),
            'recent_units' => Unit::latest()->take(3)->get()
        ];

        return view('index', compact('stats'));
    }
}
