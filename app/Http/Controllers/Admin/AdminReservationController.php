<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Inertia\Inertia;

class AdminReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with('user', 'bemLocavel')->get();
        return Inertia::render('Admin/Reservations/Index', compact('reservations'));
    }

    public function show($id)
    {
        $reservation = Reservation::with('user', 'bemLocavel')->findOrFail($id);
        return Inertia::render('Admin/Reservations/Show', compact('reservation'));
    }

    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pendente,confirmada,cancelada',
        ]);

        $reservation->update($validated);

        return redirect()->route('admin.reservations.index')->with('success', 'Reserva atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return back()->with('success', 'Reserva removida com sucesso!');
    }
}
