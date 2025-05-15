<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Localizacao;

class LocalizacaoFactory extends Factory
{
    protected $model = Localizacao::class;

    public function definition()
    {
        return [
            'cidade' => $this->faker->city(),
            'codigo_postal' => $this->faker->postcode(),
            'morada' => $this->faker->address(),
        ];
    }
}
