<?php

namespace App\Http\Controllers;

use App\Models\Barrage;
use App\Models\MainCanal;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MainCanalController extends Controller
{
    public function index()
    {
        $mainCanals = MainCanal::with('barrage')->withCount('subCanals')->orderBy('name')->paginate(15);

        return view('main-canals.index', compact('mainCanals'));
    }

    public function create()
    {
        $barrages = Barrage::orderBy('name')->get(['id', 'name']);

        return view('main-canals.create', compact('barrages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'barrage_id' => ['required', 'exists:barrages,id'],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('main_canals', 'name')->where(fn ($q) => $q->where('barrage_id', $request->barrage_id)),
            ],
        ]);

        MainCanal::create($validated);

        return redirect()->route('main-canals.index')->with('success', 'Main canal created successfully.');
    }

    public function show(MainCanal $mainCanal)
    {
        $mainCanal->load('barrage')->loadCount('subCanals');

        return view('main-canals.show', compact('mainCanal'));
    }

    public function edit(MainCanal $mainCanal)
    {
        $barrages = Barrage::orderBy('name')->get(['id', 'name']);

        return view('main-canals.edit', compact('mainCanal', 'barrages'));
    }

    public function update(Request $request, MainCanal $mainCanal)
    {
        $validated = $request->validate([
            'barrage_id' => ['required', 'exists:barrages,id'],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('main_canals', 'name')
                    ->where(fn ($q) => $q->where('barrage_id', $request->barrage_id))
                    ->ignore($mainCanal->id),
            ],
        ]);

        $mainCanal->update($validated);

        return redirect()->route('main-canals.index')->with('success', 'Main canal updated successfully.');
    }

    public function confirmDelete(MainCanal $mainCanal)
    {
        $mainCanal->load('barrage')->loadCount('subCanals');

        return view('main-canals.delete', compact('mainCanal'));
    }

    public function destroy(MainCanal $mainCanal)
    {
        $mainCanal->delete();

        return redirect()->route('main-canals.index')->with('success', 'Main canal deleted successfully.');
    }

    public function byBarrage(Barrage $barrage)
    {
        $items = MainCanal::where('barrage_id', $barrage->id)->orderBy('name')->get(['id', 'name']);

        return response()->json($items);
    }
}
