<?php

namespace Database\Factories;

use App\Models\BemLocavel;
use App\Models\Marca;
use Illuminate\Database\Eloquent\Factories\Factory;

class BemLocavelFactory extends Factory
{
    protected $model = BemLocavel::class;

    public function definition()
    {
        return [
            'marca_id' => Marca::factory(),
            'modelo' => $this->faker->word(),
            'registo_unico_publico' => strtoupper($this->faker->bothify('??-##-??')),
            'cor' => $this->faker->safeColorName(),
            'numero_passageiros' => $this->faker->numberBetween(2,7),
            'combustivel' => $this->faker->randomElement(['gasolina', 'diesel', 'elétrico', 'híbrido', 'outro']),
            'numero_portas' => $this->faker->numberBetween(2,5),
            'transmissao' => $this->faker->randomElement(['manual', 'automática']),
            'ano' => $this->faker->year(),
            'manutencao' => $this->faker->boolean(10), // 10% chance de estar em manutenção
            'preco_diario' => $this->faker->randomFloat(2, 30, 150),
            'observacao' => $this->faker->sentence(),
        ];
    }
}
