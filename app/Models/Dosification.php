<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Dosification extends Model
{
    use HasFactory;
    protected $fillable = ['ingredient_id', 'energy', 'water', 'protein', 'lipid', 'carbohydrate','fiber','ash','calcium','phophorus','iron','retinol','thiamine','riboflavin','niacin','a_asc','sodium','potassium'];
    public function ingredient(): BelongsTo
    {
        return $this->belongsTo(Ingredient::class);
    }
}
