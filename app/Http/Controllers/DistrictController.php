<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DistrictController extends Controller
{
    public function index()
    {
        $districts = District::withCount('talukas')->orderBy('name')->paginate(15);

        return view('districts.index', compact('districts'));
    }

    public function create()
    {
        return view('districts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('districts', 'name')],
        ]);

        District::create($validated);

        return redirect()->route('districts.index')->with('success', 'District created successfully.');
    }

    public function show(District $district)
    {
        $district->loadCount('talukas');

        return view('districts.show', compact('district'));
    }

    public function edit(District $district)
    {
        return view('districts.edit', compact('district'));
    }

    public function update(Request $request, District $district)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('districts', 'name')->ignore($district->id)],
        ]);

        $district->update($validated);

        return redirect()->route('districts.index')->with('success', 'District updated successfully.');
    }

    public function confirmDelete(District $district)
    {
        $district->loadCount('talukas');

        return view('districts.delete', compact('district'));
    }

    public function destroy(District $district)
    {
        $district->delete();

        return redirect()->route('districts.index')->with('success', 'District deleted successfully.');
    }
}
