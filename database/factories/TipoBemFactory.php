<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TipoBem;

class TipoBemFactory extends Factory
{
    protected $model = TipoBem::class;

    public function definition()
    {
        $tipos = ['Carro', 'Moto', 'Bicicleta', 'Camioneta', 'Scooter'];

        return [
            'nome' => $this->faker->unique()->randomElement($tipos),
        ];
    }
}
