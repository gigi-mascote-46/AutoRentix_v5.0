<?php

namespace App\Http\Controllers;

use App\Models\BemLocavel;
use Inertia\Inertia;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;


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
    try {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:bens_locaveis,id',
            'nome' => 'required|string',
            'apelido' => 'required|string',
            'data_nascimento' => 'required|date',
            'email' => 'required|email',
            'telefone' => 'required|string',
            'metodo_pagamento' => 'required|string',
            'dataInicio' => 'required|date',
            'dataFim' => 'required|date',
            'total' => 'required|numeric',
            'localizacao_entrega' => 'required|exists:localizacoes,id',
            'localizacao_recolha' => 'required|exists:localizacoes,id',
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return back()->withErrors($e->errors())->withInput();
    }

    $userId = Auth::check() ? Auth::user()->id : null;

    $reserva = Reservation::create([
        'user_id' => $userId,
        'vehicle_id' => $validated['vehicle_id'],
        'data_inicio' => $validated['dataInicio'],
        'data_fim' => $validated['dataFim'],
        'localizacao_entrega' => $validated['localizacao_entrega'],
        'localizacao_recolha' => $validated['localizacao_recolha'],
    ]);

    // Redireciona para a página de finalização da transação
    return Inertia::render('AreaCliente/Reservations/FinishTransaction', [
        'amount' => $validated['total'],
        'payerName' => $validated['nome'] . ' ' . $validated['apelido'],
    ]);
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

   public function payment(Request $request, $id)
{
    $vehicle = BemLocavel::with('marca')->findOrFail($id);

    $dataInicio = $request->input('dataInicio');
    $dataFim = $request->input('dataFim');
    $dias = (strtotime($dataFim) - strtotime($dataInicio)) / 86400;
    $total = $dias * $vehicle->preco_por_dia;

    return Inertia::render('AreaCliente/Reservations/Payment', [
        'bem' => $vehicle,
        'dataInicio' => $dataInicio,
        'dataFim' => $dataFim,
        'total' => $total,
    ]);
}


public function finishTransaction(Request $request)
{
    return Inertia::render('AreaCliente/Reservations/FinishTransaction', [
        'amount' => session('amount'),
        'payerName' => session('payerName'),
    ]);
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
