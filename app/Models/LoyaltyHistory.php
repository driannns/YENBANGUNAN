<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltyHistory extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'points_earned',
        'expired_at',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}