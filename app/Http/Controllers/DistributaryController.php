<?php

namespace App\Http\Controllers;

use App\Models\Barrage;
use App\Models\BranchCanal;
use App\Models\Distributary;
use App\Models\MainCanal;
use App\Models\SubCanal;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DistributaryController extends Controller
{
    public function index()
    {
        $distributaries = Distributary::with('branchCanal.subCanal.mainCanal.barrage')->withCount('minors')->orderBy('name')->paginate(15);

        return view('distributaries.index', compact('distributaries'));
    }

    public function create()
    {
        $barrages = Barrage::orderBy('name')->get(['id', 'name']);

        return view('distributaries.create', compact('barrages'));
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
            'branch_canal_id' => [
                'required',
                Rule::exists('branch_canals', 'id')->where(fn ($q) => $q->where('sub_canal_id', $request->sub_canal_id)),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('distributaries', 'name')->where(fn ($q) => $q->where('branch_canal_id', $request->branch_canal_id)),
            ],
        ]);

        Distributary::create([
            'branch_canal_id' => $validated['branch_canal_id'],
            'name' => $validated['name'],
        ]);

        return redirect()->route('distributaries.index')->with('success', 'Distributary created successfully.');
    }

    public function show(Distributary $distributary)
    {
        $distributary->load('branchCanal.subCanal.mainCanal.barrage')->loadCount('minors');

        return view('distributaries.show', compact('distributary'));
    }

    public function edit(Distributary $distributary)
    {
        $distributary->load('branchCanal.subCanal.mainCanal.barrage');

        $barrages = Barrage::orderBy('name')->get(['id', 'name']);
        $barrageId = $distributary->branchCanal->subCanal->mainCanal->barrage_id;
        $mainCanalId = $distributary->branchCanal->subCanal->main_canal_id;
        $subCanalId = $distributary->branchCanal->sub_canal_id;
        $mainCanals = MainCanal::where('barrage_id', $barrageId)->orderBy('name')->get(['id', 'name']);
        $subCanals = SubCanal::where('main_canal_id', $mainCanalId)->orderBy('name')->get(['id', 'name']);
        $branchCanals = BranchCanal::where('sub_canal_id', $subCanalId)->orderBy('name')->get(['id', 'name']);

        return view('distributaries.edit', compact(
            'distributary',
            'barrages',
            'mainCanals',
            'subCanals',
            'branchCanals',
            'barrageId',
            'mainCanalId',
            'subCanalId'
        ));
    }

    public function update(Request $request, Distributary $distributary)
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
            'branch_canal_id' => [
                'required',
                Rule::exists('branch_canals', 'id')->where(fn ($q) => $q->where('sub_canal_id', $request->sub_canal_id)),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('distributaries', 'name')
                    ->where(fn ($q) => $q->where('branch_canal_id', $request->branch_canal_id))
                    ->ignore($distributary->id),
            ],
        ]);

        $distributary->update([
            'branch_canal_id' => $validated['branch_canal_id'],
            'name' => $validated['name'],
        ]);

        return redirect()->route('distributaries.index')->with('success', 'Distributary updated successfully.');
    }

    public function confirmDelete(Distributary $distributary)
    {
        $distributary->load('branchCanal.subCanal.mainCanal.barrage')->loadCount('minors');

        return view('distributaries.delete', compact('distributary'));
    }

    public function destroy(Distributary $distributary)
    {
        $distributary->delete();

        return redirect()->route('distributaries.index')->with('success', 'Distributary deleted successfully.');
    }

    public function byBranchCanal(BranchCanal $branchCanal)
    {
        $items = Distributary::where('branch_canal_id', $branchCanal->id)->orderBy('name')->get(['id', 'name']);

        return response()->json($items);
    }
}
