<?php

namespace App\Http\Controllers;

use App\Models\BemLocavel;
use App\Models\Caracteristica;
use App\Models\Localizacao;
use App\Models\Marca;
use App\Models\Pagamento;
use App\Models\Reserva;
use App\Models\TipoBem;
use App\Models\User;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function index() {
        return Reserva::with(['user', 'bemLocavel'])->get();
    }

    public function store(Request $request) {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'bem_locavel_id' => 'required|exists:bens_locaveis,id',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio'
        ]);
        return Reserva::create($data);
    }

    public function show(Reserva $reserva) {
        return $reserva->load(['user', 'bemLocavel']);
    }

    public function update(Request $request, Reserva $reserva) {
        $reserva->update($request->all());
        return $reserva->load(['user', 'bemLocavel']);
    }

    public function destroy(Reserva $reserva) {
        $reserva->delete();
        return response()->noContent();
    }
}
