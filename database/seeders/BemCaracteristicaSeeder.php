<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BemCaracteristicaSeeder extends Seeder
{
    public function run()
    {
        $bens = DB::table('bens_locaveis')->orderBy('id')->get();

        // Clear existing data
        DB::table('bem_caracteristicas')->truncate();

        foreach ($bens as $bem) {
            // Ar-condicionado para todos
            DB::table('bem_caracteristicas')->updateOrInsert(
                ['bem_locavel_id' => $bem->id, 'caracteristica_id' => 1],
                ['bem_locavel_id' => $bem->id, 'caracteristica_id' => 1]
            );

            // Direção assistida para todos
            DB::table('bem_caracteristicas')->updateOrInsert(
                ['bem_locavel_id' => $bem->id, 'caracteristica_id' => 2],
                ['bem_locavel_id' => $bem->id, 'caracteristica_id' => 2]
            );

            // GPS para IDs ímpares
            if ($bem->id % 2 == 1) {
                DB::table('bem_caracteristicas')->updateOrInsert(
                    ['bem_locavel_id' => $bem->id, 'caracteristica_id' => 3],
                    ['bem_locavel_id' => $bem->id, 'caracteristica_id' => 3]
                );
            }

            // Bluetooth para IDs que satisfazem MOD(id,3) IN (0,2)
            if (in_array($bem->id % 3, [0, 2])) {
                DB::table('bem_caracteristicas')->updateOrInsert(
                    ['bem_locavel_id' => $bem->id, 'caracteristica_id' => 4],
                    ['bem_locavel_id' => $bem->id, 'caracteristica_id' => 4]
                );
            }

            // Câmara de marcha-atrás para MOD(id,3) = 0
            if ($bem->id % 3 == 0) {
                DB::table('bem_caracteristicas')->updateOrInsert(
                    ['bem_locavel_id' => $bem->id, 'caracteristica_id' => 5],
                    ['bem_locavel_id' => $bem->id, 'caracteristica_id' => 5]
                );
            }

            // Sensores de estacionamento (IDs específicos)
            if (in_array($bem->id, [7, 8, 9, 16, 17, 18, 25, 26, 27, 20, 15, 6])) {
                DB::table('bem_caracteristicas')->updateOrInsert(
                    ['bem_locavel_id' => $bem->id, 'caracteristica_id' => 6],
                    ['bem_locavel_id' => $bem->id, 'caracteristica_id' => 6]
                );
            }

            // Caixa automática para MOD(id,3) = 0
            if ($bem->id % 3 == 0) {
                DB::table('bem_caracteristicas')->updateOrInsert(
                    ['bem_locavel_id' => $bem->id, 'caracteristica_id' => 7],
                    ['bem_locavel_id' => $bem->id, 'caracteristica_id' => 7]
                );
            }

            // Isofix (IDs específicos)
            if (in_array($bem->id, [13, 14, 15, 16, 17, 18, 30, 28, 22, 23, 10, 12])) {
                DB::table('bem_caracteristicas')->updateOrInsert(
                    ['bem_locavel_id' => $bem->id, 'caracteristica_id' => 8],
                    ['bem_locavel_id' => $bem->id, 'caracteristica_id' => 8]
                );
            }

            // Bagageira grande (IDs específicos)
            if (in_array($bem->id, [1, 2, 3, 7, 8, 9, 10, 11, 12, 16, 17, 18, 19, 20, 21, 23, 30, 29])) {
                DB::table('bem_caracteristicas')->updateOrInsert(
                    ['bem_locavel_id' => $bem->id, 'caracteristica_id' => 9],
                    ['bem_locavel_id' => $bem->id, 'caracteristica_id' => 9]
                );
            }
        }
    }
}
