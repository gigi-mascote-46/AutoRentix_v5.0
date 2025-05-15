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

class MarcaController extends Controller
{
    public function index() {
        return Marca::all();
    }

    public function store(Request $request) {
        $data = $request->validate(['nome' => 'required|string']);
        return Marca::create($data);
    }

    public function show(Marca $marca) {
        return $marca;
    }

    public function update(Request $request, Marca $marca) {
        $marca->update($request->validate(['nome' => 'required|string']));
        return $marca;
    }

    public function destroy(Marca $marca) {
        $marca->delete();
        return response()->noContent();
    }
}
