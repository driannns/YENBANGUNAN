<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Akun superadmin untuk /admin (creation blog & produk).
     * Idempotent — aman dijalankan ulang.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'yenbangunanadmin'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('yenBangunanSuper4dmin'),
                'is_admin' => true,
                'is_manager' => false,
                'email_verified_at' => now(),
            ]
        );
    }
}
