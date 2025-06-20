<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use App\Models\Dinner;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;

class SaleController extends Controller
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
     * Verify if the user exits and the side that own.
     */
    public function verifyUser($dni, $cafeId)
    {
        $dinner = Dinner::where('dni', $dni)->first();

        if ($dinner) {
            $cafe = Cafe::find($cafeId);
            if ($cafe) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($this->verifyUser($request->dni, $request->cafe_id) == false) {
            return response()->json([
                'message' => 'No se encuentra el usuario o no pertenece a esta cafetería.'
            ], 404);
        } else {
            $cafe = Cafe::find($request->cafe_id);
            $cafe->load(['businesses']);
            $services = json_decode($request->services, true);

            $total = array_reduce($services, function ($carry, $service) {
                return $carry + $service['price'];
            }, 0);

            $date = date('Y-m-d H:i:s');
            $sale = Sale::create([
                'cafe_id' => $request->cafe_id,
                'date' => $date,
                'serial_number' => 'F00',
                'sale_type_id' => $request->sale_type_id,
                'payment_method_id' => null,
                'business_id' =>  $cafe->businesses[0]->id,
                'total_discounts' => 0.0,
                'total_non_taxable_operations' => 0.0,
                'total_taxable_operations' => 0.0,
                'total_unaffected_operations' => 0.0,
                'total_exonerated_operations' => 0.0,
                'total_exported_operations' => 0.0,
                'total_igv' => 0.0,
                'total_icsc' => 0.0,
                'total_other_taxes' => 0.0,
                'total_other_charges' => 0.0,
                'total' => $total,
                'status' => 1
            ]);

            $dinner = Dinner::where('dni', 'like', '%' . $request->dni . '%')->with(['cafe', 'cafe.unit', 'subdealership'])->first();
            //$this->printTest();

            return response()->json([
                'dinner' => $dinner,
                'message' => 'Venta registrada correctamente.',
            ], 200);
        }
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
