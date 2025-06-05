<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoBemSeeder extends Seeder
{
    public function run()
    {
        DB::table('tipo_bens')->updateOrInsert(
            ['id' => 1],
            ['nome' => 'Carro']
        );
        DB::table('tipo_bens')->updateOrInsert(
            ['id' => 2],
            ['nome' => 'Bangalô']
        );
    }
}
