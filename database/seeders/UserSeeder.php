<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        User::create([
            'name'              => 'Administrator',
            'email'             => 'admin@admin.com',
            'password'          => Hash::make('password'), 
            'role'              => 'admin',
            'is_premium'        => true, 
            'email_verified_at' => now(),
            'is_active'         => true,
        ]);

        User::create([
            'name'              => 'User Tester',
            'email'             => 'user@user.com',
            'password'          => Hash::make('password'), 
            'role'              => 'user',
            'is_premium'        => false,
            'email_verified_at' => now(),
            'is_active'         => true,
        ]);
    }
}