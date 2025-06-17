<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale_detail extends Model
{
    use HasFactory;
    protected $fillable = ['sale_id','service_id','code','service_name','amount','um','description','unit_value','unit_price','sale_value','igv','total'];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }
}
