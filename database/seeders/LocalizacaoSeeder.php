<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocalizacaoSeeder extends Seeder
{
    public function run()
    {
        DB::table('localizacoes')->truncate();

        $bens = DB::table('bens_locaveis')->pluck('registo_unico_publico');

        $locations = [
            ['cidade' => 'Lisboa', 'filial' => 'Unidade Lisboa Aeroporto', 'posicao' => 'A1'],
            ['cidade' => 'Braga', 'filial' => 'Unidade Braga Centro', 'posicao' => 'A2'],
        ];

        $data = [];
        $usedPositions = [];

        foreach ($bens as $bem) {
            do {
                $location = $locations[array_rand($locations)];
                $key = $location['filial'] . '-' . $location['posicao'];
            } while (in_array($key, $usedPositions));

            $usedPositions[] = $key;

            $data[] = [
                'registo_unico_publico' => $bem,
                'cidade' => $location['cidade'],
                'filial' => $location['filial'],
                'posicao' => $location['posicao'],
            ];
        }

        DB::table('localizacoes')->insert($data);
    }
}
