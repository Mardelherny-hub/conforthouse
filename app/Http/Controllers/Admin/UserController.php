<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles', 'permissions')->paginate(10);
        //dd($users);
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $users = User::with('roles')->whereNull('deleted_at')->get();
        $roles = Role::all();
        $permissions = Permission::all();
        $user->load('roles', 'permissions');

        return view('admin.users.edit', compact('user', 'roles', 'permissions'));
    }

    public function update(Request $request, User $user)
    {

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
        ]);

        $user->update($request->only('name', 'email'));

        // Convertir IDs de roles a nombres
        if ($request->has('roles')) {
            $roleNames = Role::whereIn('id', $request->roles)->pluck('name')->toArray();
            $user->syncRoles($roleNames);
        }

        // Permisos individuales
        if ($request->has('permissions')) {
            $user->syncPermissions($request->permissions);
        } else {
            $user->syncPermissions([]); // Limpiar si no se envían
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario eliminado correctamente (soft delete).');
    }

    public function trash()
    {
        $users = User::onlyTrashed()->get();

        return view('admin.users.trash', compact('users'));
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('admin.users.trash')->with('success', 'Usuario restaurado correctamente.');
    }

    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();

        return redirect()->route('admin.users.trash')->with('success', 'Usuario eliminado permanentemente.');
    }

}
