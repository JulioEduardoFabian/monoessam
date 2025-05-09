<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    protected $fillable = ['name', 'mine_id'];


    public function mine(): BelongsTo
    {
        return $this->belongsTo(Mine::class);
    }

    public function cafes(): HasMany
    {
        return $this->HasMany(Cafe::class);
    }
}
