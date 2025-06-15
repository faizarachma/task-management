<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Developer User',
            'email' => 'developer@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'role' => 'developer',
            'remember_token' => Str::random(10),
        ]);
    }
}
