<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cafe extends Model
{
    protected $fillable = ['name', 'unit_id'];


    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
