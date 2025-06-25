<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Service extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'code', 'description'];

    public function businesses(): BelongsToMany
    {
        return $this->belongsToMany(Business::class);
    }
    public function mines(): MorphToMany
    {
        return $this->morphedByMany(Mine::class, 'serviceable');
    }
    public function units(): MorphToMany
    {
        return $this->morphedByMany(Unit::class, 'serviceable');
    }
    public function cafes(): MorphToMany
    {
        return $this->morphedByMany(Cafe::class, 'serviceable');
    }
}
