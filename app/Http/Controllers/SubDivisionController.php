<?php

namespace App\Http\Controllers;

use App\Models\SubDivision;
use App\Models\IrrigationDivision;
use App\Models\Circle;
use App\Models\Region;
use App\Models\Unit;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubDivisionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SubDivision::with('irrigationDivision.circle.region.unit')->select('sub_divisions.*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('irrigation_division_name', function ($row) {
                    return $row->irrigationDivision->name ?? '';
                })
                ->addColumn('circle_name', function ($row) {
                    return $row->irrigationDivision->circle->name ?? '';
                })
                ->addColumn('region_name', function ($row) {
                    return $row->irrigationDivision->circle->region->name ?? '';
                })
                ->addColumn('unit_name', function ($row) {
                    return $row->irrigationDivision->circle->region->unit->name ?? '';
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
        $units = Unit::all();
        return view('sub_divisions.create', compact('units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'irrigation_division_id' => 'required',
            'name' => 'required',
        ]);

        SubDivision::create($request->all());

        return response()->json([
            'success' => 'Sub-Division created successfully.',
            'redirect' => route('sub_divisions.index')
        ]);
    }

    public function edit($id)
    {
        $sub_division = SubDivision::findOrFail($id);
        $units = Unit::all();
        $regions = Region::where('unit_id', $sub_division->irrigationDivision->circle->region->unit_id)->get();
        $circles = Circle::where('region_id', $sub_division->irrigationDivision->circle->region_id)->get();
        $irrigation_divisions = IrrigationDivision::where('circle_id', $sub_division->irrigation_division_id)->get();
        
        return view('sub_divisions.create', compact('sub_division', 'units', 'regions', 'circles', 'irrigation_divisions'));
    }

    public function update(Request $request, $id)
    {
        $sub_division = SubDivision::findOrFail($id);
        $request->validate([
            'irrigation_division_id' => 'required',
            'name' => 'required',
        ]);

        $sub_division->update($request->all());

        return response()->json([
            'success' => 'Sub-Division updated successfully.',
            'redirect' => route('sub_divisions.index')
        ]);
    }

    public function destroy($id)
    {
        $sub_division = SubDivision::findOrFail($id);
        $sub_division->delete();
        return response()->json(['success' => 'Sub-Division deleted successfully.']);
    }

    public function getSubDivisions($irrigation_division_id)
    {
        $sub_divisions = SubDivision::where('irrigation_division_id', $irrigation_division_id)->get();
        return response()->json($sub_divisions);
    }
}
