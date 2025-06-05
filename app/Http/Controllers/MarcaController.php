<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    public function index()
    {
        $marcas = Marca::all();
        return response()->json($marcas);
    }

    public function show($id)
    {
        $marca = Marca::findOrFail($id);
        return response()->json($marca);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo_bem_id' => 'required|integer|exists:tipo_bens,id',
            'nome' => 'required|string|max:100',
            'observacao' => 'nullable|string',
        ]);

        $marca = Marca::create($validated);
        return response()->json($marca, 201);
    }

    public function update(Request $request, $id)
    {
        $marca = Marca::findOrFail($id);

        $validated = $request->validate([
            'tipo_bem_id' => 'sometimes|required|integer|exists:tipo_bens,id',
            'nome' => 'sometimes|required|string|max:100',
            'observacao' => 'nullable|string',
        ]);

        $marca->update($validated);
        return response()->json($marca);
    }

    public function destroy($id)
    {
        $marca = Marca::findOrFail($id);
        $marca->delete();
        return response()->json(null, 204);
    }
}
