<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin HMI Tour', 
            'email' => 'adminjusuf@hmitour.site',
            'password' => Hash::make('jusuf123'),
            'role' => 'admin',
        ]);
        user::create([
            'name' => 'Radit',
            'email'=> 'raditLeader@hmitour.site',
            'password'=> Hash::make('radit123'),
            'role'=> 'leader',
            'referral_code' => 'HMI-RADIT2026',
        ]);
    
        user::create([
            'name' => 'bigmo',
            'email' => 'niceguy@gmail.com',
            'password' => Hash::make('user1234'),
            'role' => 'user'
        ]);
    }
}