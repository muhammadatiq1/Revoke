<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->paginate(10);
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::orderBy('module')->get();
        $modules = $permissions->groupBy('module');
        return view('roles.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:roles,name|string|max:255',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create($validated);
        
        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }

        return redirect()->route('roles.index')
            ->with('success', "Role '{$role->display_name}' created successfully!");
    }

    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('module')->get();
        $modules = $permissions->groupBy('module');
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        
        return view('roles.edit', compact('role', 'modules', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update($validated);
        $role->permissions()->sync($request->permissions ?? []);

        return redirect()->route('roles.index')
            ->with('success', "Role '{$role->display_name}' updated successfully!");
    }

    public function destroy(Role $role)
    {
        if ($role->name === 'admin') {
            return redirect()->route('roles.index')
                ->with('error', 'Cannot delete the Admin role!');
        }

        $role->delete();
        return redirect()->route('roles.index')
            ->with('success', "Role '{$role->display_name}' deleted successfully!");
    }

    // User role assignment
    public function assignRoles()
    {
        $users = User::with('roles')->paginate(10);
        $roles = Role::all();
        return view('roles.assign-roles', compact('users', 'roles'));
    }

    public function updateUserRoles(Request $request, User $user)
    {
        $validated = $request->validate([
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user->roles()->sync($validated['roles'] ?? []);

        return redirect()->back()
            ->with('success', "Roles for '{$user->name}' updated successfully!");
    }
}
