<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@perpus.test'], [
            'name' => 'Administrator', 
            'role' => 'admin', 
            'password' => Hash::make('password'),
        ]);
        
        User::updateOrCreate(['email' => 'petugas@perpus.test'], [
            'name' => 'Petugas Perpustakaan', 
            'role' => 'petugas', 
            'password' => Hash::make('password'),
        ]);
    }
}