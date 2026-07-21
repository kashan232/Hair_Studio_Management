<?php

namespace App\Http\Controllers;

use App\Models\Chair;
use Illuminate\Http\Request;

class ChairController extends Controller
{
    public function index()
    {
        $chairs = Chair::orderBy('id', 'desc')->get();
        return view('chairs.index', compact('chairs'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:chairs,name',
            'type' => 'required|string|in:Hair,Makeup,Wash,Other',
        ]);

        Chair::create([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'status' => 'available',
        ]);

        return response()->json([
            'success' => 'Chair added successfully to the studio.',
            'redirect' => route('chairs.index')
        ]);
    }


    public function update(Request $request, $id)
    {
        $chair = Chair::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:chairs,name,' . $chair->id,
            'type' => 'required|string|in:Hair,Makeup,Wash,Other',
            'status' => 'required|in:available,booked',
        ]);

        $chair->update([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'status' => $request->input('status'),
        ]);

        return response()->json([
            'success' => 'Chair details updated successfully.',
            'redirect' => route('chairs.index')
        ]);
    }

    public function destroy($id)
    {
        try {
            $chair = Chair::findOrFail($id);

            // Clear pivot links first (safe even if FK cascade exists)
            $chair->bookings()->detach();
            $chair->delete();

            return response()->json([
                'success' => 'Chair removed successfully from the studio.',
                'redirect' => route('chairs.index'),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Unable to delete chair. It may be linked to existing records.',
            ], 422);
        }
    }
}
