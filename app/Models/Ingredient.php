<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ingredient extends Model
{
         /** @use HasFactory<\Database\Factories\MineFactory> */
    use HasFactory;
    protected $fillable = ['name','description','amount','measurement_unit','calories','liquid_waste','solid_waste','ingredient_category_id'];

    public function ingredient_category(): BelongsTo
    {
        return $this->belongsTo(Ingredient_category::class);
    }
    public function dosification(): HasOne
    {
        return $this->hasOne(Dosification::class);
    }
    public function levels(): BelongsToMany
    {
        return $this->belongsToMany(Level::class,'dish_ingredient_levels', 'ingredient_id', 'level_id');
    }
    public function dishes(): BelongsToMany
    {
        return $this->belongsToMany(Dish::class, 'dish_ingredient_levels', 'ingredient_id', 'dish_id');
    }
    public function providers(): BelongsToMany
    {
        return $this->belongsToMany(Provider::class, 'ingredient_city_provider', 'ingredient_id', 'provider_id');
    }
    public function cities(): BelongsToMany
    {
        return $this->belongsToMany(City::class, 'ingredient_city_provider', 'ingredient_id', 'city_id');
    }
}
