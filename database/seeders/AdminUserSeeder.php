<?php
// File: database/seeders/AdminUserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::truncate();

        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now()
        ]);

        User::create([
            'name' => 'Fathur',
            'email' => 'fathurabdul28@gmail.com',
            'password' => Hash::make('staff123'),
            'role' => 'staff',
            'is_active' => true,
            'email_verified_at' => now()
        ]);

        $this->command->info('Admin users created successfully!');
        $this->command->info('Super Admin: admin@gmail.com / admin123');
        $this->command->info('Staff: staff@gmail.com / staff123');
    }
}