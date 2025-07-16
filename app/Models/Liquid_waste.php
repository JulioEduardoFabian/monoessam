<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Liquid_waste extends Model
{
    use HasFactory;
    protected $fillable = ['dish_ingredient_level_id','amount','unit_measurement_id','percentage'];
    public function dish_ingredient_level():BelongsTo
    {
        return $this->belongsTo(Dish_ingredient_level::class);
    }
}
