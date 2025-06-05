<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::all();
        return response()->json($payments);
    }

    public function show($id)
    {
        $payment = Payment::findOrFail($id);
        return response()->json($payment);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reservation_id' => 'required|integer|exists:reservations,id',
            'metodo' => 'required|string|max:255',
            'montante' => 'required|numeric',
            'status' => 'required|string|max:255',
        ]);

        $payment = Payment::create($validated);
        return response()->json($payment, 201);
    }

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

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();
        return response()->json(null, 204);
    }
}
