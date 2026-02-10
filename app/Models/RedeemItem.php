<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RedeemItem extends Model
{
    protected $fillable = [
        'name',
        'description',
        'points_required',
        'unit',
        'is_active',
        'image_url',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
