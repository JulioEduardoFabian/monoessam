<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Cafe extends Model
{
     use HasFactory;
    protected $fillable = ['name', 'unit_id'];


    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }

    public function dinners(): HasMany
    {
        return $this->hasMany(Dinner::class);
    }
}
