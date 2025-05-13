<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class Ingredient_category extends Model
{
     /** @use HasFactory<\Database\Factories\MineFactory> */
    use HasFactory;

    protected $fillable = ['name','description'];

    public function ingredients(): HasMany
    {
        return $this->HasMany(Ingredient::class);
    }
}
