<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Caracteristica;

class CaracteristicaFactory extends Factory
{
    protected $model = Caracteristica::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->unique()->word(),  // um nome genérico para a característica
        ];
    }
}
