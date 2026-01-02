<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Chama os seeders individuais na ordem correta
        $this->call([
            UserSeeder::class,
            BrandSeeder::class,
            VehicleSeeder::class,
        ]);
    }
}
