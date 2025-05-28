<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Addendum extends Model
{
    use HasFactory;

    protected $fillable = ['contract_id'];

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }
}
