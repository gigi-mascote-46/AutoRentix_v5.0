<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\BemLocavel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReservationPaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_reservation_creation()
    {
        // Create a user and a BemLocavel (rental item)
        $user = User::factory()->create();
        $bem = BemLocavel::factory()->create(['preco_diario' => 100]);

        // Acting as the user
        $response = $this->actingAs($user)->post(route('vehicles.reserve.payment.process', ['id' => $bem->id]), [
            'metodo_pagamento' => 'other',
            'nome' => 'John',
            'apelido' => 'Doe',
            'data_nascimento' => '1990-01-01',
            'email' => 'john@example.com',
            'telefone' => '123456789',
            'cartao_numero' => '4111111111111111',
            'cartao_validade' => '12/25',
            'cartao_cvv' => '123',
            'dataInicio' => '2025-06-10',
            'dataFim' => '2025-06-15',
        ]);

        $response->assertRedirect(route('vehicles.index'));
        $this->assertDatabaseHas('reservations', [
            'user_nome' => 'John',
            'bem_locavel_id' => $bem->id,
            'status' => 'pending',
        ]);
    }

    public function test_paypal_process_transaction_requires_token()
    {
        $response = $this->post(route('paypal.processTransaction'), []);
        $response->assertStatus(422); // Validation error expected
    }
}
