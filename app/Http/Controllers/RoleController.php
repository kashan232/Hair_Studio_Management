<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('users')->orderBy('id', 'desc')->get();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        Role::create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
        ]);

        return response()->json([
            'success' => 'Role created successfully. Please assign permissions next.',
            'redirect' => route('roles.index')
        ]);
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
        ]);

        $role->update([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
        ]);

        return response()->json([
            'success' => 'Role name updated successfully.',
            'redirect' => route('roles.index')
        ]);
    }

    /**
     * Dedicated view to assign permissions to a role.
     */
    public function assignPermissions($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $assignedPermissions = $role->permissions()->pluck('permissions.id')->toArray();

        return view('roles.assign', compact('role', 'permissions', 'assignedPermissions'));
    }

    /**
     * Save dynamic permission checks to pivot table.
     */
    public function savePermissions(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->permissions()->sync($request->input('permissions', []));

        return response()->json([
            'success' => 'Permissions successfully assigned to ' . $role->name . '.',
            'redirect' => route('roles.index')
        ]);
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        if ($role->slug === 'super-admin') {
            return response()->json([
                'error' => 'You cannot delete the core Super Admin system role.'
            ]);
        }

        $role->delete();

        return response()->json([
            'success' => 'Role deleted successfully.',
            'redirect' => route('roles.index')
        ]);
    }
}
