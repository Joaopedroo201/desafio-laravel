<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Master',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
            'cep' => '01001000',
            'number' => '100',
            'city' => 'São Paulo',
            'state' => 'SP',
            'role' => 'admin'
        ]);
    }
}
