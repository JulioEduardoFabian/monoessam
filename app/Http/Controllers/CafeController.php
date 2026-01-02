<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

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

        $cafe->businesses()->sync([$request->business_id]);

        return to_route('management');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // 1. Cargar el Café y sus relaciones necesarias.
        // Usamos select(['...']) para obtener solo los campos necesarios de las relaciones anidadas.
        $cafe = Cafe::with([
            'users', // Todos los usuarios del café
            'guards.assignedRoles.role',
            'periods.users'
        ])->find($id);

        // Si el café no existe, devuelve una respuesta adecuada.
        if (!$cafe) {
            return response()->json(['message' => 'Café no encontrado'], 404);
        }

        // --- 2. Extraer IDs de Usuarios Asignados ---

        // Crear una colección plana de todos los AssignedRoles
        $assignedRoles = $cafe->guards->flatMap(function ($guard) {
            return $guard->assignedRoles;
        });

        // Obtener una colección de IDs de usuarios que tienen un rol asignado
        $assignedUserIds = $assignedRoles
            ->filter(fn($role) => $role->user) // Filtra solo los que tienen un usuario
            ->pluck('user.id') // Obtiene solo el ID del usuario
            ->unique() // Asegura que cada ID aparezca una sola vez
            ->toArray(); // Convierte a array simple de IDs para la comparación

        // --- 3. Filtrar Usuarios ---

        // Colección de todos los usuarios pertenecientes al café
        $allUsers = $cafe->staff;

        // Usuarios asignados: aquellos cuyos IDs están en la lista $assignedUserIds
        $assignedUsers = $allUsers->whereIn('id', $assignedUserIds)->values();

        // Usuarios no asignados: aquellos cuyos IDs NO están en la lista $assignedUserIds
        $unassignedUsers = $allUsers->whereNotIn('id', $assignedUserIds)->values();

        // --- 4. Devolver la Respuesta ---

        return response()->json([
            'users' => [
                'assigned' => $assignedUsers,
                'unassigned' => $unassignedUsers,
            ],
            'guards' => $cafe->guards,
            'periods' => $cafe->periods,
            'staff' => $cafe->staff,
        ]);
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

    public function cafeServiceables(Request $request)
    {
        $cafe = Cafe::find($request->placeId);

        $selectedIds = array_map('intval', array_keys(array_filter($request->services)));

        $serviceables = $cafe->services()->sync($selectedIds);

        return to_route('management');
    }

    public function printTest()
    {
        try {
            $nombreImpresora = "EPSON TM-T20II Receipt";

            $connector = new WindowsPrintConnector($nombreImpresora);

            $printer = new Printer($connector);

            $printer->text("Hello World\n");
            $printer->cut();
            $printer->close();

            return response()->json(['success' => 'Ticket impreso correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al imprimir: ' . $e->getMessage()]);
        }
    }
}
