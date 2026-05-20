<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('roleRelation');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('designation', 'like', "%{$search}%");
            });
        }

        // Role filter
        if ($request->filled('role')) {
            $query->where('role_id', $request->input('role'));
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $users = $query->orderBy('id', 'desc')->get();
        $roles = Role::all();

        return view('users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role_id' => 'required|exists:roles,id',
            'designation' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:20',
            'cnic' => 'nullable|string|max:20',
            'status' => 'required|integer',
        ]);

        $data = $request->except('password');
        $data['password'] = Hash::make($request->input('password'));
        $data['joining_date'] = date('Y-m-d');

        // Sync legacy string role column
        $role = Role::find($request->input('role_id'));
        $data['role'] = str_replace('-', '_', $role->slug);

        // Set default avatar
        $data['avatar'] = 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150';

        User::create($data);

        return response()->json([
            'success' => 'User account created successfully.',
            'redirect' => route('users.index')
        ]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'role_id' => 'required|exists:roles,id',
            'designation' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:20',
            'cnic' => 'nullable|string|max:20',
            'status' => 'required|integer',
        ]);

        $data = $request->except('password');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }

        // Sync legacy string role column
        $role = Role::find($request->input('role_id'));
        $data['role'] = str_replace('-', '_', $role->slug);

        $user->update($data);

        return response()->json([
            'success' => 'User account updated successfully.',
            'redirect' => route('users.index')
        ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent Super Admin self-deletion
        if ($user->id === auth()->id()) {
            return response()->json([
                'error' => 'You cannot delete your own logged-in account.'
            ]);
        }

        $user->delete();

        return response()->json([
            'success' => 'User account deleted successfully.',
            'redirect' => route('users.index')
        ]);
    }
}
