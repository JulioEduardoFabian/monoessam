<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Ticket_detail extends Model
{
    use HasFactory;
    protected $fillable = ['ticket_id','service_id','code','service_name','amount','um','service_type','description','unit_value','unit_price','sale_value','igv','total',];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
}
