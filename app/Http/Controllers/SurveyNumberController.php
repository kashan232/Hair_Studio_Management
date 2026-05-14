<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SurveyNumber;
use App\Models\Deh;
use App\Models\Tappa;
use App\Models\RevenueCircle;
use App\Models\Taluka;
use App\Models\District;
use App\Models\RevenueDivision;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class SurveyNumberController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $survey_numbers = SurveyNumber::with('deh.tappa.revenueCircle.taluka.district.revenueDivision');
            return DataTables::of($survey_numbers)
                ->addColumn('deh_name', function ($row) {
                    return $row->deh->name ?? '';
                })
                ->addColumn('tappa_name', function ($row) {
                    return $row->deh->tappa->name ?? '';
                })
                ->addColumn('circle_name', function ($row) {
                    return $row->deh->tappa->revenueCircle->name ?? '';
                })
                ->addColumn('taluka_name', function ($row) {
                    return $row->deh->tappa->revenueCircle->taluka->name ?? '';
                })
                ->addColumn('district_name', function ($row) {
                    return $row->deh->tappa->revenueCircle->taluka->district->name ?? '';
                })
                ->addColumn('division_name', function ($row) {
                    return $row->deh->tappa->revenueCircle->taluka->district->revenueDivision->name ?? '';
                })
                ->addColumn('actions', function ($row) {
                    return '
                        <a href="'.route('survey_numbers.edit', $row->id).'" class="btn btn-sm btn-primary">Edit</a>
                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="'.$row->id.'">Delete</button>
                    ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('survey_numbers.index');
    }

    public function create()
    {
        $divisions = RevenueDivision::all();
        return view('survey_numbers.create', compact('divisions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'deh_id' => 'required',
            'number' => 'required|string|max:255',
            'code' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        SurveyNumber::create($request->all());

        return response()->json([
            'success' => 'Survey Number Created Successfully',
            'redirect' => route('survey_numbers.index')
        ]);
    }

    public function edit($id)
    {
        $survey_number = SurveyNumber::findOrFail($id);
        $divisions = RevenueDivision::all();
        $districts = District::where('revenue_division_id', $survey_number->deh->tappa->revenueCircle->taluka->district->revenue_division_id)->get();
        $talukas = Taluka::where('district_id', $survey_number->deh->tappa->revenueCircle->taluka->district_id)->get();
        $circles = RevenueCircle::where('taluka_id', $survey_number->deh->tappa->revenueCircle->taluka_id)->get();
        $tappas = Tappa::where('revenue_circle_id', $survey_number->deh->tappa->revenue_circle_id)->get();
        $dehs = Deh::where('tappa_id', $survey_number->deh->tappa_id)->get();
        return view('survey_numbers.create', compact('survey_number', 'divisions', 'districts', 'talukas', 'circles', 'tappas', 'dehs'));
    }

    public function update(Request $request, $id)
    {
        $survey_number = SurveyNumber::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'deh_id' => 'required',
            'number' => 'required|string|max:255',
            'code' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $survey_number->update($request->all());

        return response()->json([
            'success' => 'Survey Number Updated Successfully',
            'redirect' => route('survey_numbers.index')
        ]);
    }

    public function destroy($id)
    {
        $survey_number = SurveyNumber::findOrFail($id);
        $survey_number->delete();
        return response()->json(['success' => 'Survey Number Deleted Successfully']);
    }

    public function getSurveyNumbers($deh_id)
    {
        $survey_numbers = SurveyNumber::where('deh_id', $deh_id)->get();
        return response()->json($survey_numbers);
    }
}
