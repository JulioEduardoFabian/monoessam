<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
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
            $printer->text("SOY DIEGO\n");
            $printer->text("SOY DIEGO\n");
            $printer->text("SOY DIEGO\n");
            $printer->text("SOY DIEGO\n");
            $printer->text("SOY DIEGO\n");
            $printer->text("SOY DIEGO\n");
            $printer->text("SOY DIEGO\n");
            $printer->text("SOY DIEGO\n");
            $printer->cut();
            $printer->close();

            return response()->json(['success' => 'Ticket impreso correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al imprimir: ' . $e->getMessage()]);
        }
    }
}
