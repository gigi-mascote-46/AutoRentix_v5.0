<?php

namespace App\Http\Controllers;

use App\Models\Localizacao;
use Illuminate\Http\Request;

class LocalizacaoController extends Controller
{
    public function index()
    {
        $localizacoes = Localizacao::all();
        return response()->json($localizacoes);
    }

    public function show($id)
    {
        $localizacao = Localizacao::findOrFail($id);
        return response()->json($localizacao);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'registo_unico_publico' => 'required|string|max:20|unique:localizacoes,registo_unico_publico',
            'cidade' => 'required|string|max:100',
            'filial' => 'nullable|string|max:100',
            'posicao' => 'required|string|max:100',
        ]);

        $localizacao = Localizacao::create($validated);
        return response()->json($localizacao, 201);
    }

    public function update(Request $request, $id)
    {
        $localizacao = Localizacao::findOrFail($id);

        $validated = $request->validate([
            'registo_unico_publico' => 'required|string|max:20|unique:localizacoes,registo_unico_publico,' . $id,
            'cidade' => 'required|string|max:100',
            'filial' => 'nullable|string|max:100',
            'posicao' => 'required|string|max:100',
        ]);

        $localizacao->update($validated);
        return response()->json($localizacao);
    }

    public function destroy($id)
    {
        $localizacao = Localizacao::findOrFail($id);
        $localizacao->delete();
        return response()->json(null, 204);
    }
}
