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

class CaracteristicaController extends Controller
{
    public function index() {
        return Caracteristica::all();
    }

    public function store(Request $request) {
        $data = $request->validate(['nome' => 'required|string']);
        return Caracteristica::create($data);
    }

    public function show(Caracteristica $caracteristica) {
        return $caracteristica;
    }

    public function update(Request $request, Caracteristica $caracteristica) {
        $caracteristica->update($request->validate(['nome' => 'required|string']));
        return $caracteristica;
    }

    public function destroy(Caracteristica $caracteristica) {
        $caracteristica->delete();
        return response()->noContent();
    }
}
