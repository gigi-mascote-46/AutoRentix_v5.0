<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BemCaracteristicaSeeder extends Seeder
{
    public function run()
    {
        $insertData = [];

        // Todas as viaturas recebem ar-condicionado (id 1) e direção assistida (id 2)
        $allBens = DB::table('bens_locaveis')->pluck('id');
        foreach ($allBens as $bemId) {
            $insertData[] = ['bem_locavel_id' => $bemId, 'caracteristica_id' => 1];
            $insertData[] = ['bem_locavel_id' => $bemId, 'caracteristica_id' => 2];
        }

        // GPS em metade das viaturas (id ímpar)
        $gpsBens = DB::table('bens_locaveis')->whereRaw('MOD(id, 2) = 1')->pluck('id');
        foreach ($gpsBens as $bemId) {
            $insertData[] = ['bem_locavel_id' => $bemId, 'caracteristica_id' => 3];
        }

        // Bluetooth para viaturas IDs % 3 = 0 ou 2
        $bluetoothBens = DB::table('bens_locaveis')->whereRaw('MOD(id, 3) IN (0, 2)')->pluck('id');
        foreach ($bluetoothBens as $bemId) {
            $insertData[] = ['bem_locavel_id' => $bemId, 'caracteristica_id' => 4];
        }

        // Câmara de marcha-atrás para IDs % 3 = 0
        $cameraBens = DB::table('bens_locaveis')->whereRaw('MOD(id, 3) = 0')->pluck('id');
        foreach ($cameraBens as $bemId) {
            $insertData[] = ['bem_locavel_id' => $bemId, 'caracteristica_id' => 5];
        }

        // Sensores de estacionamento para IDs pares
        $sensorBens = DB::table('bens_locaveis')->whereRaw('MOD(id, 2) = 0')->pluck('id');
        foreach ($sensorBens as $bemId) {
            $insertData[] = ['bem_locavel_id' => $bemId, 'caracteristica_id' => 6];
        }

        // Caixa automática para viaturas que têm transmissão automática (simplificação)
        $autoBens = DB::table('bens_locaveis')->where('transmissao', 'automática')->pluck('id');
        foreach ($autoBens as $bemId) {
            $insertData[] = ['bem_locavel_id' => $bemId, 'caracteristica_id' => 7];
        }

        // Isofix em carros com ano >= 2022
        $isofixBens = DB::table('bens_locaveis')->where('ano', '>=', 2022)->pluck('id');
        foreach ($isofixBens as $bemId) {
            $insertData[] = ['bem_locavel_id' => $bemId, 'caracteristica_id' => 8];
        }

        // Bagageira grande para carros com mais de 4 portas
        $bagageiraBens = DB::table('bens_locaveis')->where('numero_portas', '>', 4)->pluck('id');
        foreach ($bagageiraBens as $bemId) {
            $insertData[] = ['bem_locavel_id' => $bemId, 'caracteristica_id' => 9];
        }

        DB::table('bem_caracteristicas')->insert($insertData);
    }
}
