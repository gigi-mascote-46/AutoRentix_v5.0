<?php

namespace Tests\Feature;

use App\Models\BemLocavel;
use App\Models\Marca;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class VehicleDatabaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a vehicle cannot be created without a valid tipo_bem_id.
     */
    public function test_cannot_create_vehicle_without_tipo_bem_id(): void
    {
        // 1. Setup: Create a valid Brand (Marca) which requires a TipoBem
        // We insert directly into tipo_bens to avoid Model dependencies if they don't exist yet
        $tipoBemId = DB::table('tipo_bens')->insertGetId([
            'nome' => 'Test Type',
        ]);

        $marca = Marca::create([
            'nome' => 'Test Brand',
            'tipo_bem_id' => $tipoBemId,
        ]);

        // 2. Expectation: The database should throw a QueryException due to the NOT NULL constraint
        $this->expectException(QueryException::class);

        // 3. Action: Attempt to create a vehicle without providing 'tipo_bem_id'
        // We use forceCreate to bypass mass-assignment and hit the database directly
        BemLocavel::forceCreate([
            'nome' => 'Test Vehicle',
            'marca_id' => $marca->id,
            // 'tipo_bem_id' is intentionally omitted to trigger the error
            'modelo' => 'Test Model',
            'cor' => 'Blue',
            'ano' => 2024,
            'preco_diario' => 100.00,
        ]);
    }
}
