<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Inertia\Inertia;

class AdminPaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('reservation')->get();
        return Inertia::render('Admin/Payments/Index', compact('payments'));
    }

    public function show($id)
    {
        $payment = Payment::with('reservation')->findOrFail($id);
        return Inertia::render('Admin/Payments/Show', compact('payment'));
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return back()->with('success', 'Pagamento removido com sucesso!');
    }
}
