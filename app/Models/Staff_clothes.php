<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff_clothes extends Model
{
    /** @use HasFactory<\Database\Factories\StaffClothesFactory> */
    use HasFactory;

    protected $fillable = ['staff_id', 'clothe_name', 'clothing_size'];
}
