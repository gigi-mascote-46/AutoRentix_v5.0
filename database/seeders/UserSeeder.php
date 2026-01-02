<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Criar Admin
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@autorentix.pt',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        // Criar Cliente de Teste
        User::create([
            'name' => 'Cliente Exemplo',
            'email' => 'cliente@autorentix.pt',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);
    }
}
