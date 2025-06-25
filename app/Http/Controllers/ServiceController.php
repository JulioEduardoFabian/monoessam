<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('services/Index', [
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
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required',
            'description' => 'nullable|string|max:1000',
        ]);

        Service::create($request->only('name', 'code', 'description'));

        return to_route('businesses');
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

    public function updatePrices(Request $request)
    {
        $services = $request->services;

        foreach ($services as $service) {
            $cafe = Cafe::find($service['pivot']['serviceable_id']);
            if ($cafe) {
                $cafe->services()->updateExistingPivot($service['id'], ['price' => $service['pivot']['price']]);
            }
        }

        return to_route('dinners');
    }
}
