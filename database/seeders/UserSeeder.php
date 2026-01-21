<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create customers (regular users)
        User::create([
            'name' => 'Customer One',
            'email' => 'customer1@example.com',
            'NIK' => '1234567890123456',
            'phone_number' => '081234567890',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'is_manager' => false,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Customer Two',
            'email' => 'customer2@example.com',
            'NIK' => '1234567890123457',
            'phone_number' => '081234567891',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'is_manager' => false,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Customer Three',
            'email' => 'customer3@example.com',
            'NIK' => '1234567890123458',
            'phone_number' => '081234567892',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'is_manager' => false,
            'email_verified_at' => now(),
        ]);

        // Create Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'NIK' => null, // Admin might not need NIK
            'phone_number' => null, // Admin might not need phone
            'password' => Hash::make('password'),
            'is_admin' => true,
            'is_manager' => false,
            'email_verified_at' => now(),
        ]);

        // Create Manager
        User::create([
            'name' => 'Manager User',
            'email' => 'manager@example.com',
            'NIK' => null, // Manager might not need NIK
            'phone_number' => null, // Manager might not need phone
            'password' => Hash::make('password'),
            'is_admin' => true,
            'is_manager' => true,
            'email_verified_at' => now(),
        ]);
    }
}