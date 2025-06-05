<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CaracteristicaSeeder extends Seeder
{
    public function run()
    {
        $caracteristicas = [
            ['id' => 1, 'nome' => 'Ar-condicionado'],
            ['id' => 2, 'nome' => 'Direção assistida'],
            ['id' => 3, 'nome' => 'GPS'],
            ['id' => 4, 'nome' => 'Bluetooth'],
            ['id' => 5, 'nome' => 'Câmara de marcha-atrás'],
            ['id' => 6, 'nome' => 'Sensores de estacionamento'],
            ['id' => 7, 'nome' => 'Caixa automática'],
            ['id' => 8, 'nome' => 'Isofix'],
            ['id' => 9, 'nome' => 'Bagageira grande'],
        ];

        foreach ($caracteristicas as $caracteristica) {
            DB::table('caracteristicas')->updateOrInsert(
                ['id' => $caracteristica['id']],
                $caracteristica
            );
        }
    }
}
