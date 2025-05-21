<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Reservation;
use Carbon\Carbon;

class AdminController
{
    public function dashboard()
    {
        $today = Carbon::today();

        $upcomingReservations = Reservation::with('bemLocavel', 'bemLocavel.marca', 'user')
            ->where('data_inicio', '>=', $today)
            ->orderBy('data_inicio', 'asc')
            ->get()
            ->map(function ($reservation) {
                $duration = Carbon::parse($reservation->data_inicio)->diffInDays(Carbon::parse($reservation->data_fim));
                return [
                    'id' => $reservation->id,
                    'matricula' => $reservation->bemLocavel->matricula ?? 'N/D',
                    'marca' => $reservation->bemLocavel->marca->nome ?? 'N/D',
                    'modelo' => $reservation->bemLocavel->modelo ?? 'N/D',
                    'duration' => $duration,
                    'data_inicio' => $reservation->data_inicio,
                    'data_fim' => $reservation->data_fim,
                ];
            });

        return Inertia::render('Admin/Dashboard', [
            'upcomingReservations' => $upcomingReservations,
        ]);
    }
}
