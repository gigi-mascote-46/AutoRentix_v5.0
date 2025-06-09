<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoBemSeeder extends Seeder
{
    public function run()
    {
        // Inserção ou atualização do registro com id 1 na tabela 'tipo_bens'
        // Caso já exista um registro com id 1, atualiza o nome para 'Carro'
        // Caso contrário, insere um novo registro com id 1 e nome 'Carro'
        DB::table('tipo_bens')->updateOrInsert(
            ['id' => 1],
            ['nome' => 'Carro']
        );

        // Inserção ou atualização do registro com id 2 na tabela 'tipo_bens'
        // Funciona igual ao anterior, mas com o nome 'Bangalô'
        DB::table('tipo_bens')->updateOrInsert(
            ['id' => 2],
            ['nome' => 'Bangalô']
        );
    }
}
