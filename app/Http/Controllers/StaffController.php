<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use App\Models\Staff;
use App\Models\Staff_file;
use App\Models\Staff_financial;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('staff/Index', [
            'cafes' => Cafe::with('unit')->get(),
            'staff' => Staff::with('staff_files')->get(),
            'roles' => Role::all()
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
            'name' => $request->name,
            'dni' => $request->dni,
            'cell' => $request->cell,
            'birthdate' => $request->birthdate,
            'age' => $request->age,
            'sex' => $request->sex,
            'email' => $request->email,
            'country' => $request->country,
            'civilstatus' => $request->civilstatus,
            'contactname' => $request->contactname,
            'contactcell' => $request->contactcell,
            'status' => 0,
            'cafe_id' => $request->cafeId
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $index => $file) {
                // Get the original filename to extract label
                $originalName = $file->getClientOriginalName();
                $chunksName = explode("_", $originalName);

                // Generate a unique filename
                $fileName = time() . '_' . $originalName;
                $filePath = $file->storeAs('files', $fileName, 'public');

                // Extract label from filename or use another method
                // If label is included in filename like "label_originalname.ext"
                $label = 'default'; // Default or extract from filename

                $staff_file = Staff_file::create([
                    'staff_id' => $staff->id,
                    'file_type' => $chunksName[0], // You need to determine this differently
                    'file_path' => $filePath
                ]);
            }
        }

        $staff_financial = Staff_financial::create([
            'staff_id' => $staff->id,
            'district' => $request->district,
            'province' => $request->province,
            'department' => $request->department,
            'start_date' => $request->fechaIngreso,
            'children' => $request->children,
            'afp' => $request->afp,
            'onp' => $request->onp,
            'position' => $request->position,
            'address' => $request->address,
            'account_number' => $request->account_number,
            'system_work' => $request->workSystem,
            'replacement' => $request->replacement,
            'unit_id' => $request->unitId,
            'salary' => $request->salary,
            'observations' => $request->observations,
            'account_number' => $request->cc
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
