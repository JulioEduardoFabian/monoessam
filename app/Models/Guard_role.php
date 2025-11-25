<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Guard_role extends Pivot
{
    protected $table = 'guard_roles';

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'guard_roles_user', // Tabla pivote final
            'guard_role_id',    // FK en la tabla pivote (hacia guard_roles)
            'user_id'           // FK del modelo objetivo (hacia users)
        )->withPivot('id'); // Puedes añadir más pivotes si es necesario
    }
}
