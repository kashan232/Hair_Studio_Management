<?php

namespace App\Http\Controllers;

use App\Models\Barrage;
use App\Models\BranchCanal;
use App\Models\Distributary;
use App\Models\MainCanal;
use App\Models\Minor;
use App\Models\SubCanal;
use App\Models\Watercourse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WatercourseController extends Controller
{
    public function index()
    {
        $watercourses = Watercourse::with('minor.distributary.branchCanal.subCanal.mainCanal.barrage')
            ->orderBy('name')
            ->paginate(15);

        return view('watercourses.index', compact('watercourses'));
    }

    public function create()
    {
        $barrages = Barrage::orderBy('name')->get(['id', 'name']);

        return view('watercourses.create', compact('barrages'));
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
            'minor_id' => [
                'required',
                Rule::exists('minors', 'id')->where(fn ($q) => $q->where('distributary_id', $request->distributary_id)),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('watercourses', 'name')->where(fn ($q) => $q->where('minor_id', $request->minor_id)),
            ],
        ]);

        Watercourse::create([
            'minor_id' => $validated['minor_id'],
            'name' => $validated['name'],
        ]);

        return redirect()->route('watercourses.index')->with('success', 'Watercourse created successfully.');
    }

    public function show(Watercourse $watercourse)
    {
        $watercourse->load('minor.distributary.branchCanal.subCanal.mainCanal.barrage');

        return view('watercourses.show', compact('watercourse'));
    }

    public function edit(Watercourse $watercourse)
    {
        $watercourse->load('minor.distributary.branchCanal.subCanal.mainCanal.barrage');

        $barrages = Barrage::orderBy('name')->get(['id', 'name']);
        $barrageId = $watercourse->minor->distributary->branchCanal->subCanal->mainCanal->barrage_id;
        $mainCanalId = $watercourse->minor->distributary->branchCanal->subCanal->main_canal_id;
        $subCanalId = $watercourse->minor->distributary->branchCanal->sub_canal_id;
        $branchCanalId = $watercourse->minor->distributary->branch_canal_id;
        $distributaryId = $watercourse->minor->distributary_id;
        $mainCanals = MainCanal::where('barrage_id', $barrageId)->orderBy('name')->get(['id', 'name']);
        $subCanals = SubCanal::where('main_canal_id', $mainCanalId)->orderBy('name')->get(['id', 'name']);
        $branchCanals = BranchCanal::where('sub_canal_id', $subCanalId)->orderBy('name')->get(['id', 'name']);
        $distributaries = Distributary::where('branch_canal_id', $branchCanalId)->orderBy('name')->get(['id', 'name']);
        $minors = Minor::where('distributary_id', $distributaryId)->orderBy('name')->get(['id', 'name']);

        return view('watercourses.edit', compact(
            'watercourse',
            'barrages',
            'mainCanals',
            'subCanals',
            'branchCanals',
            'distributaries',
            'minors',
            'barrageId',
            'mainCanalId',
            'subCanalId',
            'branchCanalId',
            'distributaryId'
        ));
    }

    public function update(Request $request, Watercourse $watercourse)
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
            'minor_id' => [
                'required',
                Rule::exists('minors', 'id')->where(fn ($q) => $q->where('distributary_id', $request->distributary_id)),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('watercourses', 'name')
                    ->where(fn ($q) => $q->where('minor_id', $request->minor_id))
                    ->ignore($watercourse->id),
            ],
        ]);

        $watercourse->update([
            'minor_id' => $validated['minor_id'],
            'name' => $validated['name'],
        ]);

        return redirect()->route('watercourses.index')->with('success', 'Watercourse updated successfully.');
    }

    public function confirmDelete(Watercourse $watercourse)
    {
        $watercourse->load('minor.distributary.branchCanal.subCanal.mainCanal.barrage');

        return view('watercourses.delete', compact('watercourse'));
    }

    public function destroy(Watercourse $watercourse)
    {
        $watercourse->delete();

        return redirect()->route('watercourses.index')->with('success', 'Watercourse deleted successfully.');
    }

    public function byMinor(Minor $minor)
    {
        $items = Watercourse::where('minor_id', $minor->id)->orderBy('name')->get(['id', 'name']);

        return response()->json($items);
    }
}
