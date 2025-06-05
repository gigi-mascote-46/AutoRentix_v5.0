<?php

namespace App\Http\Controllers;

use App\Models\TipoBem;
use Illuminate\Http\Request;

class TipoBemController extends Controller
{
    public function index()
    {
        $tipos = TipoBem::all();
        return response()->json($tipos);
    }

    public function show($id)
    {
        $tipo = TipoBem::findOrFail($id);
        return response()->json($tipo);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100|unique:tipo_bens,nome',
        ]);

        $tipo = TipoBem::create($validated);
        return response()->json($tipo, 201);
    }

    public function update(Request $request, $id)
    {
        $tipo = TipoBem::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string|max:100|unique:tipo_bens,nome,' . $id,
        ]);

        $tipo->update($validated);
        return response()->json($tipo);
    }

    public function destroy($id)
    {
        $tipo = TipoBem::findOrFail($id);
        $tipo->delete();
        return response()->json(null, 204);
    }
}
