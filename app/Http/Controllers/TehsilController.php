<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Taluka;
use App\Models\Tehsil;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TehsilController extends Controller
{
    public function index()
    {
        $tehsils = Tehsil::with([
            'taluka.district',
        ])->withCount('dehs')->orderBy('name')->paginate(15);

        return view('tehsils.index', compact('tehsils'));
    }

    public function create()
    {
        $districts = District::orderBy('name')->get(['id', 'name']);

        return view('tehsils.create', compact('districts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'district_id' => ['required', 'exists:districts,id'],
            'taluka_id' => [
                'required',
                Rule::exists('talukas', 'id')->where(fn ($q) => $q->where('district_id', $request->district_id)),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tehsils', 'name')->where(fn ($q) => $q->where('taluka_id', $request->taluka_id)),
            ],
        ]);

        Tehsil::create([
            'taluka_id' => $validated['taluka_id'],
            'name' => $validated['name'],
        ]);

        return redirect()->route('tehsils.index')->with('success', 'Tehsil created successfully.');
    }

    public function show(Tehsil $tehsil)
    {
        $tehsil->load(['taluka.district'])->loadCount('dehs');

        return view('tehsils.show', compact('tehsil'));
    }

    public function edit(Tehsil $tehsil)
    {
        $tehsil->load('taluka.district');
        $districts = District::orderBy('name')->get(['id', 'name']);
        $districtId = $tehsil->taluka->district_id;
        $talukas = Taluka::where('district_id', $districtId)->orderBy('name')->get(['id', 'name']);

        return view('tehsils.edit', compact('tehsil', 'districts', 'talukas', 'districtId'));
    }

    public function update(Request $request, Tehsil $tehsil)
    {
        $validated = $request->validate([
            'district_id' => ['required', 'exists:districts,id'],
            'taluka_id' => [
                'required',
                Rule::exists('talukas', 'id')->where(fn ($q) => $q->where('district_id', $request->district_id)),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tehsils', 'name')
                    ->where(fn ($q) => $q->where('taluka_id', $request->taluka_id))
                    ->ignore($tehsil->id),
            ],
        ]);

        $tehsil->update([
            'taluka_id' => $validated['taluka_id'],
            'name' => $validated['name'],
        ]);

        return redirect()->route('tehsils.index')->with('success', 'Tehsil updated successfully.');
    }

    public function confirmDelete(Tehsil $tehsil)
    {
        $tehsil->load(['taluka.district'])->loadCount('dehs');

        return view('tehsils.delete', compact('tehsil'));
    }

    public function destroy(Tehsil $tehsil)
    {
        $tehsil->delete();

        return redirect()->route('tehsils.index')->with('success', 'Tehsil deleted successfully.');
    }

    /** JSON: taluka → tehsils (for cascading) */
    public function byTaluka(Taluka $taluka)
    {
        $items = Tehsil::where('taluka_id', $taluka->id)->orderBy('name')->get(['id', 'name']);

        return response()->json($items);
    }
}
