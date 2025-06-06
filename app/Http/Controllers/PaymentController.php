<?php

namespace App\Http\Controllers;

use App\Models\Payment;
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
            'reservation_id' => 'required|integer|exists:reservations,id', // Confirma que a reserva existe
            'metodo' => 'required|string|max:255',                        // Método de pagamento
            'montante' => 'required|numeric',                             // Valor pago
            'status' => 'required|string|max:255',                        // Estado do pagamento (ex: pendente, confirmado)
        ]);

        $payment = Payment::create($validated);
        return response()->json($payment, 201); // Retorna 201 Created
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
