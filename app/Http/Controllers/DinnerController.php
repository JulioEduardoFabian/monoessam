<?php

namespace App\Http\Controllers;

use App\Imports\DinnersImport;
use App\Models\Area;
use App\Models\Cafe;
use App\Models\Dinner;
use App\Models\Service;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class DinnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $user = User::with(['roles.areas' => function ($query) {
            $query->select('areas.id', 'areas.name', 'cafe_id');
        }])->find($user->id);

        return $user;

        $roles = $user->roles;

        $cafes =  [];

        foreach ($roles as $role) {
            foreach ($role->areas as $area) {
                if ($area->cafe_id) {
                    $cafes[] = $area->cafe;
                }
            }
        }
        return Inertia::render('dinners/Index', [
            'dinners' => Dinner::with('cafe')->get(),
            'services' => Service::all(),
            'units' => Unit::with('services')->get(),
            'cafes' => $cafes
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

    public function search(string $word, string $id)
    {
        $dinners = Dinner::where('name', 'like', '%' . $word . '%')->where('cafe_id', $id)->orWhere('dni', 'like', '%' . $word . '%')->with(['cafe', 'cafe.unit', 'subdealership'])->take(8)->get();
        return $dinners;
    }

    public function excel(Request $request)
    {

        if ($request->hasFile('file')) {

            $fileName = time() . '.' . $request->file->getClientOriginalExtension();
            $fileSaved = $request->file->move(public_path('files'), $fileName);

            Excel::import(new DinnersImport, $fileSaved);

            return redirect()->back()->with('success', 'Archivo subido correctamente');
        }

        return redirect()->back()->with('error', 'No se pudo subir el archivo');
    }
}
