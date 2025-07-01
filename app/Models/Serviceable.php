<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Serviceable extends Model
{
    use HasFactory;
    protected $fillable = ['serviceable_id','serviceable_type','service_id','price'];
    public function dish_categories(): BelongsToMany
    {
        return $this->belongsToMany(Dish_category::class);
    }


}
