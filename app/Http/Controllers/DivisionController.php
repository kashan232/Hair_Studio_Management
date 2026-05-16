<?php

namespace App\Http\Controllers;

use App\Models\Circle;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DivisionController extends Controller
{
    public function index()
    {
        $divisions = Division::with(['circle'])->withCount('subDivisions')->orderBy('name')->paginate(15);
        return view('divisions.index', compact('divisions'));
    }

    public function create()
    {
        $circles = Circle::orderBy('name')->get();
        return view('divisions.create', compact('circles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'circle_id' => ['required', 'exists:circles,id'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        Division::create($validated);

        return redirect()->route('divisions.index')->with('success', 'Division created successfully.');
    }

    public function show(Division $division)
    {
        $division->load(['circle'])->loadCount('subDivisions');
        return view('divisions.show', compact('division'));
    }

    public function edit(Division $division)
    {
        $circles = Circle::orderBy('name')->get();
        return view('divisions.edit', compact('division', 'circles'));
    }

    public function update(Request $request, Division $division)
    {
        $validated = $request->validate([
            'circle_id' => ['required', 'exists:circles,id'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        $division->update($validated);

        return redirect()->route('divisions.index')->with('success', 'Division updated successfully.');
    }

    public function confirmDelete(Division $division)
    {
        $division->loadCount('subDivisions');
        return view('divisions.delete', compact('division'));
    }

    public function destroy(Division $division)
    {
        $division->delete();
        return redirect()->route('divisions.index')->with('success', 'Division deleted successfully.');
    }

    public function byCircle(Circle $circle)
    {
        return response()->json($circle->divisions()->orderBy('name')->get(['id', 'name']));
    }
}
