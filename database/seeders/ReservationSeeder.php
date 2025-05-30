<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;

class ReservationSeeder extends Seeder
{
    public function run()
    {
        // Create 10 example reservations linking existing bens locaveis and users
        Reservation::factory()->count(10)->create();
    }
}
