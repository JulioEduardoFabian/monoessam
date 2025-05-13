<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dish_category extends Model
{
    /** @use HasFactory<\Database\Factories\MineFactory> */
    use HasFactory;

    protected $fillable = ['name','description','measurement_unit'];

    public function dishes(): HasMany
    {
        return $this->HasMany(Dish::class);
    }
}
