<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BemLocavel;

class BensLocaveisSeeder extends Seeder
{
    public function run()
    {
        // Criar 20 bens locáveis de exemplo
        BemLocavel::factory()->count(20)->create();
    }
}
