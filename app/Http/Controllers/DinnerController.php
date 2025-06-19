<?php

namespace App\Http\Controllers;

use App\Imports\DinnersImport;
use App\Models\Area;
use App\Models\Cafe;
use App\Models\Dinner;
use App\Models\Sale_type;
use App\Models\Service;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

use function PHPUnit\Framework\isArray;

class DinnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $user->load(['areas', 'areas.cafe', 'areas.cafe.services']);

        $cafes = [];

        foreach ($user->areas as $area) {
            array_push($cafes, $area->cafe);
        }

        // Cargar todos los datos necesarios en consultas eficientes
        return Inertia::render('dinners/Index', [
            'dinners' => Dinner::with('cafe')->get(),
            'services' => Service::all(),
            'units' => Unit::with('services')->get(),
            'cafes' => $cafes,
            'sale_types' => Sale_type::all()
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
        $dinners = Dinner::where(function ($query) use ($word) {
            $query->where('name', 'like', '%' . $word . '%')
                ->orWhere('dni', 'like', '%' . $word . '%');
        })
            ->where('cafe_id', $id)
            ->with(['cafe', 'cafe.unit', 'subdealership'])
            ->take(8)
            ->get();

        $this->printTest();

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
