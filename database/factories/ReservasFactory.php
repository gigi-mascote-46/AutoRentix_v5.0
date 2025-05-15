<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Reserva;
use App\Models\User;
use App\Models\BemLocavel;

class ReservaFactory extends Factory
{
    protected $model = Reserva::class;

    public function definition()
    {
        $start = $this->faker->dateTimeBetween('+1 days', '+10 days');
        $end = (clone $start)->modify('+'.rand(1,5).' days');

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'bens_locaveis_id' => BemLocavel::inRandomOrder()->first()->id,
            'data_inicio' => $start,
            'data_fim' => $end,
            'estado' => $this->faker->randomElement(['pendente', 'confirmada', 'cancelada']),
        ];
    }
}
