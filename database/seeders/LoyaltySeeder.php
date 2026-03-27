<?php

namespace Database\Seeders;

use App\Models\LoyaltyFormula;
use App\Models\LoyaltyHistory;
use App\Models\Order;
use App\Models\RedeemHistory;
use App\Models\RedeemItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoyaltySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = User::where('is_admin', false)
            ->where('is_manager', false)
            ->get();

        $minimumLoyaltyPoint = 100000;

        $formula = LoyaltyFormula::first();
        $coefficient = $formula ? $formula->coefficient : 0.1;
        $redeemItems = RedeemItem::all();

        foreach ($customers as $customer) {
            $orders = Order::where('user_id', $customer->id)
                ->orderBy('order_date')
                ->get();

            $totalPoints = 0;

            if ($orders->isNotEmpty()) {
                foreach ($orders as $order) {
                    $orderDate = Carbon::parse($order->order_date);
                    $expiredAt = $this->calculateExpiredAtForDate($orderDate);
                    $pointsEarned = round($order->total_amount * $coefficient, 2);

                    LoyaltyHistory::create([
                        'order_id' => $order->id,
                        'user_id' => $customer->id,
                        'points_earned' => $pointsEarned,
                        'expired_at' => $expiredAt,
                        'type' => 'plus_point',
                        'created_at' => $orderDate,
                        'updated_at' => $orderDate,
                    ]);

                    $totalPoints += $pointsEarned;
                }
            }

            if ($totalPoints < $minimumLoyaltyPoint) {
                $additionalPoints = $minimumLoyaltyPoint - $totalPoints;
                $topUpDate = $orders->isNotEmpty()
                    ? Carbon::parse($orders->last()->order_date)->addDay()
                    : now();

                LoyaltyHistory::create([
                    'order_id' => null,
                    'user_id' => $customer->id,
                    'points_earned' => $additionalPoints,
                    'expired_at' => $this->calculateExpiredAtForDate($topUpDate),
                    'type' => 'plus_point',
                    'created_at' => $topUpDate,
                    'updated_at' => $topUpDate,
                ]);

                $totalPoints += $additionalPoints;
            }

            if ($redeemItems->isEmpty()) {
                continue;
            }

            $availableRedeemPoints = $totalPoints - $minimumLoyaltyPoint;
            if ($availableRedeemPoints <= 0) {
                continue;
            }

            $minPoints = $redeemItems->min('points_required');
            if ($availableRedeemPoints < $minPoints) {
                continue;
            }

            $redeemCount = rand(1, 2);
            $baseDate = $orders->isNotEmpty()
                ? Carbon::parse($orders->last()->order_date)->addDays(rand(1, 20))
                : now()->addDays(rand(1, 20));

            for ($i = 0; $i < $redeemCount; $i++) {
                $availableRedeemPoints = $totalPoints - $minimumLoyaltyPoint;
                if ($availableRedeemPoints <= 0) {
                    break;
                }

                $eligibleItems = $redeemItems->filter(function ($item) use ($availableRedeemPoints) {
                    return $item->points_required <= $availableRedeemPoints;
                });

                if ($eligibleItems->isEmpty()) {
                    break;
                }

                $item = $eligibleItems->random();
                $maxQty = intdiv((int) $availableRedeemPoints, (int) $item->points_required);
                $quantity = rand(1, max(1, min(2, $maxQty)));
                $pointsUsed = $item->points_required * $quantity;
                $redeemAt = (clone $baseDate)->addDays($i);

                RedeemHistory::create([
                    'user_id' => $customer->id,
                    'redeem_item_id' => $item->id,
                    'quantity' => $quantity,
                    'points_used' => $pointsUsed,
                    'status' => 'redeemed',
                    'processed_at' => $redeemAt,
                    'created_at' => $redeemAt,
                    'updated_at' => $redeemAt,
                ]);

                $expiredAt = $this->calculateExpiredAtForDate($redeemAt);
                LoyaltyHistory::create([
                    'order_id' => null,
                    'user_id' => $customer->id,
                    'points_earned' => -1 * $pointsUsed,
                    'expired_at' => $expiredAt,
                    'type' => 'redeem',
                    'created_at' => $redeemAt,
                    'updated_at' => $redeemAt,
                ]);

                $totalPoints -= $pointsUsed;
            }
        }
    }

    /**
     * Calculate expired_at based on a given date.
     */
    private function calculateExpiredAtForDate($date)
    {
        $targetYear = 2026;

        if ($date->month <= 6) {
            return Carbon::create($targetYear, 6, 1)->endOfMonth();
        } else {
            return Carbon::create($targetYear, 12, 31);
        }
    }
}