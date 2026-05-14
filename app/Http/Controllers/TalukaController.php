<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Taluka;
use App\Models\District;
use App\Models\RevenueDivision;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class TalukaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $talukas = Taluka::with('district.revenueDivision');
            return DataTables::of($talukas)
                ->addColumn('district_name', function ($row) {
                    return $row->district->name ?? '';
                })
                ->addColumn('division_name', function ($row) {
                    return $row->district->revenueDivision->name ?? '';
                })
                ->addColumn('actions', function ($row) {
                    return '
                        <a href="'.route('talukas.edit', $row->id).'" class="btn btn-sm btn-primary">Edit</a>
                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="'.$row->id.'">Delete</button>
                    ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('talukas.index');
    }

    public function create()
    {
        $divisions = RevenueDivision::all();
        return view('talukas.create', compact('divisions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'district_id' => 'required',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        Taluka::create($request->all());

        return response()->json([
            'success' => 'Taluka Created Successfully',
            'redirect' => route('talukas.index')
        ]);
    }

    public function edit($id)
    {
        $taluka = Taluka::findOrFail($id);
        $divisions = RevenueDivision::all();
        $districts = District::where('revenue_division_id', $taluka->district->revenue_division_id)->get();
        return view('talukas.create', compact('taluka', 'divisions', 'districts'));
    }

    public function update(Request $request, $id)
    {
        $taluka = Taluka::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'district_id' => 'required',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $taluka->update($request->all());

        return response()->json([
            'success' => 'Taluka Updated Successfully',
            'redirect' => route('talukas.index')
        ]);
    }

    public function destroy($id)
    {
        $taluka = Taluka::findOrFail($id);
        $taluka->delete();
        return response()->json(['success' => 'Taluka Deleted Successfully']);
    }

    public function getTalukas($district_id)
    {
        $talukas = Taluka::where('district_id', $district_id)->get();
        return response()->json($talukas);
    }
}
