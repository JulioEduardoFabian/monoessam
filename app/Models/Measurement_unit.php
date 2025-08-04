<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Measurement_unit extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'abbreviation'];

    public function ingredients(): HasMany
    {
        return $this->hasMany(Ingredient::class, 'measurement_unit_id');
    }
    public function calories(): HasMany
    {
        return $this->hasMany(Calorie::class, 'measurement_unit_id');
    }
    public function gross_weights(): HasMany
    {
        return $this->hasMany(Gross_weight::class, 'measurement_unit_id');
    }
    public function net_weights(): HasMany
    {
        return $this->hasMany(Net_weight::class, 'measurement_unit_id');
    }
    public function solid_wastes(): HasMany
    {
        return $this->hasMany(Solid_waste::class, 'measurement_unit_id');
    }
    public function liquid_wastes():HasMany
    {
        return $this->hasMany(Liquid_waste::class, 'measurement_unit_id');  
    }    
    public function ingredient_city_providers():HasMany
    {
        return $this->hasMany(Ingredient_city_provider::class, 'measurement_unit_id');
    }
}
