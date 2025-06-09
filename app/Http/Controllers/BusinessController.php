<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Headquarter;
use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('businesses/Index', [
            'businesses' => Business::with('services')->get(),
            'headquarters' => Headquarter::with('business')->get(),
            'services' => Service::all()
        ]);
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
        //
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

    public function businessServices(Request $request)
    {

        $business = Business::find($request->businessId);

        $selectedIds = array_map('intval', array_keys(array_filter($request->services)));

        $business->services()->sync($selectedIds);

        return to_route('businesses');
    }
}
