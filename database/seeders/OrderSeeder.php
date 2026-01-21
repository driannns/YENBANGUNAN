<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get customer users (is_admin = false, is_manager = false)
        $customers = User::where('is_admin', false)
                         ->where('is_manager', false)
                         ->get();

        foreach ($customers as $customer) {
            // Create 2-3 orders per customer
            for ($i = 0; $i < rand(2, 3); $i++) {
                Order::create([
                    'invoice_number' => 'INV-' . strtoupper(Str::random(8)) . '-' . $customer->id,
                    'po_number' => 'PO-' . strtoupper(Str::random(6)) . '-' . $customer->id,
                    'total_amount' => rand(100000, 1000000), // Random amount between 100k to 1M
                    'order_date' => now()->subDays(rand(0, 365)), // Random date within last year
                    'user_id' => $customer->id,
                ]);
            }
        }
    }
}