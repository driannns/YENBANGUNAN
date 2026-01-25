<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Loyalty extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'points',
        'expired_at',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
    ];

    /**
     * Calculate expired_at based on creation date.
     * If created before June 31, expired on June 30 of the same year.
     * If created after June 30, expired on December 31 of the same year.
     */
    public static function calculateExpiredAt()
    {
        $now = Carbon::now();
        if ($now->month <= 6) {
            return Carbon::create($now->year, 6, 30);
        } else {
            return Carbon::create($now->year, 12, 31);
        }
    }
}
