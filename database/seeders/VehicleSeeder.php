<?php

namespace Database\Seeders;

use App\Models\Marca;
use App\Models\BemLocavel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        // Garante que temos marcas
        $bmw = Marca::where('nome', 'BMW')->first();
        $tesla = Marca::where('nome', 'Tesla')->first();
        // Garante que temos o tipo de bem (criado anteriormente no BrandSeeder)
        $tipoBem = DB::table('tipo_bens')->where('nome', 'Automóvel')->first();

        if (!$bmw || !$tesla || !$tipoBem) {
            return;
        }

        // Viatura 1: BMW Série 3
        $v1 = BemLocavel::forceCreate([
            'nome' => 'BMW Série 3 320d',
            'marca_id' => $bmw->id,
            'tipo_bem_id' => $tipoBem->id,
            'modelo' => 'Série 3 320d',
            'cor' => 'Preto',
            'ano' => 2023,
            'preco_diario' => 85.00, // Verifique se a coluna é preco_diario ou preco_por_dia
            'numero_passageiros' => 5,
            'combustivel' => 'diesel',
            'transmissao' => 'automatica',
            'manutencao' => false,
            // Caminho da imagem principal (certifique-se que o ficheiro existe em storage/app/public/vehicles)
            'foto_url' => 'vehicles/bmw_serie3.jpg',
        ]);

        // Adicionar fotos extra à galeria (se tiver tabela de fotos)
        // $v1->photos()->create(['photo_path' => 'vehicles/bmw_interior.jpg']);

        // Viatura 2: Tesla Model 3
        BemLocavel::forceCreate([
            'nome' => 'Tesla Model 3',
            'marca_id' => $tesla->id,
            'tipo_bem_id' => $tipoBem->id,
            'modelo' => 'Model 3 Long Range',
            'cor' => 'Branco',
            'ano' => 2024,
            'preco_diario' => 120.00,
            'numero_passageiros' => 5,
            'combustivel' => 'eletrico',
            'transmissao' => 'automatica',
            'manutencao' => false,
            'foto_url' => 'vehicles/tesla_model3.jpg',
        ]);
    }
}
