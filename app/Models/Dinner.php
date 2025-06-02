<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dinner extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'dni', 'phone','subdealership_id','cafe_id'];
    /**
     * Get the subdealership that owns the dinner.
     */
    public function subdealership(): BelongsTo
    {
        return $this->belongsTo(Subdealership::class);
    }
    
    public function cafe(): BelongsTo
    {
        return $this->belongsTo(Cafe::class);
    }
}
