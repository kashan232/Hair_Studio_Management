<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RevenueDivision;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class RevenueDivisionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $divisions = RevenueDivision::query();
            return DataTables::of($divisions)
                ->addColumn('actions', function ($row) {
                    return '
                        <a href="'.route('revenue_divisions.edit', $row->id).'" class="btn btn-sm btn-primary">Edit</a>
                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="'.$row->id.'">Delete</button>
                    ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('revenue_divisions.index');
    }

    public function create()
    {
        return view('revenue_divisions.create');
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

        RevenueDivision::create($request->all());

        return response()->json([
            'success' => 'Revenue Division Created Successfully',
            'redirect' => route('revenue_divisions.index')
        ]);
    }

    public function edit($id)
    {
        $division = RevenueDivision::findOrFail($id);
        return view('revenue_divisions.create', compact('division'));
    }

    public function update(Request $request, $id)
    {
        $division = RevenueDivision::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $division->update($request->all());

        return response()->json([
            'success' => 'Revenue Division Updated Successfully',
            'redirect' => route('revenue_divisions.index')
        ]);
    }

    public function destroy($id)
    {
        $division = RevenueDivision::findOrFail($id);
        $division->delete();
        return response()->json(['success' => 'Revenue Division Deleted Successfully']);
    }
}
