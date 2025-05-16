<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::where('user_id', Auth::id())->with('bemLocavel')->get();
        return Inertia::render('MyReservations/Index', compact('reservations'));
    }

    public function show($id)
    {
        $reservation = Reservation::where('id', $id)
            ->where('user_id', Auth::id())
            ->with('bemLocavel')
            ->firstOrFail();

        return Inertia::render('MyReservations/Show', compact('reservation'));
    }

    public function create()
    {
        // Pode-se carregar dados necessários para criar reserva
        // Exemplo: lista de bens disponíveis
        // Supondo que tenhas um método em BemLocavel para filtrar
        $bens = \App\Models\BemLocavel::where('manutencao', false)->get();
        return Inertia::render('MyReservations/Create', compact('bens'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bem_locavel_id' => 'required|exists:bens_locaveis,id',
            'data_inicio' => 'required|date|after_or_equal:today',
            'data_fim' => 'required|date|after:data_inicio',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pendente'; // status padrão

        Reservation::create($validated);

        return redirect()->route('my_reservations.index')->with('success', 'Reserva criada com sucesso!');
    }

    public function destroy($id)
    {
        $reservation = Reservation::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $reservation->delete();

        return back()->with('success', 'Reserva cancelada com sucesso!');
    }
}
