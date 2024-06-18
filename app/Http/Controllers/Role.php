<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\RoleUser;
use App\Models\PrivateModel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RoleController extends Controller
{
    // Create new role
    public function createRole(Request $request)
    {
        $this->validate($request, [
            'action' => 'required|integer',
        ]);

        $role = new Role();
        $role->action = $request->input('action');
        $role->save();

        return response()->json($role, 201);
    }

    // Assign role to user
    public function assignRole(Request $request)
    {
        $this->validate($request, [
            'private_id' => 'required|exists:private,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $roleUser = new RoleUser();
        $roleUser->private_id = $request->input('private_id');
        $roleUser->role_id = $request->input('role_id');
        $roleUser->save();

        return response()->json($roleUser, 201);
    }

    // Remove role from user
    public function removeRole(Request $request)
    {
        $this->validate($request, [
            'private_id' => 'required|exists:private,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $roleUser = RoleUser::where('private_id', $request->input('private_id'))
                            ->where('role_id', $request->input('role_id'))
                            ->first();

        if (!$roleUser) {
            return response()->json(['message' => 'Role not assigned to user'], 404);
        }

        $roleUser->delete();

        return response()->json(['message' => 'Role removed from user']);
    }

    // Get roles assigned to user
    public function getUserRoles($private_id)
    {
        $roles = RoleUser::where('private_id', $private_id)->with('role')->get();
        return response()->json($roles);
    }
}
