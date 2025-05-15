<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Caracteristica;

class CaracteristicasSeeder extends Seeder
{
    public function run()
    {
        $caracteristicas = [
            'Ar-condicionado',
            'Direção assistida',
            'GPS',
            'Bluetooth',
            'Câmara de marcha-atrás',
            'Sensores de estacionamento',
            'Caixa automática',
            'Isofix',
            'Bagageira grande',
        ];

        foreach ($caracteristicas as $nome) {
            Caracteristica::create(['nome' => $nome]);
        }
    }
}
