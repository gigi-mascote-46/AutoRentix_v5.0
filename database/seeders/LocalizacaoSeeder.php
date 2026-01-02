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
            ['vehicle_id' => $bens['01-AC-01']->id, 'cidade' => 'Lisboa', 'filial' => 'Unidade Lisboa Aeroporto', 'posicao' => 'A1'],
            ['vehicle_id' => $bens['RS-39-SC']->id, 'cidade' => 'Braga', 'filial' => 'Unidade Braga Centro', 'posicao' => 'A2'],
            ['vehicle_id' => $bens['MS-BA-02']->id, 'cidade' => 'Lisboa', 'filial' => 'Unidade Lisboa Aeroporto', 'posicao' => 'A3'],
            ['vehicle_id' => $bens['09-TO-PE']->id, 'cidade' => 'Porto', 'filial' => 'Unidade Porto Centro', 'posicao' => 'B1'],
            ['vehicle_id' => $bens['07-SE-AL']->id, 'cidade' => 'Braga', 'filial' => 'Unidade Braga Nogueira', 'posicao' => 'B2'],
            ['vehicle_id' => $bens['AD-CT-09']->id, 'cidade' => 'Porto', 'filial' => 'Unidade Porto Centro', 'posicao' => 'B2'],
            ['vehicle_id' => $bens['AB-10-RN']->id, 'cidade' => 'Braga', 'filial' => 'Unidade Braga Centro', 'posicao' => 'A1'],
            ['vehicle_id' => $bens['YG-FC-08']->id, 'cidade' => 'Braga', 'filial' => 'Unidade Braga Centro', 'posicao' => 'A3'],
            ['vehicle_id' => $bens['GB-78-AH']->id, 'cidade' => 'Braga', 'filial' => 'Unidade Braga Nogueira', 'posicao' => 'B1'],
            ['vehicle_id' => $bens['EH-16-PA']->id, 'cidade' => 'Coimbra', 'filial' => 'Unidade Coimbra Estação', 'posicao' => 'A1'],
            ['vehicle_id' => $bens['WS-54-RJ']->id, 'cidade' => 'Braga', 'filial' => 'Unidade Braga Nogueira', 'posicao' => 'A1'],
            ['vehicle_id' => $bens['SP-24-PB']->id, 'cidade' => 'Coimbra', 'filial' => 'Unidade Coimbra Estação', 'posicao' => 'A2'],
            ['vehicle_id' => $bens['JV-95-HP']->id, 'cidade' => 'Lisboa', 'filial' => 'Unidade Lisboa Aeroporto', 'posicao' => 'A2'],
            ['vehicle_id' => $bens['PM-BP-90']->id, 'cidade' => 'Porto', 'filial' => 'Unidade Porto Centro', 'posicao' => 'B3'],
            ['vehicle_id' => $bens['PA-12-AP']->id, 'cidade' => 'Coimbra', 'filial' => 'Unidade Coimbra Estação', 'posicao' => 'B2'],
            ['vehicle_id' => $bens['MT-64-MG']->id, 'cidade' => 'Braga', 'filial' => 'Unidade Braga Nogueira', 'posicao' => 'A2'],
            ['vehicle_id' => $bens['AA-A1-03']->id, 'cidade' => 'Braga', 'filial' => 'Unidade Braga Centro', 'posicao' => 'A4'],
            ['vehicle_id' => $bens['HY-10-27']->id, 'cidade' => 'Braga', 'filial' => 'Unidade Braga Nogueira', 'posicao' => 'C1'],
            ['vehicle_id' => $bens['DF-83-03']->id, 'cidade' => 'Porto', 'filial' => 'Unidade Porto Centro', 'posicao' => 'A1'],
            ['vehicle_id' => $bens['MA-PA-27']->id, 'cidade' => 'Coimbra', 'filial' => 'Unidade Coimbra Estação', 'posicao' => 'B1'],
            ['vehicle_id' => $bens['AM-10-31']->id, 'cidade' => 'Braga', 'filial' => 'Unidade Braga Centro', 'posicao' => 'B1'],
            ['vehicle_id' => $bens['CE-93-RO']->id, 'cidade' => 'Lisboa', 'filial' => 'Unidade Lisboa Aeroporto', 'posicao' => 'A4'],
            ['vehicle_id' => $bens['AC-RM-33']->id, 'cidade' => 'Lisboa', 'filial' => 'Unidade Lisboa Aeroporto', 'posicao' => 'A5'],
            ['vehicle_id' => $bens['12-PM-36']->id, 'cidade' => 'Porto', 'filial' => 'Unidade Porto Centro', 'posicao' => 'A2'],
            ['vehicle_id' => $bens['AC-MS-90']->id, 'cidade' => 'Coimbra', 'filial' => 'Unidade Coimbra Estação', 'posicao' => 'C1'],
            ['vehicle_id' => $bens['PR-59-23']->id, 'cidade' => 'Porto', 'filial' => 'Unidade Porto Centro', 'posicao' => 'A3'],
            ['vehicle_id' => $bens['21-ES-34']->id, 'cidade' => 'Braga', 'filial' => 'Unidade Braga Centro', 'posicao' => 'B2'],
            ['vehicle_id' => $bens['BA-93-57']->id, 'cidade' => 'Braga', 'filial' => 'Unidade Braga Nogueira', 'posicao' => 'C2'],
            ['vehicle_id' => $bens['GO-AL-68']->id, 'cidade' => 'Braga', 'filial' => 'Unidade Braga Centro', 'posicao' => 'B3'],
            ['vehicle_id' => $bens['29-SE-97']->id, 'cidade' => 'Coimbra', 'filial' => 'Unidade Coimbra Estação', 'posicao' => 'C2'],
        ];

        foreach ($localizacoes as $localizacao) {
            DB::table('localizacoes')->updateOrInsert(
                [
                    'vehicle_id' => $localizacao['vehicle_id'],
                    'cidade' => $localizacao['cidade'],
                    'filial' => $localizacao['filial'],
                    'posicao' => $localizacao['posicao'],
                ],
                [
                    'vehicle_id' => $localizacao['vehicle_id'],
                    'cidade' => $localizacao['cidade'],
                    'filial' => $localizacao['filial'],
                    'posicao' => $localizacao['posicao'],
                ]
            );
        }
    }
}
