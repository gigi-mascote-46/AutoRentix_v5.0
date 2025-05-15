<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pagamento;
use App\Models\Reserva;

class PagamentoFactory extends Factory
{
    protected $model = Pagamento::class;

    public function definition()
    {
        $reserva = Reserva::inRandomOrder()->first();

        return [
            'reserva_id' => $reserva->id,
            'valor' => $this->faker->randomFloat(2, 50, 500),
            'metodo' => $this->faker->randomElement(['Multibanco', 'MB Way', 'Visa']),
            'estado' => $this->faker->randomElement(['pago', 'pendente', 'falhado']),
            'data_pagamento' => now(),
        ];
    }
}
