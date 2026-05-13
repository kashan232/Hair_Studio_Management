<?php

namespace App\Http\Controllers;





use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Circle;
use App\Models\Zone;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class CircleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $circles = Circle::with('zone');
            return DataTables::of($circles)
                ->addColumn('zone_name', function ($row) {
                    return $row->zone ? $row->zone->name : 'N/A';
                })
                ->addColumn('actions', function ($row) {
                    return '
                        <a href="'.route('circles.edit', $row->id).'" class="btn btn-sm btn-primary">Edit</a>
                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="'.$row->id.'">Delete</button>
                    ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('circles.index');
    }

    public function create()
    {
        $zones = Zone::all();
        return view('circles.create', compact('zones'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'zone_id' => 'required|exists:zones,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        Circle::create($request->all());

        return response()->json([
            'success' => 'Circle Created Successfully',
            'redirect' => route('circles.index')
        ]);
    }

    public function edit(Circle $circle)
    {
        $zones = Zone::all();
        return view('circles.create', compact('circle', 'zones'));
    }

    public function update(Request $request, Circle $circle)
    {
        $validator = Validator::make($request->all(), [
            'zone_id' => 'required|exists:zones,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $circle->update($request->all());

        return response()->json([
            'success' => 'Circle Updated Successfully',
            'redirect' => route('circles.index')
        ]);
    }

    public function destroy(Circle $circle)
    {
        $circle->delete();
        return response()->json(['success' => 'Circle Deleted Successfully']);
    }
}

