<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocalizacaoSeeder extends Seeder
{
    public function run()
    {
        $localizacoes = [
            ['registo_unico_publico' => '01-AC-01', 'cidade' => 'Lisboa', 'filial' => 'Unidade Lisboa Aeroporto', 'posicao' => 'A1'],
            ['registo_unico_publico' => 'RS-39-SC', 'cidade' => 'Braga', 'filial' => 'Unidade Braga Centro', 'posicao' => 'A2'],
            ['registo_unico_publico' => 'MS-BA-02', 'cidade' => 'Lisboa', 'filial' => 'Unidade Lisboa Aeroporto', 'posicao' => 'A3'],
            ['registo_unico_publico' => '09-TO-PE', 'cidade' => 'Porto', 'filial' => 'Unidade Porto Centro', 'posicao' => 'B1'],
            // ... (continue for all localizacoes from the SQL script)
        ];

        foreach ($localizacoes as $localizacao) {
            DB::table('localizacoes')->updateOrInsert(
                ['registo_unico_publico' => $localizacao['registo_unico_publico']],
                $localizacao
            );
        }
    }
}
