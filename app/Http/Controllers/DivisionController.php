<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Circle;
use App\Models\Zone;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DivisionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Division::with('circle.zone')->select('divisions.*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('circle_name', function ($row) {
                    return $row->circle->name ?? '';
                })
                ->addColumn('zone_name', function ($row) {
                    return $row->circle->zone->name ?? '';
                })
                ->addColumn('actions', function ($row) {
                    return '<a href="' . route('divisions.edit', $row->id) . '" class="btn btn-primary btn-sm"><i class="ri-edit-box-line"></i></a>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '"><i class="ri-delete-bin-line"></i></button>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('divisions.index');
    }

    public function create()
    {
        $zones = Zone::all();
        return view('divisions.create', compact('zones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'circle_id' => 'required',
            'name' => 'required',
        ]);

        Division::create($request->all());

        return response()->json([
            'success' => 'Division created successfully.',
            'redirect' => route('divisions.index')
        ]);
    }

    public function edit(Division $division)
    {
        $zones = Zone::all();
        $circles = Circle::where('zone_id', $division->circle->zone_id)->get();
        return view('divisions.create', compact('division', 'zones', 'circles'));
    }

    public function update(Request $request, Division $division)
    {
        $request->validate([
            'circle_id' => 'required',
            'name' => 'required',
        ]);

        $division->update($request->all());

        return response()->json([
            'success' => 'Division updated successfully.',
            'redirect' => route('divisions.index')
        ]);
    }

    public function destroy(Division $division)
    {
        $division->delete();
        return response()->json(['success' => 'Division deleted successfully.']);
    }

    // AJAX helper for cascading dropdown
    public function getCircles($zone_id)
    {
        $circles = Circle::where('zone_id', $zone_id)->get();
        return response()->json($circles);
    }
}
