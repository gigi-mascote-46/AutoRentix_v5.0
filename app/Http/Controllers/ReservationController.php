<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    // Lista todas as reservas existentes na base de dados
    public function index()
    {
        $reservations = Reservation::all();
        return response()->json($reservations);
    }

    // Mostra uma reserva específica, identificada pelo seu ID
    public function show($id)
    {
        $reservation = Reservation::findOrFail($id);
        return response()->json($reservation);
    }

    // Cria uma nova reserva após validar os dados recebidos via request
    public function store(Request $request)
    {
        // Validação dos campos obrigatórios para criação da reserva
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id', // O ID do utilizador tem de existir na tabela users
            'registo_unico_publico' => 'required|string|max:20|exists:bens_locaveis,registo_unico_publico', // O registo único tem de existir na tabela bens_locaveis
            'data_inicio' => 'required|date', // Data de início da reserva, formato válido de data
            'data_fim' => 'required|date|after_or_equal:data_inicio', // Data de fim, tem de ser igual ou posterior à data de início
            'status' => 'in:pendente,confirmada,cancelada', // Status da reserva, caso enviado, deve estar entre estes valores
        ]);

        // Cria efetivamente a reserva com os dados validados
        $reservation = Reservation::create($validated);

        // Retorna a nova reserva criada em formato JSON com código 201 (created)
        return response()->json($reservation, 201);
    }

    // Atualiza uma reserva existente, identificada pelo seu ID
    public function update(Request $request, $id)
    {
        // Busca a reserva, falha se não existir
        $reservation = Reservation::findOrFail($id);

        // Validação dos dados recebidos para atualização
        // Campos podem ser enviados de forma parcial (por isso "sometimes")
        $validated = $request->validate([
            'user_id' => 'sometimes|required|integer|exists:users,id', // Se enviado, tem de ser válido
            'registo_unico_publico' => 'sometimes|required|string|max:20|exists:bens_locaveis,registo_unico_publico',
            'data_inicio' => 'sometimes|required|date',
            'data_fim' => 'sometimes|required|date|after_or_equal:data_inicio',
            'status' => 'in:pendente,confirmada,cancelada',
        ]);

        // Atualiza os dados da reserva com os valores validados
        $reservation->update($validated);

        // Retorna a reserva atualizada em JSON
        return response()->json($reservation);
    }

    // Elimina uma reserva pelo seu ID
    public function destroy($id)
    {
        // Busca a reserva, falha se não existir
        $reservation = Reservation::findOrFail($id);

        // Apaga a reserva da base de dados
        $reservation->delete();

        // Retorna resposta vazia com status 204 (no content) indicando sucesso na eliminação
        return response()->json(null, 204);
    }
}
