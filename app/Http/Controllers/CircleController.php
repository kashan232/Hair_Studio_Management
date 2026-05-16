<?php

namespace App\Http\Controllers;

use App\Models\Circle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CircleController extends Controller
{
    public function index()
    {
        $circles = Circle::withCount('divisions')->orderBy('name')->paginate(15);
        return view('circles.index', compact('circles'));
    }

    public function create()
    {
        return view('circles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('circles', 'name')],
        ]);

        Circle::create($validated);

        return redirect()->route('circles.index')->with('success', 'Circle created successfully.');
    }

    public function show(Circle $circle)
    {
        $circle->loadCount('divisions');
        return view('circles.show', compact('circle'));
    }

    public function edit(Circle $circle)
    {
        return view('circles.edit', compact('circle'));
    }

    public function update(Request $request, Circle $circle)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('circles', 'name')->ignore($circle->id)],
        ]);

        $circle->update($validated);

        return redirect()->route('circles.index')->with('success', 'Circle updated successfully.');
    }

    public function confirmDelete(Circle $circle)
    {
        $circle->loadCount('divisions');
        return view('circles.delete', compact('circle'));
    }

    public function destroy(Circle $circle)
    {
        $circle->delete();
        return redirect()->route('circles.index')->with('success', 'Circle deleted successfully.');
    }
}
