<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HairstylistController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'hairstylist');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('specialization', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $stylists = $query->orderBy('id', 'desc')->paginate(10);

        return view('hairstylists.index', compact('stylists'));
    }

    public function create()
    {
        return view('hairstylists.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'mobile' => 'nullable|string|max:20',
            'cnic' => 'nullable|string|max:20',
            'specialization' => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer|min:0|max:50',
            'instagram_handle' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'status' => 'required|integer',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['password', 'avatar']);
        $data['password'] = Hash::make($request->input('password'));
        $data['role'] = 'hairstylist';
        $data['joining_date'] = date('Y-m-d');

        // Handle Avatar Upload
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/avatars'), $filename);
            $data['avatar'] = 'uploads/avatars/' . $filename;
        } else {
            // Default placeholder
            $data['avatar'] = 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150';
        }

        User::create($data);

        return response()->json([
            'success' => 'Stylist registered successfully.',
            'redirect' => route('hairstylists.index')
        ]);
    }

    public function edit($id)
    {
        $stylist = User::where('role', 'hairstylist')->findOrFail($id);
        return view('hairstylists.edit', compact('stylist'));
    }

    public function update(Request $request, $id)
    {
        $stylist = User::where('role', 'hairstylist')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $stylist->id,
            'password' => 'nullable|string|min:6',
            'mobile' => 'nullable|string|max:20',
            'cnic' => 'nullable|string|max:20',
            'specialization' => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer|min:0|max:50',
            'instagram_handle' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'status' => 'required|integer',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['password', 'avatar']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }

        // Handle Avatar Update
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists locally
            if ($stylist->avatar && file_exists(public_path($stylist->avatar)) && strpos($stylist->avatar, 'uploads/') === 0) {
                @unlink(public_path($stylist->avatar));
            }

            $file = $request->file('avatar');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/avatars'), $filename);
            $data['avatar'] = 'uploads/avatars/' . $filename;
        }

        $stylist->update($data);

        return response()->json([
            'success' => 'Stylist profile updated successfully.',
            'redirect' => route('hairstylists.index')
        ]);
    }

    public function destroy($id)
    {
        $stylist = User::where('role', 'hairstylist')->findOrFail($id);
        
        // Delete old avatar if exists locally
        if ($stylist->avatar && file_exists(public_path($stylist->avatar)) && strpos($stylist->avatar, 'uploads/') === 0) {
            @unlink(public_path($stylist->avatar));
        }

        $stylist->delete();

        return response()->json([
            'success' => 'Stylist account deleted successfully.',
            'redirect' => route('hairstylists.index')
        ]);
    }
}
