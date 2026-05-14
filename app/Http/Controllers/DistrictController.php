<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\District;
use App\Models\RevenueDivision;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class DistrictController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $districts = District::with('revenueDivision');
            return DataTables::of($districts)
                ->addColumn('division_name', function ($row) {
                    return $row->revenueDivision->name ?? '';
                })
                ->addColumn('actions', function ($row) {
                    return '
                        <a href="'.route('districts.edit', $row->id).'" class="btn btn-sm btn-primary">Edit</a>
                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="'.$row->id.'">Delete</button>
                    ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('districts.index');
    }

    public function create()
    {
        $divisions = RevenueDivision::all();
        return view('districts.create', compact('divisions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'revenue_division_id' => 'required',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        District::create($request->all());

        return response()->json([
            'success' => 'District Created Successfully',
            'redirect' => route('districts.index')
        ]);
    }

    public function edit($id)
    {
        $district = District::findOrFail($id);
        $divisions = RevenueDivision::all();
        return view('districts.create', compact('district', 'divisions'));
    }

    public function update(Request $request, $id)
    {
        $district = District::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'revenue_division_id' => 'required',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $district->update($request->all());

        return response()->json([
            'success' => 'District Updated Successfully',
            'redirect' => route('districts.index')
        ]);
    }

    public function destroy($id)
    {
        $district = District::findOrFail($id);
        $district->delete();
        return response()->json(['success' => 'District Deleted Successfully']);
    }

    public function getDistricts($revenue_division_id)
    {
        $districts = District::where('revenue_division_id', $revenue_division_id)->get();
        return response()->json($districts);
    }
}
