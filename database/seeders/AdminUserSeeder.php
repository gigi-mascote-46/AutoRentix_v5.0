<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Executa os seeds na base de dados.
     */
    public function run()
    {
        // Cria ou atualiza o utilizador administrador com email 'admin@autorentix.pt'
        // Se o utilizador já existir, apenas atualiza os dados
        User::updateOrCreate(
            ['email' => 'admin@autorentix.pt'], // condição para procurar o utilizador
            [
                'name' => 'Admin User', // nome do utilizador
                'password' => Hash::make('password123'), // password encriptada (trocar para algo seguro)
                'is_admin' => true, // flag para indicar que é administrador
                'role' => 'admin', // papel (role) do utilizador
            ]
        );
    }
}
