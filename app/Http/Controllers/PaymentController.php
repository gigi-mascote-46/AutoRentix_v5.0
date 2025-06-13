<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Http\Request;

// Controller responsável pelas operações CRUD para pagamentos
class PaymentController extends Controller
{
    // Lista todos os pagamentos
    public function index()
    {
        $payments = Payment::all();
        return response()->json($payments);
    }

    // Mostra um pagamento específico pelo ID
    public function show($id)
    {
        $payment = Payment::findOrFail($id);
        return response()->json($payment);
    }

    // Cria um novo pagamento validando os dados da requisição
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bem_id' => 'required|exists:bens_locaveis,id',
            'nome' => 'required|string',
            'apelido' => 'required|string',
            'data_nascimento' => 'required|date',
            'email' => 'required|email',
            'telefone' => 'required|string',
            'metodo_pagamento' => 'required|string',
            'dataInicio' => 'required|date',
            'dataFim' => 'required|date',
            'total' => 'required|numeric',
        ]);

        // Cria a reserva
        $reserva = Reservation::create([
            'bem_locavel_id' => $validated['bem_id'],
            'nome' => $validated['nome'],
            'apelido' => $validated['apelido'],
            'data_nascimento' => $validated['data_nascimento'],
            'email' => $validated['email'],
            'telefone' => $validated['telefone'],
            'metodo_pagamento' => $validated['metodo_pagamento'],
            'data_inicio' => $validated['dataInicio'],
            'data_fim' => $validated['dataFim'],
            'total' => $validated['total'],
        ]);

        // Cria o pagamento associado (opcional, ajuste conforme sua lógica)
        $payment = Payment::create([
            'reservation_id' => $reserva->id,
            'metodo' => $validated['metodo_pagamento'],
            'montante' => $validated['total'],
            'status' => 'pendente', // ou 'confirmado', conforme sua lógica
        ]);

        // Retorna resposta para Inertia ou API
        return response()->json([
            'success' => true,
            'reserva' => $reserva,
            'payment' => $payment,
        ]);
    }

    // Atualiza um pagamento existente
    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $validated = $request->validate([
            'reservation_id' => 'sometimes|required|integer|exists:reservations,id',
            'metodo' => 'sometimes|required|string|max:255',
            'montante' => 'sometimes|required|numeric',
            'status' => 'sometimes|required|string|max:255',
        ]);

        $payment->update($validated);
        return response()->json($payment);
    }

    // Remove um pagamento pelo ID
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();
        return response()->json(null, 204); // Retorna 204 No Content para indicar sucesso na eliminação
    }
}
