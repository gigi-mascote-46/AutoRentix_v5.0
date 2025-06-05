<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarcaSeeder extends Seeder
{
    public function run()
    {
        $marcas = [
            ['id' => 1, 'tipo_bem_id' => 1, 'nome' => 'Toyota', 'observacao' => 'A confiabilidade e eficiência japonesa que movem o mundo!'],
            ['id' => 2, 'tipo_bem_id' => 1, 'nome' => 'Honda', 'observacao' => 'Tecnologia japonesa e eficiência compacta para levar você mais longe!'],
            ['id' => 3, 'tipo_bem_id' => 1, 'nome' => 'Ford', 'observacao' => 'A tradição americana e a inovação automotiva ao seu alcance!'],
            ['id' => 4, 'tipo_bem_id' => 1, 'nome' => 'Volkswagen', 'observacao' => 'Engenharia alemã, performance e conforto para qualquer destino!'],
            ['id' => 5, 'tipo_bem_id' => 1, 'nome' => 'Renault', 'observacao' => 'Elegância e economia francesas, sem abrir mão da qualidade!'],
        ];

        foreach ($marcas as $marca) {
            DB::table('marca')->updateOrInsert(
                ['id' => $marca['id']],
                $marca
            );
        }
    }
}
