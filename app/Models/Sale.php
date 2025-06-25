<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;  
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Sale extends Model
{
    use HasFactory;
    protected $fillable = ['dinner_id','cafe_id','date','total','discount','payment_method','payment_status','user_id'];
    
    public function cafe(): BelongsTo
    {
        return $this->belongsTo(Cafe::class);
    }
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
    public function sale_details(): HasMany
    {
        return $this->hasMany(Sale_detail::class);
    }
    public function dinner(): BelongsTo
    {
        return $this->belongsTo(Dinner::class);
    }
}
