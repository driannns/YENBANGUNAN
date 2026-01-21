<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateLoyaltyForOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loyalty:generate-for-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate loyalty history for all existing orders that don\'t have one yet';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orders = \App\Models\Order::whereDoesntHave('loyaltyHistories')
            ->where('status', 'confirmed')
            ->get();

        $this->info("Found {$orders->count()} confirmed orders without loyalty history.");

        foreach ($orders as $order) {
            $points = $order->generateLoyalty();
            $this->line("Generated {$points} points for order {$order->invoice_number}");
        }

        $this->info('Loyalty generation completed.');
    }
}
