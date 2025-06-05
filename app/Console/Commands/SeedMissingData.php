<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SeedMissingData extends Command
{
    protected $signature = 'db:seed-missing';

    protected $description = 'Seed only missing data without affecting existing tables';

    public function handle()
    {
        $this->info('Seeding only missing data...');

        // List of seeders to run
        $seeders = [
            'TipoBemSeeder',
            'MarcaSeeder',
            'BemLocavelSeeder',
            'LocalizacaoSeeder',
            'CaracteristicaSeeder',
            'BemCaracteristicaSeeder',
            // Add other seeders as needed
        ];

        foreach ($seeders as $seeder) {
            $this->info("Seeding: $seeder");
            Artisan::call('db:seed', ['--class' => "Database\\Seeders\\$seeder"]);
            $this->info(Artisan::output());
        }

        $this->info('Seeding completed.');
    }
}
