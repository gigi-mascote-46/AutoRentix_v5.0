<?php

namespace App\Http\Controllers;

use App\Models\Localizacao;
use App\Models\TipoBem;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;

// Controller responsável pelas páginas públicas e pelo dashboard do cliente
class PageController extends Controller
{
    // Método para a página inicial (home)
    public function home()
    {
        // Obtemos todas as localizações disponíveis
        $locations = Localizacao::all();

        // Obtemos todos os tipos de veículos (bens)
        $vehicleTypes = TipoBem::all();

        // Renderizamos a view 'Publico/Home' com os dados de localizações e tipos de veículos
        return Inertia::render('Publico/Home', [
            'locations' => $locations,
            'vehicleTypes' => $vehicleTypes,
        ]);
    }

    // Método para a página "Sobre" (about)
    public function about()
    {
        // Renderiza a página 'Publico/About' sem dados adicionais
        return Inertia::render('Publico/About');
    }

    // Método para a página de contacto
    public function contact()
    {
        return Inertia::render('Publico/Contact');
    }

    // Método para a página de ajuda
    public function help()
    {
        return Inertia::render('Publico/Help');
    }

    // Método para a página dos termos e condições
    public function terms()
    {
        return Inertia::render('Publico/Terms');
    }

    // Método para a página de política de reembolso
    public function refund()
    {
        return Inertia::render('Publico/Refund');
    }

    // Método para a página de reclamações
    public function complaint()
    {
        return Inertia::render('Publico/Complaint');
    }

    // Método para o dashboard do cliente autenticado
    public function clientDashboard()
    {
        // Obtém o utilizador autenticado
        $user = Auth::user();

        // Se não estiver autenticado, redireciona para a página de login
        if (!$user) {
            return redirect()->route('login');
        }

        // Calcula algumas estatísticas do utilizador:
        // - Reservas ativas (status 'pendente')
        // - Reservas concluídas (status 'confirmada')
        // - Total gasto em reservas concluídas
        $stats = [
            'ativas' => Reservation::where('user_id', $user->id)->where('status', 'pendente')->count(),
            'concluidas' => Reservation::where('user_id', $user->id)->where('status', 'confirmada')->count(),
            'totalGasto' => Reservation::where('user_id', $user->id)->where('status', 'confirmada')->sum('total_price'),
        ];

        // Obtém as 5 reservas mais recentes do utilizador, ordenadas pela data de início
        $reservasRecentes = Reservation::where('user_id', $user->id)
            ->orderBy('data_inicio', 'desc')
            ->take(5)
            ->get();

        // Renderiza a view do dashboard do cliente com os dados do utilizador, estatísticas e reservas recentes
        return Inertia::render('AreaCliente/Dashboard', [
            'user' => $user,
            'stats' => $stats,
            'reservasRecentes' => $reservasRecentes,
        ]);
    }
}
