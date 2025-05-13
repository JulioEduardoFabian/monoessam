<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dish extends Model
{
        /** @use HasFactory<\Database\Factories\MineFactory> */
    use HasFactory;
    protected $fillable = ['name','description','dish_category_id'];

     public function dish_category(): BelongsTo
    {
        return $this->belongsTo(Dish_category::class);
    }
    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class);
    }
}
