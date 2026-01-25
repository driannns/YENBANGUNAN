<?php

namespace Database\Seeders;

use App\Models\Loyalty;
use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LoyaltySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users and orders
        $users = User::all();
        $orders = Order::all();

        if ($orders->isEmpty()) {
            return; // No orders to link
        }

        foreach ($users as $user) {
            // Generate a random created_at date within the last year
            $createdAt = now()->subDays(rand(0, 365));

            // Calculate expired_at based on the created_at month
            $expiredAt = $this->calculateExpiredAtForDate($createdAt);

            // Get a random order for this user, or any order if none
            $userOrders = $orders->where('user_id', $user->id);
            $order = $userOrders->isNotEmpty() ? $userOrders->random() : $orders->random();

            Loyalty::create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'points' => rand(0, 1000), // Random points between 0 and 1000
                'expired_at' => $expiredAt,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }
    }

    /**
     * Calculate expired_at based on a given date.
     */
    private function calculateExpiredAtForDate($date)
    {
        if ($date->month <= 6) {
            return Carbon::create($date->year, 6, 30);
        } else {
            return Carbon::create($date->year, 12, 31);
        }
    }
}