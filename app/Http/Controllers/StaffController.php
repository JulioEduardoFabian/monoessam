<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use App\Models\Staff;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('staff/Index', [
            'cafes' => Cafe::with('unit')->get()
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

        $staff = Staff::create([
            'name' => $request->nombre,
            'dni' => $request->documento,
            'cell' => $request->celular,
            'birthdate' => $request->fechaNacimiento,
            'age' => $request->edad,
            'sex' => $request->sexo,
            'email' => $request->email,
            'country' => $request->nacionalidad,
            'civilstatus' => $request->estadoCivil,
            'contactname' => $request->emergenciaNombre,
            'contactcell' => $request->emergenciaTelefono,
            'cafe_id' => $request->cafeId
        ]);


        return $staff;
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
