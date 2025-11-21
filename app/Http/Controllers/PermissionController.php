<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('permissions/Index', ['permissions' => Permission::all(), 'roles' => Role::all(), 'users' => User::with('roles', 'roles.permissions', 'permissions')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $permission = Permission::create([
            'name' => $request->name,
            'guard_name' => 'web',
            'sidebar_name' => $request->sidebar_name,
            'route_name' => $request->route_name,
            'icon_class' => $request->icon_class
        ]);

        return to_route('users');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::find($id);

        $permission->delete();

        return to_route('users');
    }

    public function rolePermissions(Request $request)
    {
        $role = Role::find($request->roleId);

        $selectedIds = array_map('intval', array_keys(array_filter($request->permissions)));

        $role->syncPermissions($selectedIds);

        return to_route('users');
    }

    public function roleUser(Request $request)
    {

        $role = Role::find($request->roleId);

        $user = User::find($request->userId);

        $user->syncRoles([$role->name]);

        return to_route('users');
    }

    public function userPermissions(Request $request)
    {
        $user = User::find($request->userId);

        $selectedIds = array_map('intval', array_filter($request->permissions));

        $user->syncPermissions($selectedIds);

        return to_route('permissions');
    }
}
