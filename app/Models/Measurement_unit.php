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
        return $this->hasMany(Ingredient::class, 'measurement_unit_id');
    }
    public function calories()
    {
        return $this->hasMany(Calorie::class, 'measurement_unit_id');
    }
    public function gross_weights()
    {
        return $this->hasMany(Gross_weight::class, 'measurement_unit_id');
    }
    public function net_weights()
    {
        return $this->hasMany(Net_weight::class, 'measurement_unit_id');
    }
    public function solid_wastes()
    {
        return $this->hasMany(Solid_waste::class, 'measurement_unit_id');
    }
    public function liquid_wastes()
    {
        return $this->hasMany(Liquid_waste::class, 'measurement_unit_id');  
    }    
}
