<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Taluka;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TalukaController extends Controller
{
    public function index()
    {
        $talukas = Taluka::with('district')->withCount('tehsils')->orderBy('name')->paginate(15);

        return view('talukas.index', compact('talukas'));
    }

    public function create()
    {
        $districts = District::orderBy('name')->get(['id', 'name']);

        return view('talukas.create', compact('districts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'district_id' => ['required', 'exists:districts,id'],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('talukas', 'name')->where(fn ($q) => $q->where('district_id', $request->district_id)),
            ],
        ]);

        Taluka::create($validated);

        return redirect()->route('talukas.index')->with('success', 'Taluka created successfully.');
    }

    public function show(Taluka $taluka)
    {
        $taluka->load('district')->loadCount('tehsils');

        return view('talukas.show', compact('taluka'));
    }

    public function edit(Taluka $taluka)
    {
        $districts = District::orderBy('name')->get(['id', 'name']);

        return view('talukas.edit', compact('taluka', 'districts'));
    }

    public function update(Request $request, Taluka $taluka)
    {
        $validated = $request->validate([
            'district_id' => ['required', 'exists:districts,id'],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('talukas', 'name')
                    ->where(fn ($q) => $q->where('district_id', $request->district_id))
                    ->ignore($taluka->id),
            ],
        ]);

        $taluka->update($validated);

        return redirect()->route('talukas.index')->with('success', 'Taluka updated successfully.');
    }

    public function confirmDelete(Taluka $taluka)
    {
        $taluka->load('district')->loadCount('tehsils');

        return view('talukas.delete', compact('taluka'));
    }

    public function destroy(Taluka $taluka)
    {
        $taluka->delete();

        return redirect()->route('talukas.index')->with('success', 'Taluka deleted successfully.');
    }

    /** JSON for cascading selects: districts → talukas */
    public function byDistrict(District $district)
    {
        $items = Taluka::where('district_id', $district->id)->orderBy('name')->get(['id', 'name']);

        return response()->json($items);
    }
}
