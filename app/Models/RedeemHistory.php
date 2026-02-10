<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RedeemHistory extends Model
{
    protected $fillable = [
        'user_id',
        'redeem_item_id',
        'quantity',
        'points_used',
        'status',
        'notes',
        'processed_at',
    ];

    protected $casts = [
        'processed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function redeemItem()
    {
        return $this->belongsTo(RedeemItem::class);
    }
}
