<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoBem;

class TipoBensSeeder extends Seeder
{
    public function run()
    {
        $tipos = [
            'Carro',
            'Moto',
            'Bicicleta',
            'Camioneta',
            'Scooter',
        ];

        foreach ($tipos as $nome) {
            TipoBem::create(['nome' => $nome]);
        }
    }
}
