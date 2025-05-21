<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\User;
// Make sure the User model exists at app/Models/User.php with namespace App\Models;
use App\Models\BemLocavel;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition()
    {
        $startDate = $this->faker->dateTimeBetween('now', '+1 month');
        $endDate = $this->faker->dateTimeBetween($startDate, '+2 months');

        return [
            'user_id' => User::factory(),
            'bem_locavel_id' => BemLocavel::factory(),
            'data_inicio' => $startDate->format('Y-m-d'),
            'data_fim' => $endDate->format('Y-m-d'),
            'status' => $this->faker->randomElement(['pendente', 'confirmada', 'cancelada']),
        ];
    }
}
