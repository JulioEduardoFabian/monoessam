<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Models\Role;

class Guard extends Model
{
    /** @use HasFactory<\Database\Factories\GuardFactory> */
    use HasFactory;

    protected $fillable = ['name', 'cafe_id'];

    public function roles(): BelongsToMany
    {
        return $this->BelongsToMany(Role::class, 'guard_roles')
            ->using(Guard_role::class)
            ->withPivot('id', 'staff_id');
    }

    public function assignedRoles(): HasMany
    {
        return $this->hasMany(Guard_role::class, 'guard_id', 'id');
    }
}
