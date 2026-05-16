<?php

namespace App\Http\Controllers;

use App\Models\Barrage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BarrageController extends Controller
{
    public function index()
    {
        $barrages = Barrage::withCount('mainCanals')->orderBy('name')->paginate(15);

        return view('barrages.index', compact('barrages'));
    }

    public function create()
    {
        return view('barrages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('barrages', 'name')],
        ]);

        Barrage::create($validated);

        return redirect()->route('barrages.index')->with('success', 'Barrage created successfully.');
    }

    public function show(Barrage $barrage)
    {
        $barrage->loadCount('mainCanals');

        return view('barrages.show', compact('barrage'));
    }

    public function edit(Barrage $barrage)
    {
        return view('barrages.edit', compact('barrage'));
    }

    public function update(Request $request, Barrage $barrage)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('barrages', 'name')->ignore($barrage->id)],
        ]);

        $barrage->update($validated);

        return redirect()->route('barrages.index')->with('success', 'Barrage updated successfully.');
    }

    public function confirmDelete(Barrage $barrage)
    {
        $barrage->loadCount('mainCanals');

        return view('barrages.delete', compact('barrage'));
    }

    public function destroy(Barrage $barrage)
    {
        $barrage->delete();

        return redirect()->route('barrages.index')->with('success', 'Barrage deleted successfully.');
    }
}
