<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Level extends Model
{
    
    use HasFactory;
    protected $fillable = ['name'];  
    public function dishes(): BelongsToMany
    {
        return $this->belongsToMany(Dish::class);
    }
}
