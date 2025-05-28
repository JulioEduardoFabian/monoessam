<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Business extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function headquarters(): HasMany
    {
        return $this->hasMany(Headquarter::class);
    }
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }
    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }
}
