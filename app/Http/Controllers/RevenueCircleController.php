<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RevenueCircle;
use App\Models\Taluka;
use App\Models\District;
use App\Models\RevenueDivision;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class RevenueCircleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $circles = RevenueCircle::with('taluka.district.revenueDivision');
            return DataTables::of($circles)
                ->addColumn('taluka_name', function ($row) {
                    return $row->taluka->name ?? '';
                })
                ->addColumn('district_name', function ($row) {
                    return $row->taluka->district->name ?? '';
                })
                ->addColumn('division_name', function ($row) {
                    return $row->taluka->district->revenueDivision->name ?? '';
                })
                ->addColumn('actions', function ($row) {
                    return '
                        <a href="'.route('revenue_circles.edit', $row->id).'" class="btn btn-sm btn-primary">Edit</a>
                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="'.$row->id.'">Delete</button>
                    ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('revenue_circles.index');
    }

    public function create()
    {
        $divisions = RevenueDivision::all();
        return view('revenue_circles.create', compact('divisions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'taluka_id' => 'required',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        RevenueCircle::create($request->all());

        return response()->json([
            'success' => 'Revenue Circle Created Successfully',
            'redirect' => route('revenue_circles.index')
        ]);
    }

    public function edit($id)
    {
        $circle = RevenueCircle::findOrFail($id);
        $divisions = RevenueDivision::all();
        $districts = District::where('revenue_division_id', $circle->taluka->district->revenue_division_id)->get();
        $talukas = Taluka::where('district_id', $circle->taluka->district_id)->get();
        return view('revenue_circles.create', compact('circle', 'divisions', 'districts', 'talukas'));
    }

    public function update(Request $request, $id)
    {
        $circle = RevenueCircle::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'taluka_id' => 'required',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $circle->update($request->all());

        return response()->json([
            'success' => 'Revenue Circle Updated Successfully',
            'redirect' => route('revenue_circles.index')
        ]);
    }

    public function destroy($id)
    {
        $circle = RevenueCircle::findOrFail($id);
        $circle->delete();
        return response()->json(['success' => 'Revenue Circle Deleted Successfully']);
    }

    public function getRevenueCircles($taluka_id)
    {
        $circles = RevenueCircle::where('taluka_id', $taluka_id)->get();
        return response()->json($circles);
    }
}
