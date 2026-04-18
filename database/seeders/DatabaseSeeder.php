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
        User::updateOrCreate(
            ['email' => 'kurniawan.se@gmail.com'],
            [
                'name' => 'Kurniawan',
                'password' => \Illuminate\Support\Facades\Hash::make('5@8@12Yaa'),
                'role' => 'superadmin',
            ]
        );
    }
}
