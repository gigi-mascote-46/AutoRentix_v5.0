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
use App\Models\BemCaracteristica;
use Illuminate\Http\Request;

class BemCaracteristicaController extends Controller
{
    public function index() {
        return BemCaracteristica::all();
    }

    public function store(Request $request) {
        $data = $request->validate([
            'bem_locavel_id' => 'required|exists:bens_locaveis,id',
            'caracteristica_id' => 'required|exists:caracteristicas,id'
        ]);
        return BemCaracteristica::create($data);
    }

    public function destroy(BemCaracteristica $bemCaracteristica) {
        $bemCaracteristica->delete();
        return response()->noContent();
    }
}
