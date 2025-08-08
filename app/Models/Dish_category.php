<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dish_category extends Model
{
    /** @use HasFactory<\Database\Factories\MineFactory> */
    use HasFactory;

    protected $fillable = ['name', 'description', 'mesearument_unit'];

    public function dishes(): BelongsToMany
    {
        return $this->belongsToMany(Dish::class, 'dish_category_dish', 'dish_category_id', 'dish_id');
    }
    public function serviceables(): BelongsToMany
    {
        return $this->belongsToMany(Serviceable::class, 'dish_category_serviceables', 'dish_category_id', 'serviceable_id')
            ->withPivot('serving_amount', 'measurement_unit_id', 'serving_percentaje', 'lower_limit_cost', 'total_lower_limit_cost', 'upper_limit_cost', 'total_upper_limit_cost')
            ->withTimestamps();
    }
}
