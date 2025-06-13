<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Inertia\Inertia;
use Illuminate\Http\Request;

class AdminReservationController extends Controller
{
    /**
     * Exibe a lista de todas as reservas
     *
     * Recupera todas as reservas do banco de dados com seus relacionamentos (usuário e bem locável)
     * e renderiza a página de índice de reservas na área administrativa.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        // Carrega todas as reservas com os relacionamentos 'user' e 'bemLocavel'
        $reservations = Reservation::with('user', 'bemLocavel')->get();

        // Renderiza o componente Inertia 'Index' na pasta especificada, passando as reservas como prop
        return Inertia::render('AreaAdmin/Admin/Reservations/Index', compact('reservations'));
    }

    /**
     * Mostra os detalhes de uma reserva específica
     *
     * Busca uma reserva pelo ID com seus relacionamentos e renderiza a página de detalhes.
     * Caso não exista, retorna erro 404.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function show($id)
    {
        // Busca a reserva ou falha (404) se não encontrar, carregando relacionamentos
        $reservation = Reservation::with('user', 'bemLocavel')->findOrFail($id);

        // Renderiza a página de detalhes da reserva
        return Inertia::render('Admin/Reservations/Show', compact('reservation'));
    }

    /**
     * Atualiza o status de uma reserva
     *
     * Valida o campo 'status' e atualiza o registro no banco de dados.
     * Redireciona de volta para a lista de reservas com mensagem de sucesso.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Encontra a reserva ou retorna 404
        $reservation = Reservation::findOrFail($id);

        // Validação: campo 'status' é obrigatório e deve ter um dos valores especificados
        $validated = $request->validate([
            'status' => 'required|in:pendente,confirmada,cancelada',
        ]);

        // Atualiza a reserva com os dados validados
        $reservation->update($validated);

        // Redireciona para a lista de reservas com mensagem de sucesso
        return redirect()->route('admin.reservations.index')->with('success', 'Reserva atualizada com sucesso!');
    }

    /**
     * Exclui uma reserva
     *
     * Remove permanentemente uma reserva do banco de dados.
     * Retorna para a página anterior com mensagem de sucesso.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Encontra a reserva ou retorna 404
        $reservation = Reservation::findOrFail($id);

        // Exclui o registro do banco de dados
        $reservation->delete();

        // Retorna à página anterior (normalmente a lista de reservas) com mensagem
        return back()->with('success', 'Reserva removida com sucesso!');
    }
}
