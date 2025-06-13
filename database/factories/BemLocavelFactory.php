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
            'nome' => $this->faker->word(),
            'descricao' => $this->faker->sentence(),
            'registo_unico_publico' => strtoupper($this->faker->bothify('??-##-??')),
            'preco_por_dia' => $this->faker->randomFloat(2, 20, 100),
            'disponivel' => $this->faker->boolean(80),
            'tipo_bem_id' => 1,
            'marca_id' => Marca::factory(),
            'modelo' => $this->faker->word(),
            'ano' => $this->faker->year(),
            'matricula' => strtoupper($this->faker->bothify('??-##-??')),
            'combustivel' => $this->faker->randomElement(['gasolina', 'diesel', 'híbrido', 'eléctrico']),
            'transmissao' => $this->faker->randomElement(['manual', 'automática']),
            'lugares' => $this->faker->numberBetween(2, 7),
            'portas' => $this->faker->numberBetween(2, 5),
            'ar_condicionado' => $this->faker->boolean(),
            'gps' => $this->faker->boolean(),
            'bluetooth' => $this->faker->boolean(),
        ];
    }
}
