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


class LocalizacaoController extends Controller
{
    public function index() {
        return Localizacao::all();
    }

    public function store(Request $request) {
        $data = $request->validate([
            'nome' => 'required|string',
            'endereco' => 'required|string',
            'codigo_postal' => 'required|string',
            'cidade' => 'required|string'
        ]);
        return Localizacao::create($data);
    }

    public function show(Localizacao $localizacao) {
        return $localizacao;
    }

    public function update(Request $request, Localizacao $localizacao) {
        $localizacao->update($request->all());
        return $localizacao;
    }

    public function destroy(Localizacao $localizacao) {
        $localizacao->delete();
        return response()->noContent();
    }
}
