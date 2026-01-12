<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Period extends Model
{
    /** @use HasFactory<\Database\Factories\PeriodFactory> */
    use HasFactory;
    protected $fillable = ['cafe_id', 'start_date', 'end_date'];

    public function staffs(): BelongsToMany
    {
        return $this->belongsToMany(Staff::class, 'period_staffs')->withPivot('status');
    }
}
