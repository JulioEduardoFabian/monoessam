<?php

namespace App\Http\Controllers;

use App\Models\Guard;
use App\Http\Requests\StoreGuardRequest;
use App\Http\Requests\UpdateGuardRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $createdGuards = [];

        $guardsData = $request->guards;

        foreach ($guardsData as $guardData) {
            $guard = Guard::create([
                'cafe_id' => $request->cafe_id,
                'name' => $guardData['name'],
            ]);

            $createdGuards[] = $guard;
        }

        return redirect()->back()->with('newGuards', $createdGuards);
    }

    /**
     * Display the specified resource.
     */
    public function show(Guard $guard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guard $guard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGuardRequest $request, Guard $guard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guard $guard)
    {
        //
    }

    public function insertGuardRoles(Request $request)
    {
        $guard = Guard::find($request->guard_id);

        $guard->roles()->attach($request->roles_ids);

        return redirect()->back();
    }

    public function deleteGuardRoles($roleId)
    {
        DB::table('guard_roles')->where('id', $roleId)->delete();

        //return redirect()->back();
    }

    public function insertGuardRolesUser(Request $request)
    {

        DB::table('guard_roles_user')->insert([
            'guard_role_id' => $request->role_id,
            'user_id' => $request->user_id,
        ]);
    }
}
