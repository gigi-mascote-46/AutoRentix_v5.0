<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CaracteristicaSeeder extends Seeder
{
    public function run()
    {
        DB::table('caracteristicas')->insert([
            ['nome' => 'Ar-condicionado'],
            ['nome' => 'Direção assistida'],
            ['nome' => 'GPS'],
            ['nome' => 'Bluetooth'],
            ['nome' => 'Câmara de marcha-atrás'],
            ['nome' => 'Sensores de estacionamento'],
            ['nome' => 'Caixa automática'],
            ['nome' => 'Isofix'],
            ['nome' => 'Bagageira grande'],
        ]);
    }
}
