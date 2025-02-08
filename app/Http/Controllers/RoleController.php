<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('manageRole.listRole', compact('roles'));
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('manageRole.editRole', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $permissions = $request->permissions ?? [];
        $role->syncPermissions($permissions);
        
        return redirect()->route('roles.index')
            ->with('success', 'Role permissions updated successfully');
    }
}