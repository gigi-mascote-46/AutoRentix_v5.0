<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Localizacao;

class LocalizacoesSeeder extends Seeder
{
    public function run()
    {
        Localizacao::factory()->count(10)->create();
    }
}
