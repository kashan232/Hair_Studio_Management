<?php

namespace App\Http\Controllers;

use App\Models\Deh;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DehController extends Controller
{
    public function index()
    {
        $dehs = Deh::with([
            'tehsil.taluka.district',
        ])->orderBy('name')->paginate(15);

        return view('dehs.index', compact('dehs'));
    }

    public function create()
    {
        $districts = District::orderBy('name')->get(['id', 'name']);

        return view('dehs.create', compact('districts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'district_id' => ['required', 'exists:districts,id'],
            'taluka_id' => [
                'required',
                Rule::exists('talukas', 'id')->where(fn ($q) => $q->where('district_id', $request->district_id)),
            ],
            'tehsil_id' => [
                'required',
                Rule::exists('tehsils', 'id')->where(fn ($q) => $q->where('taluka_id', $request->taluka_id)),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('dehs', 'name')->where(fn ($q) => $q->where('tehsil_id', $request->tehsil_id)),
            ],
        ]);

        Deh::create([
            'tehsil_id' => $validated['tehsil_id'],
            'name' => $validated['name'],
        ]);

        return redirect()->route('dehs.index')->with('success', 'DEH created successfully.');
    }

    public function show(Deh $deh)
    {
        $deh->load(['tehsil.taluka.district']);

        return view('dehs.show', compact('deh'));
    }

    public function edit(Deh $deh)
    {
        $deh->load(['tehsil.taluka.district']);

        $districts = District::orderBy('name')->get(['id', 'name']);
        $districtId = $deh->tehsil->taluka->district_id;
        $talukaId = $deh->tehsil->taluka_id;

        $talukas = Taluka::where('district_id', $districtId)->orderBy('name')->get(['id', 'name']);
        $tehsils = Tehsil::where('taluka_id', $talukaId)->orderBy('name')->get(['id', 'name']);

        return view('dehs.edit', compact('deh', 'districts', 'talukas', 'tehsils', 'districtId', 'talukaId'));
    }

    public function update(Request $request, Deh $deh)
    {
        $validated = $request->validate([
            'district_id' => ['required', 'exists:districts,id'],
            'taluka_id' => [
                'required',
                Rule::exists('talukas', 'id')->where(fn ($q) => $q->where('district_id', $request->district_id)),
            ],
            'tehsil_id' => [
                'required',
                Rule::exists('tehsils', 'id')->where(fn ($q) => $q->where('taluka_id', $request->taluka_id)),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('dehs', 'name')
                    ->where(fn ($q) => $q->where('tehsil_id', $request->tehsil_id))
                    ->ignore($deh->id),
            ],
        ]);

        $deh->update([
            'tehsil_id' => $validated['tehsil_id'],
            'name' => $validated['name'],
        ]);

        return redirect()->route('dehs.index')->with('success', 'DEH updated successfully.');
    }

    public function confirmDelete(Deh $deh)
    {
        $deh->load(['tehsil.taluka.district']);

        return view('dehs.delete', compact('deh'));
    }

    public function destroy(Deh $deh)
    {
        $deh->delete();

        return redirect()->route('dehs.index')->with('success', 'DEH deleted successfully.');
    }

    /** JSON: tehsil → DEHs */
    public function byTehsil(Tehsil $tehsil)
    {
        $items = Deh::where('tehsil_id', $tehsil->id)->orderBy('name')->get(['id', 'name']);

        return response()->json($items);
    }
}
