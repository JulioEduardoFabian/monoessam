<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Staff extends Model
{
    /** @use HasFactory<\Database\Factories\StaffFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'dni',
        'cell',
        'birthdate',
        'age',
        'sex',
        'email',
        'country',
        'civilstatus',
        'contactname',
        'contactcell',
        'status',
        'cafe_id',
        'role_id'
    ];

    public function staff_files(): HasMany
    {
        return $this->hasMany(Staff_file::class);
    }

    public function observations(): HasMany
    {
        return $this->hasMany(Observation::class);
    }

    public function cafe(): BelongsTo
    {
        return $this->belongsTo(Cafe::class);
    }
}
