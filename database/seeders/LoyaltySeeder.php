<?php

namespace Database\Seeders;

use App\Models\Loyalty;
use App\Models\User;
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
        // Get all users
        $users = User::all();

        foreach ($users as $user) {
            Loyalty::create([
                'user_id' => $user->id,
                'points' => rand(0, 1000), // Random points between 0 and 1000
            ]);
        }
    }
}