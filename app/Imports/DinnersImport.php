<?php

namespace App\Imports;

use App\Models\Dinner;
use Maatwebsite\Excel\Concerns\ToModel;

class DinnersImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Dinner([
            'name' => $row['name'] ?? $row[0], // Depende si usas encabezados o no
            'dni' => $row['dni'] ?? $row[1],
            'phone' => $row['phone'] ?? $row[2],
            'subdealership_id' => $row['subdealership_id'] ?? $row[3],
            'cafe_id' => $row['cafe_id'] ?? $row[4],
        ]);
    }
}
