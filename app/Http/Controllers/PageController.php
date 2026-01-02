<?php

namespace App\Http\Controllers;

use App\Models\Localizacao;
use App\Models\TipoBem;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use Carbon\Carbon;

class PageController extends Controller
{
    // Página inicial (home)
    public function home()
    {
        // Seleciona só os campos necessários para as localizações e tipos de veículos
        $locations = Localizacao::select('cidade as nome')->distinct()->get();
        $vehicleTypes = TipoBem::select('id', 'nome')->get();

        // Adicione um id fictício para o v-for funcionar (opcional)
    $locations = $locations->map(function($loc, $index) {
        $loc->id = $index + 1;
        return $loc;
    });

        return Inertia::render('Publico/Home', [
            'locations' => $locations,
            'vehicleTypes' => $vehicleTypes,
            'vehiclesIndexUrl' => route('publico.vehicles.index'), // URL para a listagem de veículos
            'auth' => ['user' => Auth::user()],
        ]);
    }

    // Página "Sobre"
    public function about()
    {
        return Inertia::render('Publico/About');
    }

    // Página de contacto
    public function contact()
    {
        return Inertia::render('Publico/Contact');
    }

    // Página de ajuda
    public function help()
    {
        return Inertia::render('Publico/Help');
    }

    // Página dos termos e condições
    public function terms()
    {
        return Inertia::render('Publico/Terms');
    }

    // Página de política de reembolso
    public function refund()
    {
        return Inertia::render('Publico/Refund');
    }

    // Página de reclamações
    public function complaint()
    {
        return Inertia::render('Publico/Complaint');
    }

    // Dashboard do cliente autenticado
    public function clientDashboard()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Contagem de reservas ativas (pendente) e concluídas (confirmada)
        $ativasCount = Reservation::where('user_id', $user->id)->where('status', 'pendente')->count();
        $concluidasCount = Reservation::where('user_id', $user->id)->where('status', 'confirmada')->count();

        // Reservas confirmadas para cálculo do total gasto
        $reservasConfirmadas = Reservation::where('user_id', $user->id)
            ->where('status', 'confirmada')
            ->with('bemLocavel')
            ->get();

        $totalGasto = 0;

        foreach ($reservasConfirmadas as $reserva) {
            if ($reserva->bemLocavel) {
                $dataInicio = Carbon::parse($reserva->data_inicio);
                $dataFim = Carbon::parse($reserva->data_fim);
                $dias = $dataFim->diffInDays($dataInicio) + 1; // Inclui o primeiro e último dia
                $totalGasto += $reserva->bemLocavel->preco_por_dia * $dias;
            }
        }

        $stats = [
            'ativas' => $ativasCount,
            'concluidas' => $concluidasCount,
            'totalGasto' => $totalGasto,
        ];

        // 5 reservas mais recentes do utilizador
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
