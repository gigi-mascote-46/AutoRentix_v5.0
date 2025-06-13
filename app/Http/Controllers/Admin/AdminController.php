<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\Reservation;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Obtém a data atual usando Carbon (biblioteca de manipulação de datas)
        $today = Carbon::today();

        // Procura reservas futuras e as formata para a view
        $upcomingReservations = Reservation::with('bemLocavel', 'bemLocavel.marca', 'user') // Carrega relacionamentos
            ->where('data_inicio', '>=', $today) // Filtra reservas a partir de hoje
            ->orderBy('data_inicio', 'asc') // Ordena por data de início
            ->get()
            ->map(function ($reservation) { // Transforma cada reserva
                // Calcula a duração em dias entre início e fim
                $duration = Carbon::parse($reservation->data_inicio)->diffInDays(
                    Carbon::parse($reservation->data_fim)
                );

                // Retorna array formatado com dados relevantes
                return [
                    'id' => $reservation->id,
                    'matricula' => $reservation->bemLocavel->matricula ?? 'N/D', // Placa do veículo
                    'marca' => $reservation->bemLocavel->marca->nome ?? 'N/D', // Marca do veículo
                    'modelo' => $reservation->bemLocavel->modelo ?? 'N/D', // Modelo do veículo
                    'duration' => $duration, // Duração da reserva em dias
                    'data_inicio' => $reservation->data_inicio, // Data de início
                    'data_fim' => $reservation->data_fim, // Data de término
                ];
            });

        // Retorna a view Inertia com os dados
        return Inertia::render('AreaAdmin/Admin/Dashboard', [
            // Reservas formatadas
            'upcomingReservations' => $upcomingReservations,

            // Estatísticas para o dashboard
            'stats' => [
                'vehicles' => \App\Models\BemLocavel::count(), // Total de veículos
                'users' => \App\Models\User::count(), // Total de usuários
                'activeReservations' => \App\Models\Reservation::where('data_fim', '>=', \Carbon\Carbon::today())->count(), // Reservas ativas
            ],
        ]);
    }
}
