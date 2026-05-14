<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'kurniawan.se@gmail.com'],
            [
                'name' => 'Kurniawan Admin',
                'password' => Hash::make('Admin@2026!'),
                'role' => 'superadmin',
            ]
        );
    }
}
