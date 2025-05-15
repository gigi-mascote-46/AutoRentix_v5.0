<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BemLocavel;
use App\Models\Caracteristica;

class CaracteristicaBensSeeder extends Seeder
{
    public function run()
    {
        $caracteristicas = Caracteristica::all();

        BemLocavel::all()->each(function ($bem) use ($caracteristicas) {
            $bem->caracteristicas()->attach(
                $caracteristicas->random(rand(1, 4))->pluck('id')->toArray()
            );
        });
    }
}
