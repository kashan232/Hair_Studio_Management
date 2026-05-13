<?php

namespace App\Http\Controllers;





use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Zone;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ZoneController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $zones = Zone::query();
            return DataTables::of($zones)
                ->addColumn('actions', function ($row) {
                    return '
                        <a href="'.route('zones.edit', $row->id).'" class="btn btn-sm btn-primary">Edit</a>
                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="'.$row->id.'">Delete</button>
                    ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('zones.index');
    }

    public function create()
    {
        return view('zones.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        Zone::create($request->all());

        return response()->json([
            'success' => 'Zone Created Successfully',
            'redirect' => route('zones.index')
        ]);
    }

    public function edit(Zone $zone)
    {
        return view('zones.create', compact('zone'));
    }

    public function update(Request $request, Zone $zone)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $zone->update($request->all());

        return response()->json([
            'success' => 'Zone Updated Successfully',
            'redirect' => route('zones.index')
        ]);
    }

    public function destroy(Zone $zone)
    {
        $zone->delete();
        return response()->json(['success' => 'Zone Deleted Successfully']);
    }
}

