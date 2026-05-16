<?php

namespace App\Http\Controllers;

use App\Models\Barrage;
use App\Models\MainCanal;
use App\Models\SubCanal;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubCanalController extends Controller
{
    public function index()
    {
        $subCanals = SubCanal::with('mainCanal.barrage')->withCount('branchCanals')->orderBy('name')->paginate(15);

        return view('sub-canals.index', compact('subCanals'));
    }

    public function create()
    {
        $barrages = Barrage::orderBy('name')->get(['id', 'name']);

        return view('sub-canals.create', compact('barrages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'barrage_id' => ['required', 'exists:barrages,id'],
            'main_canal_id' => [
                'required',
                Rule::exists('main_canals', 'id')->where(fn ($q) => $q->where('barrage_id', $request->barrage_id)),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sub_canals', 'name')->where(fn ($q) => $q->where('main_canal_id', $request->main_canal_id)),
            ],
        ]);

        SubCanal::create([
            'main_canal_id' => $validated['main_canal_id'],
            'name' => $validated['name'],
        ]);

        return redirect()->route('sub-canals.index')->with('success', 'Sub canal created successfully.');
    }

    public function show(SubCanal $subCanal)
    {
        $subCanal->load('mainCanal.barrage')->loadCount('branchCanals');

        return view('sub-canals.show', compact('subCanal'));
    }

    public function edit(SubCanal $subCanal)
    {
        $subCanal->load('mainCanal.barrage');

        $barrages = Barrage::orderBy('name')->get(['id', 'name']);
        $barrageId = $subCanal->mainCanal->barrage_id;
        $mainCanals = MainCanal::where('barrage_id', $barrageId)->orderBy('name')->get(['id', 'name']);

        return view('sub-canals.edit', compact('subCanal', 'barrages', 'mainCanals', 'barrageId'));
    }

    public function update(Request $request, SubCanal $subCanal)
    {
        $validated = $request->validate([
            'barrage_id' => ['required', 'exists:barrages,id'],
            'main_canal_id' => [
                'required',
                Rule::exists('main_canals', 'id')->where(fn ($q) => $q->where('barrage_id', $request->barrage_id)),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sub_canals', 'name')
                    ->where(fn ($q) => $q->where('main_canal_id', $request->main_canal_id))
                    ->ignore($subCanal->id),
            ],
        ]);

        $subCanal->update([
            'main_canal_id' => $validated['main_canal_id'],
            'name' => $validated['name'],
        ]);

        return redirect()->route('sub-canals.index')->with('success', 'Sub canal updated successfully.');
    }

    public function confirmDelete(SubCanal $subCanal)
    {
        $subCanal->load('mainCanal.barrage')->loadCount('branchCanals');

        return view('sub-canals.delete', compact('subCanal'));
    }

    public function destroy(SubCanal $subCanal)
    {
        $subCanal->delete();

        return redirect()->route('sub-canals.index')->with('success', 'Sub canal deleted successfully.');
    }

    public function byMainCanal(MainCanal $mainCanal)
    {
        $items = SubCanal::where('main_canal_id', $mainCanal->id)->orderBy('name')->get(['id', 'name']);

        return response()->json($items);
    }
}
