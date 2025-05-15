<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Marca;

class MarcasSeeder extends Seeder
{
    public function run()
    {
        // Criar 10 marcas de exemplo
        Marca::factory()->count(10)->create();
    }
}
