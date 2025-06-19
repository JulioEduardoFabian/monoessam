<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $date = date('Y-m-d H:i:s');
        $sale = Sale::create([
            'cafe_id' => $request->cafe_id,
            'date' => $date,
            'serial_number' => 'F00',
            'sale_type_id' => $request->sale_type_id,
            'business_id' => $request->business_id,
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
            'total' => 0.0,
            'status' => 1
        ]);
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
