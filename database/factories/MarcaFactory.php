<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Marca;

class MarcaFactory extends Factory
{
    protected $model = Marca::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->company(),
            'descricao' => $this->faker->sentence(8),
        ];
    }
}
