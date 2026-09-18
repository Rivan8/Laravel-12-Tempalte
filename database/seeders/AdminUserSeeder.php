<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed the application's admin user.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'nama_lengkap' => 'Admin',
                'jenis_kelamin' => 'Laki laki',
                'no_hp' => '081234567890',
                'role' => 'Admin',
                'password' => '123456',
                'email_verified_at' => now(),
            ]
        );
    }
}
