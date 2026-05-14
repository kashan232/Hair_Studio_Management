<?php

namespace App\Http\Controllers;

use App\Models\IrrigationDivision;
use App\Models\Circle;
use App\Models\Region;
use App\Models\Unit;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class IrrigationDivisionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = IrrigationDivision::with('circle.region.unit')->select('irrigation_divisions.*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('circle_name', function ($row) {
                    return $row->circle->name ?? '';
                })
                ->addColumn('region_name', function ($row) {
                    return $row->circle->region->name ?? '';
                })
                ->addColumn('unit_name', function ($row) {
                    return $row->circle->region->unit->name ?? '';
                })
                ->addColumn('actions', function ($row) {
                    return '<a href="' . route('irrigation_divisions.edit', $row->id) . '" class="btn btn-primary btn-sm"><i class="ri-edit-box-line"></i></a>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '"><i class="ri-delete-bin-line"></i></button>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('irrigation_divisions.index');
    }

    public function create()
    {
        $units = Unit::all();
        return view('irrigation_divisions.create', compact('units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'circle_id' => 'required',
            'name' => 'required',
        ]);

        IrrigationDivision::create($request->all());

        return response()->json([
            'success' => 'Irrigation Division created successfully.',
            'redirect' => route('irrigation_divisions.index')
        ]);
    }

    public function edit($id)
    {
        $irrigation_division = IrrigationDivision::findOrFail($id);
        $units = Unit::all();
        $regions = Region::where('unit_id', $irrigation_division->circle->region->unit_id)->get();
        $circles = Circle::where('region_id', $irrigation_division->circle->region_id)->get();
        return view('irrigation_divisions.create', compact('irrigation_division', 'units', 'regions', 'circles'));
    }

    public function update(Request $request, $id)
    {
        $irrigation_division = IrrigationDivision::findOrFail($id);
        $request->validate([
            'circle_id' => 'required',
            'name' => 'required',
        ]);

        $irrigation_division->update($request->all());

        return response()->json([
            'success' => 'Irrigation Division updated successfully.',
            'redirect' => route('irrigation_divisions.index')
        ]);
    }

    public function destroy($id)
    {
        $irrigation_division = IrrigationDivision::findOrFail($id);
        $irrigation_division->delete();
        return response()->json(['success' => 'Irrigation Division deleted successfully.']);
    }

    // AJAX helper for cascading dropdown
    public function getIrrigationDivisions($circle_id)
    {
        $divisions = IrrigationDivision::where('circle_id', $circle_id)->get();
        return response()->json($divisions);
    }
}
