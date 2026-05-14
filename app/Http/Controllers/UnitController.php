<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Unit;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $units = Unit::query();
            return DataTables::of($units)
                ->addColumn('actions', function ($row) {
                    return '
                        <a href="'.route('units.edit', $row->id).'" class="btn btn-sm btn-primary">Edit</a>
                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="'.$row->id.'">Delete</button>
                    ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('units.index');
    }

    public function create()
    {
        return view('units.create');
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

        Unit::create($request->all());

        return response()->json([
            'success' => 'Unit Created Successfully',
            'redirect' => route('units.index')
        ]);
    }

    public function edit($id)
    {
        $unit = Unit::findOrFail($id);
        return view('units.create', compact('unit'));
    }

    public function update(Request $request, $id)
    {
        $unit = Unit::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $unit->update($request->all());

        return response()->json([
            'success' => 'Unit Updated Successfully',
            'redirect' => route('units.index')
        ]);
    }

    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();
        return response()->json(['success' => 'Unit Deleted Successfully']);
    }
}
