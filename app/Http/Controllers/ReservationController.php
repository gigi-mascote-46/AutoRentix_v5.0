<?php

namespace App\Http\Controllers;

use App\Models\BemLocavel;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\PayPalController;
use Illuminate\Http\RedirectResponse;

class ReservationController extends Controller
{
    public function confirm($id)
    {
        $bem = BemLocavel::with('marca', 'caracteristicas', 'localizacao')->findOrFail($id);
        return Inertia::render('AreaCliente/Reservations/Confirm', compact('bem'));
    }

    public function payment(Request $request, $id)
    {
        $bem = BemLocavel::with('marca', 'caracteristicas', 'localizacao')->findOrFail($id);

        $dataInicio = $request->query('dataInicio');
        $dataFim = $request->query('dataFim');

        // Calculate total price (simple example)
        $days = (strtotime($dataFim) - strtotime($dataInicio)) / 86400 + 1;
        $total = $days * $bem->preco_diario;

        return Inertia::render('AreaCliente/Reservations/Payment', compact('bem', 'dataInicio', 'dataFim', 'total'));
    }

    public function processPayment(Request $request, $id)
    {
        $paymentMethod = $request->input('metodo_pagamento');

        if ($paymentMethod === 'paypal') {
            $bem = BemLocavel::findOrFail($id);
            $dataInicio = $request->input('dataInicio');
            $dataFim = $request->input('dataFim');

            $days = (strtotime($dataFim) - strtotime($dataInicio)) / 86400 + 1;
            $total = $days * $bem->preco_diario;

            // Redirect to PayPalController processTransaction with amount
            return redirect()->action([PayPalController::class, 'processTransaction'], ['amount' => $total]);
        }

        // Validate payment and reservation data here (simplified)
        $request->validate([
            'nome' => 'required|string',
            'apelido' => 'required|string',
            'data_nascimento' => 'required|date',
            'email' => 'required|email',
            'telefone' => 'required|string',
            'cartao_numero' => 'required|string',
            'cartao_validade' => 'required|string',
            'cartao_cvv' => 'required|string',
            'dataInicio' => 'required|date',
            'dataFim' => 'required|date|after_or_equal:dataInicio',
        ]);

        // Create reservation record
        $reservation = new Reservation();
        $reservation->bem_locavel_id = $id;
        $reservation->data_inicio = $request->dataInicio;
        $reservation->data_fim = $request->dataFim;
        $reservation->status = 'pending';
        $reservation->user_nome = $request->nome;
        $reservation->user_apelido = $request->apelido;
        $reservation->user_data_nascimento = $request->data_nascimento;
        $reservation->user_email = $request->email;
        $reservation->user_telefone = $request->telefone;
        // Payment details would be processed here securely
        $reservation->save();

        // Redirect to a confirmation page or back to vehicle page
        return redirect()->route('vehicles.index')->with('success', 'Reserva efetuada com sucesso!');
    }
}
