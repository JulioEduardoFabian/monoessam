<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use Illuminate\Http\Request;

class CafeController extends Controller
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
        $cafe = Cafe::create([
            'name' => $request->name,
            'unit_id' => $request->unit_id
        ]);

        return to_route('management');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cafe $cafe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cafe $cafe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cafe $cafe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cafe $cafe)
    {
        //
    }
}
