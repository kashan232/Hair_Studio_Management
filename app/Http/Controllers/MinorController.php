<?php

namespace App\Http\Controllers;

use App\Models\Barrage;
use App\Models\BranchCanal;
use App\Models\Distributary;
use App\Models\MainCanal;
use App\Models\Minor;
use App\Models\SubCanal;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MinorController extends Controller
{
    public function index()
    {
        $minors = Minor::with('distributary.branchCanal.subCanal.mainCanal.barrage')->withCount('watercourses')->orderBy('name')->paginate(15);

        return view('minors.index', compact('minors'));
    }

    public function create()
    {
        $barrages = Barrage::orderBy('name')->get(['id', 'name']);

        return view('minors.create', compact('barrages'));
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
            'distributary_id' => [
                'required',
                Rule::exists('distributaries', 'id')->where(fn ($q) => $q->where('branch_canal_id', $request->branch_canal_id)),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('minors', 'name')->where(fn ($q) => $q->where('distributary_id', $request->distributary_id)),
            ],
        ]);

        Minor::create([
            'distributary_id' => $validated['distributary_id'],
            'name' => $validated['name'],
        ]);

        return redirect()->route('minors.index')->with('success', 'Minor created successfully.');
    }

    public function show(Minor $minor)
    {
        $minor->load('distributary.branchCanal.subCanal.mainCanal.barrage')->loadCount('watercourses');

        return view('minors.show', compact('minor'));
    }

    public function edit(Minor $minor)
    {
        $minor->load('distributary.branchCanal.subCanal.mainCanal.barrage');

        $barrages = Barrage::orderBy('name')->get(['id', 'name']);
        $barrageId = $minor->distributary->branchCanal->subCanal->mainCanal->barrage_id;
        $mainCanalId = $minor->distributary->branchCanal->subCanal->main_canal_id;
        $subCanalId = $minor->distributary->branchCanal->sub_canal_id;
        $branchCanalId = $minor->distributary->branch_canal_id;
        $mainCanals = MainCanal::where('barrage_id', $barrageId)->orderBy('name')->get(['id', 'name']);
        $subCanals = SubCanal::where('main_canal_id', $mainCanalId)->orderBy('name')->get(['id', 'name']);
        $branchCanals = BranchCanal::where('sub_canal_id', $subCanalId)->orderBy('name')->get(['id', 'name']);
        $distributaries = Distributary::where('branch_canal_id', $branchCanalId)->orderBy('name')->get(['id', 'name']);

        return view('minors.edit', compact(
            'minor',
            'barrages',
            'mainCanals',
            'subCanals',
            'branchCanals',
            'distributaries',
            'barrageId',
            'mainCanalId',
            'subCanalId',
            'branchCanalId'
        ));
    }

    public function update(Request $request, Minor $minor)
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
            'distributary_id' => [
                'required',
                Rule::exists('distributaries', 'id')->where(fn ($q) => $q->where('branch_canal_id', $request->branch_canal_id)),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('minors', 'name')
                    ->where(fn ($q) => $q->where('distributary_id', $request->distributary_id))
                    ->ignore($minor->id),
            ],
        ]);

        $minor->update([
            'distributary_id' => $validated['distributary_id'],
            'name' => $validated['name'],
        ]);

        return redirect()->route('minors.index')->with('success', 'Minor updated successfully.');
    }

    public function confirmDelete(Minor $minor)
    {
        $minor->load('distributary.branchCanal.subCanal.mainCanal.barrage')->loadCount('watercourses');

        return view('minors.delete', compact('minor'));
    }

    public function destroy(Minor $minor)
    {
        $minor->delete();

        return redirect()->route('minors.index')->with('success', 'Minor deleted successfully.');
    }

    public function byDistributary(Distributary $distributary)
    {
        $items = Minor::where('distributary_id', $distributary->id)->orderBy('name')->get(['id', 'name']);

        return response()->json($items);
    }
}
