<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocalizacaoSeeder extends Seeder
{
    public function run()
    {
        DB::table('localizacoes')->insert([
            ['bem_locavel_id' => 1, 'cidade' => 'Lisboa', 'filial' => 'Unidade Lisboa Aeroporto', 'posicao' => 'A1'],
            ['bem_locavel_id' => 2, 'cidade' => 'Braga', 'filial' => 'Unidade Braga Centro', 'posicao' => 'A2'],
            // ... adiciona as outras linhas aqui
        ]);
    }
}
