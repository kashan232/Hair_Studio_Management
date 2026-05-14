<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deh;
use App\Models\Tappa;
use App\Models\RevenueCircle;
use App\Models\Taluka;
use App\Models\District;
use App\Models\RevenueDivision;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class DehController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $dehs = Deh::with('tappa.revenueCircle.taluka.district.revenueDivision');
            return DataTables::of($dehs)
                ->addColumn('tappa_name', function ($row) {
                    return $row->tappa->name ?? '';
                })
                ->addColumn('circle_name', function ($row) {
                    return $row->tappa->revenueCircle->name ?? '';
                })
                ->addColumn('taluka_name', function ($row) {
                    return $row->tappa->revenueCircle->taluka->name ?? '';
                })
                ->addColumn('district_name', function ($row) {
                    return $row->tappa->revenueCircle->taluka->district->name ?? '';
                })
                ->addColumn('division_name', function ($row) {
                    return $row->tappa->revenueCircle->taluka->district->revenueDivision->name ?? '';
                })
                ->addColumn('actions', function ($row) {
                    return '
                        <a href="'.route('dehs.edit', $row->id).'" class="btn btn-sm btn-primary">Edit</a>
                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="'.$row->id.'">Delete</button>
                    ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('dehs.index');
    }

    public function create()
    {
        $divisions = RevenueDivision::all();
        return view('dehs.create', compact('divisions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tappa_id' => 'required',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        Deh::create($request->all());

        return response()->json([
            'success' => 'Deh Created Successfully',
            'redirect' => route('dehs.index')
        ]);
    }

    public function edit($id)
    {
        $deh = Deh::findOrFail($id);
        $divisions = RevenueDivision::all();
        $districts = District::where('revenue_division_id', $deh->tappa->revenueCircle->taluka->district->revenue_division_id)->get();
        $talukas = Taluka::where('district_id', $deh->tappa->revenueCircle->taluka->district_id)->get();
        $circles = RevenueCircle::where('taluka_id', $deh->tappa->revenueCircle->taluka_id)->get();
        $tappas = Tappa::where('revenue_circle_id', $deh->tappa->revenue_circle_id)->get();
        return view('dehs.create', compact('deh', 'divisions', 'districts', 'talukas', 'circles', 'tappas'));
    }

    public function update(Request $request, $id)
    {
        $deh = Deh::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'tappa_id' => 'required',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $deh->update($request->all());

        return response()->json([
            'success' => 'Deh Updated Successfully',
            'redirect' => route('dehs.index')
        ]);
    }

    public function destroy($id)
    {
        $deh = Deh::findOrFail($id);
        $deh->delete();
        return response()->json(['success' => 'Deh Deleted Successfully']);
    }

    public function getDehs($tappa_id)
    {
        $dehs = Deh::where('tappa_id', $tappa_id)->get();
        return response()->json($dehs);
    }
}
