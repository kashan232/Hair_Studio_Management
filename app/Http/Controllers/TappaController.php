<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tappa;
use App\Models\RevenueCircle;
use App\Models\Taluka;
use App\Models\District;
use App\Models\RevenueDivision;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class TappaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $tappas = Tappa::with('revenueCircle.taluka.district.revenueDivision');
            return DataTables::of($tappas)
                ->addColumn('circle_name', function ($row) {
                    return $row->revenueCircle->name ?? '';
                })
                ->addColumn('taluka_name', function ($row) {
                    return $row->revenueCircle->taluka->name ?? '';
                })
                ->addColumn('district_name', function ($row) {
                    return $row->revenueCircle->taluka->district->name ?? '';
                })
                ->addColumn('division_name', function ($row) {
                    return $row->revenueCircle->taluka->district->revenueDivision->name ?? '';
                })
                ->addColumn('actions', function ($row) {
                    return '
                        <a href="'.route('tappas.edit', $row->id).'" class="btn btn-sm btn-primary">Edit</a>
                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="'.$row->id.'">Delete</button>
                    ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('tappas.index');
    }

    public function create()
    {
        $divisions = RevenueDivision::all();
        return view('tappas.create', compact('divisions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'revenue_circle_id' => 'required',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        Tappa::create($request->all());

        return response()->json([
            'success' => 'Tappa Created Successfully',
            'redirect' => route('tappas.index')
        ]);
    }

    public function edit($id)
    {
        $tappa = Tappa::findOrFail($id);
        $divisions = RevenueDivision::all();
        $districts = District::where('revenue_division_id', $tappa->revenueCircle->taluka->district->revenue_division_id)->get();
        $talukas = Taluka::where('district_id', $tappa->revenueCircle->taluka->district_id)->get();
        $circles = RevenueCircle::where('taluka_id', $tappa->revenueCircle->taluka_id)->get();
        return view('tappas.create', compact('tappa', 'divisions', 'districts', 'talukas', 'circles'));
    }

    public function update(Request $request, $id)
    {
        $tappa = Tappa::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'revenue_circle_id' => 'required',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $tappa->update($request->all());

        return response()->json([
            'success' => 'Tappa Updated Successfully',
            'redirect' => route('tappas.index')
        ]);
    }

    public function destroy($id)
    {
        $tappa = Tappa::findOrFail($id);
        $tappa->delete();
        return response()->json(['success' => 'Tappa Deleted Successfully']);
    }

    public function getTappas($revenue_circle_id)
    {
        $tappas = Tappa::where('revenue_circle_id', $revenue_circle_id)->get();
        return response()->json($tappas);
    }
}
