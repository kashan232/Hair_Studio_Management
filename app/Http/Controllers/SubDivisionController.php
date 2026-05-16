<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\SubDivision;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubDivisionController extends Controller
{
    public function index()
    {
        $subDivisions = SubDivision::with(['division.circle'])->orderBy('name')->paginate(15);
        return view('sub_divisions.index', compact('subDivisions'));
    }

    public function create()
    {
        $circles = Circle::orderBy('name')->get();
        $divisions = collect();
        return view('sub_divisions.create', compact('circles', 'divisions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'division_id' => ['required', 'exists:divisions,id'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        SubDivision::create($validated);

        return redirect()->route('sub-divisions.index')->with('success', 'Sub Division created successfully.');
    }

    public function show(SubDivision $subDivision)
    {
        $subDivision->load('division.circle');
        return view('sub_divisions.show', compact('subDivision'));
    }

    public function edit(SubDivision $subDivision)
    {
        $circles = Circle::orderBy('name')->get();
        $circleId = $subDivision->division->circle_id ?? null;
        $divisions = $circleId ? Division::where('circle_id', $circleId)->orderBy('name')->get() : collect();
        
        return view('sub_divisions.edit', compact('subDivision', 'circles', 'divisions', 'circleId'));
    }

    public function update(Request $request, SubDivision $subDivision)
    {
        $validated = $request->validate([
            'division_id' => ['required', 'exists:divisions,id'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        $subDivision->update($validated);

        return redirect()->route('sub-divisions.index')->with('success', 'Sub Division updated successfully.');
    }

    public function confirmDelete(SubDivision $subDivision)
    {
        return view('sub_divisions.delete', compact('subDivision'));
    }

    public function destroy(SubDivision $subDivision)
    {
        $subDivision->delete();
        return redirect()->route('sub-divisions.index')->with('success', 'Sub Division deleted successfully.');
    }

    public function byDivision(Division $division)
    {
        return response()->json($division->subDivisions()->orderBy('name')->get(['id', 'name']));
    }

    public function getDetails(SubDivision $subDivision)
    {
        return response()->json($subDivision->load('division.circle'));
    }
}
