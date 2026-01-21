<?php

namespace Database\Seeders;

use App\Models\LoyaltyFormula;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoyaltyFormulaSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create one loyalty formula with value 1.0
        LoyaltyFormula::create([
            'coefficient' => 0.1,
        ]);
    }
}