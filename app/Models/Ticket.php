<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = ['sale_id', 'dinner_id', 'dinner_name', 'dni', 'subdealership_name', 'serial_number', 'subdealership_ruc', 'price_value', 'igv', 'status'];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }
    public function ticket_details(): HasMany
    {
        return $this->hasMany(Ticket_detail::class);
    }

    public function dinner(): BelongsTo
    {
        return $this->belongsTo(Dinner::class);
    }
}
