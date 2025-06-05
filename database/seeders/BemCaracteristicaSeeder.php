<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BemCaracteristicaSeeder extends Seeder
{
    public function run()
    {
        $bem_caracteristicas = [
            // Ar-condicionado para todos
            ['bem_locavel_id' => 1, 'caracteristica_id' => 1],
            ['bem_locavel_id' => 2, 'caracteristica_id' => 1],
            ['bem_locavel_id' => 3, 'caracteristica_id' => 1],
            // ... continue for all bens_locaveis with ar-condicionado
            // Direção assistida para todos
            ['bem_locavel_id' => 1, 'caracteristica_id' => 2],
            ['bem_locavel_id' => 2, 'caracteristica_id' => 2],
            ['bem_locavel_id' => 3, 'caracteristica_id' => 2],
            // ... continue for all bens_locaveis with direção assistida
            // GPS para IDs ímpares
            ['bem_locavel_id' => 1, 'caracteristica_id' => 3],
            ['bem_locavel_id' => 3, 'caracteristica_id' => 3],
            // ... continue for all bens_locaveis with GPS
            // Bluetooth para IDs que satisfazem MOD(id,3) IN (0,2)
            ['bem_locavel_id' => 3, 'caracteristica_id' => 4],
            ['bem_locavel_id' => 6, 'caracteristica_id' => 4],
            // ... continue for all bens_locaveis with Bluetooth
            // Câmara de marcha-atrás para MOD(id,3)=0
            ['bem_locavel_id' => 3, 'caracteristica_id' => 5],
            ['bem_locavel_id' => 6, 'caracteristica_id' => 5],
            // ... continue for all bens_locaveis with câmara de marcha-atrás
            // Sensores de estacionamento (IDs específicos)
            ['bem_locavel_id' => 7, 'caracteristica_id' => 6],
            ['bem_locavel_id' => 8, 'caracteristica_id' => 6],
            ['bem_locavel_id' => 9, 'caracteristica_id' => 6],
            ['bem_locavel_id' => 16, 'caracteristica_id' => 6],
            ['bem_locavel_id' => 17, 'caracteristica_id' => 6],
            ['bem_locavel_id' => 18, 'caracteristica_id' => 6],
            ['bem_locavel_id' => 25, 'caracteristica_id' => 6],
            ['bem_locavel_id' => 26, 'caracteristica_id' => 6],
            ['bem_locavel_id' => 27, 'caracteristica_id' => 6],
            ['bem_locavel_id' => 20, 'caracteristica_id' => 6],
            ['bem_locavel_id' => 15, 'caracteristica_id' => 6],
            ['bem_locavel_id' => 6, 'caracteristica_id' => 6],
            // Caixa automática para MOD(id,3)=0
            ['bem_locavel_id' => 3, 'caracteristica_id' => 7],
            ['bem_locavel_id' => 6, 'caracteristica_id' => 7],
            // ... continue for all bens_locaveis with caixa automática
            // Isofix (IDs específicos)
            ['bem_locavel_id' => 13, 'caracteristica_id' => 8],
            ['bem_locavel_id' => 14, 'caracteristica_id' => 8],
            ['bem_locavel_id' => 15, 'caracteristica_id' => 8],
            ['bem_locavel_id' => 16, 'caracteristica_id' => 8],
            ['bem_locavel_id' => 17, 'caracteristica_id' => 8],
            ['bem_locavel_id' => 18, 'caracteristica_id' => 8],
            ['bem_locavel_id' => 30, 'caracteristica_id' => 8],
            ['bem_locavel_id' => 28, 'caracteristica_id' => 8],
            ['bem_locavel_id' => 22, 'caracteristica_id' => 8],
            ['bem_locavel_id' => 23, 'caracteristica_id' => 8],
            ['bem_locavel_id' => 10, 'caracteristica_id' => 8],
            ['bem_locavel_id' => 12, 'caracteristica_id' => 8],
            // Bagageira grande (IDs específicos)
            ['bem_locavel_id' => 1, 'caracteristica_id' => 9],
            ['bem_locavel_id' => 2, 'caracteristica_id' => 9],
            ['bem_locavel_id' => 3, 'caracteristica_id' => 9],
            ['bem_locavel_id' => 7, 'caracteristica_id' => 9],
            ['bem_locavel_id' => 8, 'caracteristica_id' => 9],
            ['bem_locavel_id' => 9, 'caracteristica_id' => 9],
            ['bem_locavel_id' => 10, 'caracteristica_id' => 9],
            ['bem_locavel_id' => 11, 'caracteristica_id' => 9],
            ['bem_locavel_id' => 12, 'caracteristica_id' => 9],
            ['bem_locavel_id' => 16, 'caracteristica_id' => 9],
            ['bem_locavel_id' => 17, 'caracteristica_id' => 9],
            ['bem_locavel_id' => 18, 'caracteristica_id' => 9],
            ['bem_locavel_id' => 19, 'caracteristica_id' => 9],
            ['bem_locavel_id' => 20, 'caracteristica_id' => 9],
            ['bem_locavel_id' => 21, 'caracteristica_id' => 9],
            ['bem_locavel_id' => 23, 'caracteristica_id' => 9],
            ['bem_locavel_id' => 30, 'caracteristica_id' => 9],
            ['bem_locavel_id' => 29, 'caracteristica_id' => 9],
        ];

        foreach ($bem_caracteristicas as $bc) {
            DB::table('bem_caracteristicas')->updateOrInsert(
                ['bem_locavel_id' => $bc['bem_locavel_id'], 'caracteristica_id' => $bc['caracteristica_id']],
                $bc
            );
        }
    }
}
