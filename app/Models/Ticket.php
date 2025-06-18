<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Ticket extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','cafe_id','area_id','status','total','discount','payment_method','payment_status',];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }
    public function ticket_details(): HasMany
    {
        return $this->hasMany(Ticket_detail::class);
    }

}
