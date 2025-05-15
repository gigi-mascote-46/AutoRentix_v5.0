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

class BemLocavelController extends Controller
{
    public function index() {
        return BemLocavel::with(['marca', 'tipoBem', 'localizacao', 'caracteristicas'])->get();
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nome' => 'required|string',
            'descricao' => 'nullable|string',
            'preco_dia' => 'required|numeric',
            'marca_id' => 'required|exists:marcas,id',
            'tipo_bem_id' => 'required|exists:tipo_bens,id',
            'localizacao_id' => 'required|exists:localizacoes,id',
            'disponivel' => 'boolean',
        ]);

        $bem = BemLocavel::create($validated);
        $bem->caracteristicas()->sync($request->caracteristicas ?? []);

        return response()->json($bem->load('caracteristicas'), 201);
    }

    public function show(BemLocavel $bemLocavel) {
        return $bemLocavel->load(['marca', 'tipoBem', 'localizacao', 'caracteristicas']);
    }

    public function update(Request $request, BemLocavel $bemLocavel) {
        $bemLocavel->update($request->all());
        if ($request->has('caracteristicas')) {
            $bemLocavel->caracteristicas()->sync($request->caracteristicas);
        }
        return $bemLocavel->load('caracteristicas');
    }

    public function destroy(BemLocavel $bemLocavel) {
        $bemLocavel->delete();
        return response()->noContent();
    }
}
