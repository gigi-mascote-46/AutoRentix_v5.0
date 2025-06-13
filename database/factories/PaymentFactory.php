<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition()
    {
        return [
            'reservation_id' => Reservation::factory(),
            'metodo' => $this->faker->randomElement(['cartão de crédito', 'boleto', 'paypal', 'dinheiro']),
            'montante' => $this->faker->randomFloat(2, 10, 1000),
            'status' => $this->faker->randomElement(['pendente', 'pago', 'cancelado']),
        ];
    }
}
