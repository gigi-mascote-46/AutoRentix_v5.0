<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Aqui chamamos os seeders que criarmos
$this->call([
        TipoBemSeeder::class,
        MarcaSeeder::class,
        BemLocavelSeeder::class,
        LocalizacaoSeeder::class,
        CaracteristicaSeeder::class,
        BemCaracteristicaSeeder::class,
    ]);
    }
}
