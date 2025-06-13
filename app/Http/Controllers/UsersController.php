<?php

namespace App\Http\Controllers;

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
            'users' => User::with(['roles', 'roles.areas', 'roles.areas.headquarter', 'roles.areas.cafe'])->get(),
            'roles' => Role::with(['permissions', 'areas', 'areas.roles', 'areas.headquarter', 'areas.cafe'])->get(),
            'permissions' => Permission::all(),
            'areas' => Area::with(['headquarter', 'cafe', 'cafe.unit', 'roles'])->get(),
            'cafes' => Cafe::with(['areas', 'areas.cafe', 'areas.headquarter', 'areas.roles'])->get(),
            'headquarters' => Headquarter::with(['areas', 'areas.roles'])->get()
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
}
