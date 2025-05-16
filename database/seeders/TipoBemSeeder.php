<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoBemSeeder extends Seeder
{
    public function run()
    {
        DB::table('tipo_bens')->insert([
            ['id' => 1, 'nome' => 'Carro'],
        ]);
    }
}
