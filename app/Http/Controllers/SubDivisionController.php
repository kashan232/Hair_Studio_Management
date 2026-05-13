<?php

namespace App\Http\Controllers;

use App\Models\SubDivision;
use App\Models\Division;
use App\Models\Circle;
use App\Models\Zone;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubDivisionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SubDivision::with('division.circle.zone')->select('sub_divisions.*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('division_name', function ($row) {
                    return $row->division->name ?? '';
                })
                ->addColumn('circle_name', function ($row) {
                    return $row->division->circle->name ?? '';
                })
                ->addColumn('zone_name', function ($row) {
                    return $row->division->circle->zone->name ?? '';
                })
                ->addColumn('actions', function ($row) {
                    return '<a href="' . route('sub_divisions.edit', $row->id) . '" class="btn btn-primary btn-sm"><i class="ri-edit-box-line"></i></a>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '"><i class="ri-delete-bin-line"></i></button>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('sub_divisions.index');
    }

    public function create()
    {
        $zones = Zone::all();
        return view('sub_divisions.create', compact('zones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'division_id' => 'required',
            'name' => 'required',
        ]);

        SubDivision::create($request->all());

        return response()->json([
            'success' => 'Sub-Division created successfully.',
            'redirect' => route('sub_divisions.index')
        ]);
    }

    public function edit(SubDivision $subDivision)
    {
        $zones = Zone::all();
        $circles = Circle::where('zone_id', $subDivision->division->circle->zone_id)->get();
        $divisions = Division::where('circle_id', $subDivision->division->circle_id)->get();
        
        return view('sub_divisions.create', compact('subDivision', 'zones', 'circles', 'divisions'));
    }

    public function update(Request $request, SubDivision $subDivision)
    {
        $request->validate([
            'division_id' => 'required',
            'name' => 'required',
        ]);

        $subDivision->update($request->all());

        return response()->json([
            'success' => 'Sub-Division updated successfully.',
            'redirect' => route('sub_divisions.index')
        ]);
    }

    public function destroy(SubDivision $subDivision)
    {
        $subDivision->delete();
        return response()->json(['success' => 'Sub-Division deleted successfully.']);
    }

    // AJAX helper for cascading dropdown
    public function getDivisions($circle_id)
    {
        $divisions = Division::where('circle_id', $circle_id)->get();
        return response()->json($divisions);
    }
}
