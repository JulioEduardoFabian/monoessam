<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Contract extends Model
{
    use HasFactory;

    protected $fillable = ['contract_id','dealership_id'];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
    
    public function dealership(): BelongsTo
    {
        return $this->belongsTo(Dealership::class);
    }
    public function addendums(): HasMany    
    {
        return $this->hasMany(Addendum::class);
    } 
}
