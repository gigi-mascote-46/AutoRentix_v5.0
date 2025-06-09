<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Cria 10 utilizadores usando a factory definida no modelo User
        // A factory gera dados fictícios automaticamente para popular a base de dados
        User::factory()->count(10)->create();
    }
}
