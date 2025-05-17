<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->count(10)->create([
            'role' => 'user',
            'cep' => '01001000',
            'city' => 'São Paulo',
            'state' => 'SP',
            'street' => 'Praça da Sé',
            'neighborhood' => 'Sé'
        ]);
    }
}
