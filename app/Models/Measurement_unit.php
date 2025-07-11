<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Measurement_unit extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'abbreviation'];

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class, 'measurement_unit');
    }
    
}
