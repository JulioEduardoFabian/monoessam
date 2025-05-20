<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Service extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description'];

    public function businesses()
    {
        return $this->belongsToMany(Business::class);
    }
    public function cafes(): BelongsToMany
    {
        return $this->belongsToMany(Cafe::class);
    }
}
