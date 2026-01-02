<?php

namespace Database\Seeders;

use App\Models\Marca;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Criar ou obter um Tipo de Bem (ex: Automóvel) para satisfazer a chave estrangeira
        $tipoBem = DB::table('tipo_bens')->where('nome', 'Automóvel')->first();

        if ($tipoBem) {
            $tipoBemId = $tipoBem->id;
        } else {
            $tipoBemId = DB::table('tipo_bens')->insertGetId([
                'nome' => 'Automóvel',
            ]);
        }

        $brands = ['BMW', 'Mercedes-Benz', 'Audi', 'Tesla', 'Toyota', 'Peugeot'];

        foreach ($brands as $brand) {
            // 2. Criar a marca associada ao tipo de bem
            Marca::firstOrCreate(
                ['nome' => $brand],
                ['tipo_bem_id' => $tipoBemId]
            );
        }
    }
}
