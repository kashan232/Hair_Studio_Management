<?php

namespace App\Http\Controllers;

use App\Models\Barrage;
use App\Models\BranchCanal;
use App\Models\MainCanal;
use App\Models\SubCanal;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BranchCanalController extends Controller
{
    public function index()
    {
        $branchCanals = BranchCanal::with('subCanal.mainCanal.barrage')->withCount('distributaries')->orderBy('name')->paginate(15);

        return view('branch-canals.index', compact('branchCanals'));
    }

    public function create()
    {
        $barrages = Barrage::orderBy('name')->get(['id', 'name']);

        return view('branch-canals.create', compact('barrages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'barrage_id' => ['required', 'exists:barrages,id'],
            'main_canal_id' => [
                'required',
                Rule::exists('main_canals', 'id')->where(fn ($q) => $q->where('barrage_id', $request->barrage_id)),
            ],
            'sub_canal_id' => [
                'required',
                Rule::exists('sub_canals', 'id')->where(fn ($q) => $q->where('main_canal_id', $request->main_canal_id)),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('branch_canals', 'name')->where(fn ($q) => $q->where('sub_canal_id', $request->sub_canal_id)),
            ],
        ]);

        BranchCanal::create([
            'sub_canal_id' => $validated['sub_canal_id'],
            'name' => $validated['name'],
        ]);

        return redirect()->route('branch-canals.index')->with('success', 'Branch canal created successfully.');
    }

    public function show(BranchCanal $branchCanal)
    {
        $branchCanal->load('subCanal.mainCanal.barrage')->loadCount('distributaries');

        return view('branch-canals.show', compact('branchCanal'));
    }

    public function edit(BranchCanal $branchCanal)
    {
        $branchCanal->load('subCanal.mainCanal.barrage');

        $barrages = Barrage::orderBy('name')->get(['id', 'name']);
        $barrageId = $branchCanal->subCanal->mainCanal->barrage_id;
        $mainCanalId = $branchCanal->subCanal->main_canal_id;
        $mainCanals = MainCanal::where('barrage_id', $barrageId)->orderBy('name')->get(['id', 'name']);
        $subCanals = SubCanal::where('main_canal_id', $mainCanalId)->orderBy('name')->get(['id', 'name']);

        return view('branch-canals.edit', compact('branchCanal', 'barrages', 'mainCanals', 'subCanals', 'barrageId', 'mainCanalId'));
    }

    public function update(Request $request, BranchCanal $branchCanal)
    {
        $validated = $request->validate([
            'barrage_id' => ['required', 'exists:barrages,id'],
            'main_canal_id' => [
                'required',
                Rule::exists('main_canals', 'id')->where(fn ($q) => $q->where('barrage_id', $request->barrage_id)),
            ],
            'sub_canal_id' => [
                'required',
                Rule::exists('sub_canals', 'id')->where(fn ($q) => $q->where('main_canal_id', $request->main_canal_id)),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('branch_canals', 'name')
                    ->where(fn ($q) => $q->where('sub_canal_id', $request->sub_canal_id))
                    ->ignore($branchCanal->id),
            ],
        ]);

        $branchCanal->update([
            'sub_canal_id' => $validated['sub_canal_id'],
            'name' => $validated['name'],
        ]);

        return redirect()->route('branch-canals.index')->with('success', 'Branch canal updated successfully.');
    }

    public function confirmDelete(BranchCanal $branchCanal)
    {
        $branchCanal->load('subCanal.mainCanal.barrage')->loadCount('distributaries');

        return view('branch-canals.delete', compact('branchCanal'));
    }

    public function destroy(BranchCanal $branchCanal)
    {
        $branchCanal->delete();

        return redirect()->route('branch-canals.index')->with('success', 'Branch canal deleted successfully.');
    }

    public function bySubCanal(SubCanal $subCanal)
    {
        $items = BranchCanal::where('sub_canal_id', $subCanal->id)->orderBy('name')->get(['id', 'name']);

        return response()->json($items);
    }
}
