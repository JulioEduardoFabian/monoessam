<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Models\Role;

class Area extends Model
{
    /** @use HasFactory<\Database\Factories\AreaFactory> */
    use HasFactory;


    protected $fillable = ['name','headquarter_id'];


    public function roles(): MorphMany
    {
        return $this->morphMany(Role::class, 'roleable');
    }
    public function headquarter()
    {
        return $this->belongsTo(Headquarter::class);
    }
}
