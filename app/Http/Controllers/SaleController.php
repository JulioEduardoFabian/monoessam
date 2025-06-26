<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use App\Models\Dinner;
use App\Models\Sale;
use App\Models\Subdealership;
use App\Models\Ticket;
use App\Models\Ticket_detail;
use App\Models\User;
use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
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
     * Verify if the sale is duplicated.
     */

    public function verifySale($cafeId, $dinnerId, $services)
    {
        $sale = Sale::with(['tickets', 'tickets.ticket_details'])
            ->where('cafe_id', $cafeId)
            ->where('date', date('Y-m-d'))
            ->where('dinner_id', $dinnerId)
            ->first();

        if (!$sale) {
            return false;
        }

        // Verificar si hay servicios coincidentes en los detalles del ticket
        if ($sale->tickets->isNotEmpty() && $sale->tickets[0]->ticket_details->isNotEmpty()) {
            $serviceTypes = collect($services)->pluck('service_type')->toArray();

            return $sale->tickets[0]->ticket_details
                ->pluck('service_type')
                ->intersect($serviceTypes)
                ->isNotEmpty();
        }

        return true;
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $services = json_decode($request->services, true);
        $dinner = Dinner::where('dni', $request->dni)->with(['cafe', 'cafe.unit', 'subdealership', 'cafe.businesses'])->first();

        $boolValue = filter_var($request->double_price, FILTER_VALIDATE_BOOLEAN);

        if ($request->sale_type_id == 1) {
            if (!$boolValue) {
                if ($request->cafe_id != $dinner->cafe->id) {
                    return response()->json([
                        'message' => 'El usuario pertenece a otra cafetería: ' . $dinner->cafe->name,
                        'otherCafe' => true
                    ]);
                }
            }

            if ($this->verifySale($request->cafe_id, $dinner->id, $services)) {
                return response()->json([
                    'message' => 'Venta ya registrada a este usuario.'
                ], 404);
            }
        }

        $cafe = Cafe::find($request->cafe_id);
        $cafe->load(['businesses']);
        $services = json_decode($request->services, true);

        $total = array_reduce($services, function ($carry, $service) {
            return $carry + $service['price'];
        }, 0);

        if ($request->double_price) {
            $total *= 2;
        }

        $date = date('Y-m-d H:i:s');

        $sale = Sale::create([
            'dinner_id' => $dinner->id,
            'cafe_id' => $request->cafe_id,
            'date' => $request->date,
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
            'total_igv' => $total * 0.18,
            'total_icsc' => 0.0,
            'total_other_taxes' => 0.0,
            'total_other_charges' => 0.0,
            'total' => $total,
            'status' => 1
        ]);

        if ($request->receipt_type == 1) {
            $ticket = Ticket::create([
                'sale_id' => $sale->id,
                'dinner_id' => $dinner->id,
                'dinner_name' => $dinner->name,
                'dni' => $request->dni,
                'subdealership_name' => $dinner->subdealership['name'],
                'serial_number' => 'T00',
                'subdealership_ruc' => $dinner->subdealership['ruc'],
                'price_value' => $sale->total,
                'igv' => $sale->total_igv,
                'status' => 1
            ]);

            if ($ticket) {
                foreach ($services as $service) {
                    $ticket_detail = Ticket_detail::create([
                        'ticket_id' => $ticket->id,
                        'service_id' => $service['serviceID'],
                        'code' => $service['code'],
                        'service_name' => $service['name'],
                        'amount' => $service['quantity'],
                        'um' => 'UNI',
                        'service_type' => $service['serviceID'],
                        'description' => '',
                        'unit_value' => $service['price'],
                        'unit_price' => $service['unit_price'],
                        'sale_value' => $service['price'],
                        'igv' => $service['price'] * 0.18,
                        'total' => $service['price']
                    ]);
                }
            }
        }

        $newTicket = $ticket->load(['ticket_details']);

        $this->printTest($newTicket, $dinner->cafe->businesses[0]);

        return response()->json([
            'dinner' => $dinner,
            'ticket' => $ticket ?? null,
            'message' => 'Venta registrada correctamente.',
        ], 200);
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

    public function printTest($ticket, $business)
    {

        try {
            $nombreImpresora = "EPSON TM-T20II Receipt";
            $connector = new WindowsPrintConnector($nombreImpresora);
            $printer = new Printer($connector);


            // Ticket header
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("--------------------------------\n");
            $printer->text($business->legal_address . "\n");
            $printer->text("RUC: " . $business->ruc . "\n");
            /* $printer->text($ticket->subdealership_name . "\n"); */
            $printer->text("TICKET DE VENTA\n");
            $printer->text("--------------------------------\n");

            // Sale details
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("N° Ticket: " . $ticket->id . "\n");
            $printer->text("Fecha: " . date('d/m/Y h:i') . "\n");
            $printer->text("--------------------------------\n");

            // Client information
            $printer->text("Cliente: " . $ticket->dinner_name . "\n");
            $printer->text("DNI: " . $ticket->dni . "\n");
            $printer->text("--------------------------------\n");

            // Product details
            $printer->text("Producto/Servicio:\n");
            foreach ($ticket->ticket_details as $detail) {
                $printer->text($detail->service_name . " - Cantidad: " . $detail->amount . "\n");
                $printer->text("--------------------------------\n");
            }

            // Footer
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("Gracias por su compra!\n");
            $printer->text("--------------------------------\n");

            $printer->cut();
            $printer->close();

            return response()->json(['success' => 'Ticket impreso correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al imprimir: ' . $e->getMessage()]);
        }
    }
}
