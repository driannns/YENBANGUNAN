<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RedeemItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\RedeemItem::create([
            'name' => 'Semen 1kg',
            'description' => 'Semen berkualitas tinggi untuk konstruksi',
            'points_required' => 5000,
            'unit' => 'kg',
            'is_active' => true,
        ]);

        \App\Models\RedeemItem::create([
            'name' => 'Paku 1kg',
            'description' => 'Paku berbagai ukuran untuk keperluan konstruksi',
            'points_required' => 2500,
            'unit' => 'kg',
            'is_active' => true,
        ]);

        \App\Models\RedeemItem::create([
            'name' => 'Cat Tembok 1 liter',
            'description' => 'Cat tembok interior/eksterior berkualitas',
            'points_required' => 8000,
            'unit' => 'liter',
            'is_active' => true,
        ]);

        \App\Models\RedeemItem::create([
            'name' => 'Kabel Listrik 10 meter',
            'description' => 'Kabel listrik berbagai ukuran',
            'points_required' => 3000,
            'unit' => 'meter',
            'is_active' => true,
        ]);

        \App\Models\RedeemItem::create([
            'name' => 'Pipa PVC 2 inch',
            'description' => 'Pipa PVC untuk instalasi air',
            'points_required' => 6000,
            'unit' => 'pcs',
            'is_active' => true,
        ]);
    }
}
