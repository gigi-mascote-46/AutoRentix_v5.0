<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;

class PageController extends Controller
{
    public function about()
    {
        return Inertia::render('Publico/About');
    }

    public function contact()
    {
        return Inertia::render('Publico/Contact');
    }

    public function terms()
    {
        return Inertia::render('Publico/Terms');
    }

    public function privacy()
    {
        return Inertia::render('Publico/PrivacyPolicy');
    }

    public function complaint()
    {
        return Inertia::render('Publico/Complaint');
    }

    public function help()
    {
        return Inertia::render('Publico/Help');
    }

    public function refund()
    {
        return Inertia::render('Publico/Refund');
    }

    public function clientDashboard()
    {
        $user = Auth::user();

        $stats = [
            'ativas' => Reservation::where('user_id', $user->id)->where('status', 'confirmada')->count(),
            'concluidas' => Reservation::where('user_id', $user->id)->where('status', 'cancelada')->count(),
            'totalGasto' => 0,
        ];

        $reservasRecentes = Reservation::with('bemLocavel')
            ->where('user_id', $user->id)
            ->orderBy('data_inicio', 'desc')
            ->limit(5)
            ->get();

        $totalGasto = 0;
        foreach ($reservasRecentes as $reserva) {
            $dias = $reserva->data_inicio->diffInDays($reserva->data_fim);
            $precoDiario = $reserva->bemLocavel ? $reserva->bemLocavel->preco_diario : 0;
            $totalGasto += $dias * $precoDiario;
        }
        $stats['totalGasto'] = $totalGasto;

        return Inertia::render('AreaCliente/Dashboard', [
            'user' => $user,
            'stats' => $stats,
            'reservasRecentes' => $reservasRecentes,
        ]);
    }
}
