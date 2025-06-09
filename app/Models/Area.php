<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Models\Role;

class Area extends Model
{
    /** @use HasFactory<\Database\Factories\AreaFactory> */
    use HasFactory;


    protected $fillable = ['name','headquarter_id'];


    public function headquarter()
    {
        return $this->belongsTo(Headquarter::class);
    }
    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }
    
}
