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
            'email'             => 'resumate789@gmail.com',
            'role'              => 'admin',
            'is_premium'        => true, 
            'email_verified_at' => now(),
            'is_active'         => true,
        ]);
    }
}