<?php

namespace App\Http\Controllers;

use App\Models\Beat;
use App\Models\SubDivision;
use App\Models\IrrigationDivision;
use App\Models\Circle;
use App\Models\Region;
use App\Models\Unit;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BeatController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Beat::with('subDivision.irrigationDivision.circle.region.unit')->select('beats.*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('sub_division_name', function ($row) {
                    return $row->subDivision->name ?? '';
                })
                ->addColumn('irrigation_division_name', function ($row) {
                    return $row->subDivision->irrigationDivision->name ?? '';
                })
                ->addColumn('circle_name', function ($row) {
                    return $row->subDivision->irrigationDivision->circle->name ?? '';
                })
                ->addColumn('region_name', function ($row) {
                    return $row->subDivision->irrigationDivision->circle->region->name ?? '';
                })
                ->addColumn('unit_name', function ($row) {
                    return $row->subDivision->irrigationDivision->circle->region->unit->name ?? '';
                })
                ->addColumn('actions', function ($row) {
                    return '<a href="' . route('beats.edit', $row->id) . '" class="btn btn-primary btn-sm"><i class="ri-edit-box-line"></i></a>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '"><i class="ri-delete-bin-line"></i></button>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('beats.index');
    }

    public function create()
    {
        $units = Unit::all();
        return view('beats.create', compact('units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sub_division_id' => 'required',
            'name' => 'required',
        ]);

        Beat::create($request->all());

        return response()->json([
            'success' => 'Beat created successfully.',
            'redirect' => route('beats.index')
        ]);
    }

    public function edit($id)
    {
        $beat = Beat::findOrFail($id);
        $units = Unit::all();
        $subDivision = $beat->subDivision;
        $irrigationDivision = $subDivision->irrigationDivision;
        $circle = $irrigationDivision->circle;
        $region = $circle->region;
        $unit = $region->unit;

        $regions = Region::where('unit_id', $unit->id)->get();
        $circles = Circle::where('region_id', $region->id)->get();
        $irrigation_divisions = IrrigationDivision::where('circle_id', $circle->id)->get();
        $subDivisions = SubDivision::where('irrigation_division_id', $irrigationDivision->id)->get();

        return view('beats.create', compact('beat', 'units', 'regions', 'circles', 'irrigation_divisions', 'subDivisions'));
    }

    public function update(Request $request, $id)
    {
        $beat = Beat::findOrFail($id);
        $request->validate([
            'sub_division_id' => 'required',
            'name' => 'required',
        ]);

        $beat->update($request->all());

        return response()->json([
            'success' => 'Beat updated successfully.',
            'redirect' => route('beats.index')
        ]);
    }

    public function destroy($id)
    {
        $beat = Beat::findOrFail($id);
        $beat->delete();
        return response()->json(['success' => 'Beat deleted successfully.']);
    }

    public function getBeats($sub_division_id)
    {
        $beats = Beat::where('sub_division_id', $sub_division_id)->get();
        return response()->json($beats);
    }
}
