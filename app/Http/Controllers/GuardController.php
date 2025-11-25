<?php

namespace App\Http\Controllers;

use App\Models\Guard;
use App\Http\Requests\StoreGuardRequest;
use App\Http\Requests\UpdateGuardRequest;
use Illuminate\Http\Request;

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
        $guards = $request->guards;

        foreach ($guards as $guardData) {
            Guard::create([
                'cafe_id' => $request->cafe_id,
                'name' => $guardData['name'],
            ]);
        }

        return redirect()->route('users');
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

        $guard->roles()->sync($request->roles_ids);

        return redirect()->route('users');
    }
}
