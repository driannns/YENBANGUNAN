<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Run user seeder
        $this->call(UserSeeder::class);

        // Run order seeder
        $this->call(OrderSeeder::class);

        // Run loyalty formula seeder
        $this->call(LoyaltyFormulaSeeder::class);

        // Run redeem item seeder
        $this->call(RedeemItemSeeder::class);

        // Run blog seeders (split into two parts)
        $this->call([Blog::class, BlogPart1::class]);
    }
}
