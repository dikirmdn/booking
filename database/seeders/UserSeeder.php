<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //admin
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'adminmeeting@dsi.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'User Test',
            'username' => 'user',
            'email' => 'user@dsi.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        
    }
}
