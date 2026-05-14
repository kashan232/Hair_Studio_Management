<?php

namespace App\Http\Controllers;





use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\Unit;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class RegionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $regions = Region::with('unit');
            return DataTables::of($regions)
                ->addColumn('unit_name', function ($row) {
                    return $row->unit ? $row->unit->name : 'N/A';
                })
                ->addColumn('actions', function ($row) {
                    return '
                        <a href="'.route('regions.edit', $row->id).'" class="btn btn-sm btn-primary">Edit</a>
                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="'.$row->id.'">Delete</button>
                    ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('regions.index');
    }

    public function create()
    {
        $units = Unit::all();
        return view('regions.create', compact('units'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'unit_id' => 'required|exists:units,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        Region::create($request->all());

        return response()->json([
            'success' => 'Region Created Successfully',
            'redirect' => route('regions.index')
        ]);
    }

    public function edit($id)
    {
        $region = Region::findOrFail($id);
        $units = Unit::all();
        return view('regions.create', compact('region', 'units'));
    }

    public function update(Request $request, $id)
    {
        $region = Region::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'unit_id' => 'required|exists:units,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $region->update($request->all());

        return response()->json([
            'success' => 'Region Updated Successfully',
            'redirect' => route('regions.index')
        ]);
    }

    public function destroy($id)
    {
        $region = Region::findOrFail($id);
        $region->delete();
        return response()->json(['success' => 'Region Deleted Successfully']);
    }

    public function getRegions($unit_id)
    {
        $regions = Region::where('unit_id', $unit_id)->get();
        return response()->json($regions);
    }
}

