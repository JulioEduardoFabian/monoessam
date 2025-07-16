<?php

namespace App\Http\Controllers;

use App\Events\SessionEnded;
use App\Models\Area;
use App\Models\Cafe;
use App\Models\Headquarter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('users/Index', [
            'users' => User::with(['roles'])->get(),
            'roles' => Role::with(['permissions', 'users'])->get(),
            'permissions' => Permission::all(),
            'areas' => Area::with(['headquarter', 'cafe', 'cafe.unit', 'roles', 'roles.users', 'areaRoles'])->get(),
            'cafes' => Cafe::with(['areas', 'areas.cafe', 'areas.headquarter', 'areas.areaRoles', 'areas.users.roles', 'areas.users.roles.permissions', 'areas.roles.permissions'])->get(),
            'headquarters' => Headquarter::with(['areas', 'areas.users.roles', 'areas.areaRoles', 'areas.users.roles.permissions', 'areas.roles.permissions', 'business'])->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $role = Role::find($request->role_id);

        $user->syncRoles([$role->name]);

        $user->roleAreas()->attach($request->role_id, [
            'area_id' => $request->area_id
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
        //
    }

    public function blacklist(string $id)
    {
        $user = User::find($id);

        $user->update([
            'type' => 2
        ]);
    }

    public function banUser(string $id)
    {
        $user = User::find($id);

        if ($user) {
            $user->update([
                'type' => 3,
                'password' => Hash::make('lindltaylor7@gmail.com') // Reset password to a default value
            ]);
        }

        event(new SessionEnded($id));

        return to_route('users');
    }
}
