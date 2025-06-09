<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocalizacaoSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('localizacoes')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $bens = DB::table('bens_locaveis')->get()->keyBy('registo_unico_publico');

        $localizacoes = [
            ['registo_unico_publico' => '01-AC-01', 'cidade' => 'Lisboa', 'filial' => 'Unidade Lisboa Aeroporto', 'posicao' => 'A1'],
            ['registo_unico_publico' => 'RS-39-SC', 'cidade' => 'Braga', 'filial' => 'Unidade Braga Centro', 'posicao' => 'A2'],
            ['registo_unico_publico' => 'MS-BA-02', 'cidade' => 'Lisboa', 'filial' => 'Unidade Lisboa Aeroporto', 'posicao' => 'A3'],
            ['registo_unico_publico' => '09-TO-PE', 'cidade' => 'Porto', 'filial' => 'Unidade Porto Centro', 'posicao' => 'B1'],
            ['registo_unico_publico' => '07-SE-AL', 'cidade' => 'Braga', 'filial' => 'Unidade Braga Nogueira', 'posicao' => 'B2'],
            ['registo_unico_publico' => 'AD-CT-09', 'cidade' => 'Porto', 'filial' => 'Unidade Porto Centro', 'posicao' => 'B2'],
            ['registo_unico_publico' => 'AB-10-RN', 'cidade' => 'Braga', 'filial' => 'Unidade Braga Centro', 'posicao' => 'A1'],
            ['registo_unico_publico' => 'YG-FC-08', 'cidade' => 'Braga', 'filial' => 'Unidade Braga Centro', 'posicao' => 'A3'],
            ['registo_unico_publico' => 'GB-78-AH', 'cidade' => 'Braga', 'filial' => 'Unidade Braga Nogueira', 'posicao' => 'B1'],
            ['registo_unico_publico' => 'EH-16-PA', 'cidade' => 'Coimbra', 'filial' => 'Unidade Coimbra Estação', 'posicao' => 'A1'],
            ['registo_unico_publico' => 'WS-54-RJ', 'cidade' => 'Braga', 'filial' => 'Unidade Braga Nogueira', 'posicao' => 'A1'],
            ['registo_unico_publico' => 'SP-24-PB', 'cidade' => 'Coimbra', 'filial' => 'Unidade Coimbra Estação', 'posicao' => 'A2'],
            ['registo_unico_publico' => 'JV-95-HP', 'cidade' => 'Lisboa', 'filial' => 'Unidade Lisboa Aeroporto', 'posicao' => 'A2'],
            ['registo_unico_publico' => 'PM-BP-90', 'cidade' => 'Porto', 'filial' => 'Unidade Porto Centro', 'posicao' => 'B3'],
            ['registo_unico_publico' => 'PA-12-AP', 'cidade' => 'Coimbra', 'filial' => 'Unidade Coimbra Estação', 'posicao' => 'B2'],
            ['registo_unico_publico' => 'MT-64-MG', 'cidade' => 'Braga', 'filial' => 'Unidade Braga Nogueira', 'posicao' => 'A2'],
            ['registo_unico_publico' => 'AA-A1-03', 'cidade' => 'Braga', 'filial' => 'Unidade Braga Centro', 'posicao' => 'A4'],
            ['registo_unico_publico' => 'HY-10-27', 'cidade' => 'Braga', 'filial' => 'Unidade Braga Nogueira', 'posicao' => 'C1'],
            ['registo_unico_publico' => 'DF-83-03', 'cidade' => 'Porto', 'filial' => 'Unidade Porto Centro', 'posicao' => 'A1'],
            ['registo_unico_publico' => 'MA-PA-27', 'cidade' => 'Coimbra', 'filial' => 'Unidade Coimbra Estação', 'posicao' => 'B1'],
            ['registo_unico_publico' => 'AM-10-31', 'cidade' => 'Braga', 'filial' => 'Unidade Braga Centro', 'posicao' => 'B1'],
            ['registo_unico_publico' => 'CE-93-RO', 'cidade' => 'Lisboa', 'filial' => 'Unidade Lisboa Aeroporto', 'posicao' => 'A4'],
            ['registo_unico_publico' => 'AC-RM-33', 'cidade' => 'Lisboa', 'filial' => 'Unidade Lisboa Aeroporto', 'posicao' => 'A5'],
            ['registo_unico_publico' => '12-PM-36', 'cidade' => 'Porto', 'filial' => 'Unidade Porto Centro', 'posicao' => 'A2'],
            ['registo_unico_publico' => 'AC-MS-90', 'cidade' => 'Coimbra', 'filial' => 'Unidade Coimbra Estação', 'posicao' => 'C1'],
            ['registo_unico_publico' => 'PR-59-23', 'cidade' => 'Porto', 'filial' => 'Unidade Porto Centro', 'posicao' => 'A3'],
            ['registo_unico_publico' => '21-ES-34', 'cidade' => 'Braga', 'filial' => 'Unidade Braga Centro', 'posicao' => 'B2'],
            ['registo_unico_publico' => 'BA-93-57', 'cidade' => 'Braga', 'filial' => 'Unidade Braga Nogueira', 'posicao' => 'C2'],
            ['registo_unico_publico' => 'GO-AL-68', 'cidade' => 'Braga', 'filial' => 'Unidade Braga Centro', 'posicao' => 'B3'],
            ['registo_unico_publico' => '29-SE-97', 'cidade' => 'Coimbra', 'filial' => 'Unidade Coimbra Estação', 'posicao' => 'C2'],
        ];

        foreach ($localizacoes as $localizacao) {
            if (isset($bens[$localizacao['registo_unico_publico']])) {
                DB::table('localizacoes')->updateOrInsert(
                    [
                        'registo_unico_publico' => $localizacao['registo_unico_publico'],
                        'cidade' => $localizacao['cidade'],
                        'filial' => $localizacao['filial'],
                        'posicao' => $localizacao['posicao'],
                    ],
                    [
                        'registo_unico_publico' => $localizacao['registo_unico_publico'],
                        'cidade' => $localizacao['cidade'],
                        'filial' => $localizacao['filial'],
                        'posicao' => $localizacao['posicao'],
                    ]
                );
            }
        }
    }
}
