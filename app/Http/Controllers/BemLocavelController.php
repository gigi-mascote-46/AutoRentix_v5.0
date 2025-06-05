<?php

namespace App\Http\Controllers;

use App\Models\BemLocavel;
use Illuminate\Http\Request;

class BemLocavelController extends Controller
{
    public function index()
    {
        $bens = BemLocavel::all();
        return response()->json($bens);
    }

    public function show($id)
    {
        $bem = BemLocavel::findOrFail($id);
        return response()->json($bem);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'registo_unico_publico' => 'required|string|unique:bens_locaveis,registo_unico_publico',
            'preco_por_dia' => 'required|numeric',
            'disponivel' => 'boolean',
            'tipo_bem_id' => 'required|integer|exists:tipo_bens,id',
            'marca_id' => 'required|integer|exists:marca,id',
            'modelo' => 'nullable|string|max:100',
            'ano' => 'nullable|integer',
            'matricula' => 'nullable|string|max:20',
            'combustivel' => 'nullable|string|max:20',
            'transmissao' => 'nullable|string|max:20',
            'lugares' => 'nullable|integer',
            'portas' => 'nullable|integer',
            'ar_condicionado' => 'boolean',
            'gps' => 'boolean',
            'bluetooth' => 'boolean',
        ]);

        $bem = BemLocavel::create($validated);
        return response()->json($bem, 201);
    }

    public function update(Request $request, $id)
    {
        $bem = BemLocavel::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'descricao' => 'nullable|string',
            'registo_unico_publico' => 'sometimes|required|string|unique:bens_locaveis,registo_unico_publico,' . $id,
            'preco_por_dia' => 'sometimes|required|numeric',
            'disponivel' => 'boolean',
            'tipo_bem_id' => 'sometimes|required|integer|exists:tipo_bens,id',
            'marca_id' => 'sometimes|required|integer|exists:marca,id',
            'modelo' => 'nullable|string|max:100',
            'ano' => 'nullable|integer',
            'matricula' => 'nullable|string|max:20',
            'combustivel' => 'nullable|string|max:20',
            'transmissao' => 'nullable|string|max:20',
            'lugares' => 'nullable|integer',
            'portas' => 'nullable|integer',
            'ar_condicionado' => 'boolean',
            'gps' => 'boolean',
            'bluetooth' => 'boolean',
        ]);

        $bem->update($validated);
        return response()->json($bem);
    }

    public function destroy($id)
    {
        $bem = BemLocavel::findOrFail($id);
        $bem->delete();
        return response()->json(null, 204);
    }
}
