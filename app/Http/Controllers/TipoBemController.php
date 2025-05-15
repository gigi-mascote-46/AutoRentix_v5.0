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
class TipoBemController extends Controller
{
    public function index() {
        return TipoBem::all();
    }

    public function store(Request $request) {
        $data = $request->validate(['nome' => 'required|string']);
        return TipoBem::create($data);
    }

    public function show(TipoBem $tipoBem) {
        return $tipoBem;
    }

    public function update(Request $request, TipoBem $tipoBem) {
        $tipoBem->update($request->validate(['nome' => 'required|string']));
        return $tipoBem;
    }

    public function destroy(TipoBem $tipoBem) {
        $tipoBem->delete();
        return response()->noContent();
    }
}
