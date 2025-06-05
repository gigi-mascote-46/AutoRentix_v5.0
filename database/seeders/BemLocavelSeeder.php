<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BemLocavelSeeder extends Seeder
{
    public function run()
    {
        $bens = [
            ['nome' => 'Corolla', 'descricao' => null, 'registo_unico_publico' => '01-AC-01', 'preco_por_dia' => 50.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 1, 'modelo' => 'Corolla', 'ano' => 2020, 'matricula' => null, 'combustivel' => 'gasolina', 'transmissao' => 'automática', 'lugares' => 5, 'portas' => 4, 'ar_condicionado' => false, 'gps' => false, 'bluetooth' => false],
            ['nome' => 'Corolla', 'descricao' => null, 'registo_unico_publico' => 'RS-39-SC', 'preco_por_dia' => 55.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 1, 'modelo' => 'Corolla', 'ano' => 2022, 'matricula' => null, 'combustivel' => 'gasolina', 'transmissao' => 'manual', 'lugares' => 5, 'portas' => 4, 'ar_condicionado' => false, 'gps' => false, 'bluetooth' => false],
            ['nome' => 'Yaris', 'descricao' => null, 'registo_unico_publico' => 'MS-BA-02', 'preco_por_dia' => 48.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 1, 'modelo' => 'Yaris', 'ano' => 2021, 'matricula' => null, 'combustivel' => 'gasolina', 'transmissao' => 'manual', 'lugares' => 5, 'portas' => 4, 'ar_condicionado' => false, 'gps' => false, 'bluetooth' => false],
            ['nome' => 'Yaris', 'descricao' => null, 'registo_unico_publico' => '09-TO-PE', 'preco_por_dia' => 50.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 1, 'modelo' => 'Yaris', 'ano' => 2021, 'matricula' => null, 'combustivel' => 'híbrido', 'transmissao' => 'automática', 'lugares' => 5, 'portas' => 4, 'ar_condicionado' => false, 'gps' => false, 'bluetooth' => false],
            // ... (continue for all bens_locaveis from the SQL script)
        ];

        foreach ($bens as $bem) {
            DB::table('bens_locaveis')->updateOrInsert(
                ['registo_unico_publico' => $bem['registo_unico_publico']],
                $bem
            );
        }
    }
}
