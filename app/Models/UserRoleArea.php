<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Models\Role;

class UserRoleArea extends Model
{

    protected $table = 'user_role_area';

    protected $fillable = [
        'user_id',
        'role_id',
        'area_id',
    ];

    // Ejemplo: Si necesitas acceder al rol desde el pivot
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    // Ejemplo: Si necesitas acceder al área desde el pivot
    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }
    // Ejemplo: Si necesitas acceder al área desde el pivot
    public function user(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }
}
