<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\UserPackage;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        $userPackages = UserPackage::with(['user', 'package'])->latest()->get();
        return view('admin.packages.index', compact('packages', 'userPackages'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'hours' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:0',
            'is_active' => 'boolean',
            'expiry_days' => 'nullable|integer|min:1',
        ]);

        Package::create($validated + ['is_active' => $request->has('is_active')]);
        return redirect()->route('admin.packages.index')->with('success', 'Package created successfully.');
    }

    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'hours' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:0',
            'expiry_days' => 'nullable|integer|min:1',
        ]);

        $package->update($validated + ['is_active' => $request->has('is_active')]);
        return redirect()->route('admin.packages.index')->with('success', 'Package updated successfully.');
    }

    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->route('admin.packages.index')->with('success', 'Package deleted successfully.');
    }
}
