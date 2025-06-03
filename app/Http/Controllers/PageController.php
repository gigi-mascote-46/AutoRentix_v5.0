<?php

namespace App\Http\Controllers;

use App\Models\Localizacao;
use App\Models\TipoBem;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;

class PageController extends Controller
{
    public function home()
    {
        $locations = Localizacao::all();
        $vehicleTypes = TipoBem::all();
        return Inertia::render('Publico/Home', [
            'locations' => $locations,
            'vehicleTypes' => $vehicleTypes,
        ]);
    }

    public function about()
    {
        return Inertia::render('Publico/About');
    }

    public function contact()
    {
        return Inertia::render('Publico/Contact');
    }

    public function help()
    {
        return Inertia::render('Publico/Help');
    }

    public function terms()
    {
        return Inertia::render('Publico/Terms');
    }

    public function refund()
    {
        return Inertia::render('Publico/Refund');
    }

    public function complaint()
    {
        return Inertia::render('Publico/Complaint');
    }

    public function clientDashboard()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $stats = [
            'ativas' => Reservation::where('user_id', $user->id)->where('status', 'pendente')->count(),
            'concluidas' => Reservation::where('user_id', $user->id)->where('status', 'confirmada')->count(),
            'totalGasto' => Reservation::where('user_id', $user->id)->where('status', 'confirmada')->sum('total_price'),
        ];

        $reservasRecentes = Reservation::where('user_id', $user->id)
            ->orderBy('data_inicio', 'desc')
            ->take(5)
            ->get();

        return Inertia::render('AreaCliente/Dashboard', [
            'user' => $user,
            'stats' => $stats,
            'reservasRecentes' => $reservasRecentes,
        ]);
    }
}
