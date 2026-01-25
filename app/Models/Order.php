<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    protected $fillable = [
        'invoice_number',
        'po_number',
        'total_amount',
        'order_date',
        'user_id',
        'status',
    ];

    protected $casts = [
        'order_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function loyaltyHistories()
    {
        return $this->hasMany(\App\Models\LoyaltyHistory::class);
    }

    public function generateLoyalty()
    {
        // Only generate loyalty for confirmed orders
        if ($this->status !== 'confirmed') {
            return 0;
        }

        $formula = \App\Models\LoyaltyFormula::first();
        if ($formula) {
            $pointsEarned = $this->total_amount * $formula->coefficient;
            $now = Carbon::now();
            $expiredAt = null;

            if ($now->month <= 6) {
                // Jika sebelum atau sama dengan 31 Juni, expired 30 Juni tahun ini
                $expiredAt = Carbon::create($now->year, 6, 30);
            } else {
                // Jika setelah 30 Juni, expired 31 Desember tahun ini
                $expiredAt = Carbon::create($now->year, 12, 31);
            }

            \App\Models\LoyaltyHistory::create([
                'order_id' => $this->id,
                'user_id' => $this->user_id,
                'points_earned' => $pointsEarned,
                'expired_at' => $expiredAt,
            ]);
            return $pointsEarned;
        }
        return 0;
    }
}
