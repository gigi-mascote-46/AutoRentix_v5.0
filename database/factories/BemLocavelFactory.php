<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\BemLocavel;
use App\Models\TipoBem;
use App\Models\Marca;

class BemLocavelFactory extends Factory
{
    protected $model = BemLocavel::class;

    public function definition()
    {
        // Garantir que existem tipos e marcas para relacionar
        $tipoBem = TipoBem::inRandomOrder()->first() ?? TipoBem::factory()->create();
        $marca = Marca::inRandomOrder()->first() ?? Marca::factory()->create();

        return [
            'tipo_bem_id' => $tipoBem->id,
            'marca_id' => $marca->id,
            'modelo' => $this->faker->word(),
            'ano' => $this->faker->numberBetween(2000, 2024),
            'preco' => $this->faker->randomFloat(2, 10, 500), // preço entre 10 e 500 (exemplo)
            'disponivel' => $this->faker->boolean(80), // 80% chance de estar disponível
            'descricao' => $this->faker->sentence(10),
        ];
    }
}
