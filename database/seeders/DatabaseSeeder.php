<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Aqui chamamos os seeders que criarmos
        $this->call([
            UserSeeder::class,
            TipoBemSeeder::class,
            MarcaSeeder::class,
            BemLocavelSeeder::class,
            LocalizacaoSeeder::class,
            CaracteristicaSeeder::class,
            BemCaracteristicaSeeder::class,
            AdminUserSeeder::class,
            ReservationSeeder::class,
            PaymentsSeeder::class,
            SessionsSeeder::class,
        ]);
    }
}
