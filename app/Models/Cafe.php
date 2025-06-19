<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
class Cafe extends Model
{
     use HasFactory;
    protected $fillable = ['name', 'unit_id'];


    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
    public function dinners(): HasMany
    {
        return $this->hasMany(Dinner::class);
    }
    public function services(): MorphToMany
    {
        return $this->morphToMany(Service::class, 'serviceable');
    }
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'cafe_user');
    }
    public function areas(): HasMany
    {
        return $this->hasMany(Area::class);
    }
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
    public function businesses(): MorphToMany
    {
        return $this->morphToMany(Business::class, 'businessable');
    }
}
