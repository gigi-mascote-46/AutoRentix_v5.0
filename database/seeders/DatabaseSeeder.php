<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
   public function run(): void
{
    \App\Models\Marca::factory(10)->create();
    \App\Models\TipoBem::factory(5)->create();
    \App\Models\BemLocavel::factory(20)->create();
    \App\Models\Caracteristica::factory(15)->create();
    \App\Models\User::factory(10)->create();
    \App\Models\Reserva::factory(20)->create();
    \App\Models\Pagamento::factory(30)->create();
}

}
