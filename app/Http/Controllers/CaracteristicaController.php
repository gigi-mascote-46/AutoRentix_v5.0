<?php

namespace App\Http\Controllers;

use App\Models\Caracteristica;
use Illuminate\Http\Request;

class CaracteristicaController extends Controller
{
    public function index()
    {
        $caracteristicas = Caracteristica::all();
        return response()->json($caracteristicas);
    }

    public function show($id)
    {
        $caracteristica = Caracteristica::findOrFail($id);
        return response()->json($caracteristica);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100|unique:caracteristicas,nome',
        ]);

        $caracteristica = Caracteristica::create($validated);
        return response()->json($caracteristica, 201);
    }

    public function update(Request $request, $id)
    {
        $caracteristica = Caracteristica::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string|max:100|unique:caracteristicas,nome,' . $id,
        ]);

        $caracteristica->update($validated);
        return response()->json($caracteristica);
    }

    public function destroy($id)
    {
        $caracteristica = Caracteristica::findOrFail($id);
        $caracteristica->delete();
        return response()->json(null, 204);
    }
}
