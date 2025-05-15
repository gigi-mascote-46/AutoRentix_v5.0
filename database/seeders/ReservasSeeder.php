<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reserva;

class ReservasSeeder extends Seeder
{
    public function run()
    {
        Reserva::factory()->count(20)->create();
    }
}
