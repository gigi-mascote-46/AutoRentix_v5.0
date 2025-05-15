<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pagamento;

class PagamentosSeeder extends Seeder
{
    public function run()
    {
        Pagamento::factory()->count(20)->create();
    }
}
