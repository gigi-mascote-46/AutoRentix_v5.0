<?php

namespace App\Http\Controllers;

use App\Models\TipoBem;
use Illuminate\Http\Request;

class TipoBemController extends Controller
{
    // Lista todos os tipos de bens registados na base de dados
    public function index()
    {
        $tipos = TipoBem::all();
        return response()->json($tipos);
    }

    // Mostra um tipo de bem específico, identificado pelo ID
    public function show($id)
    {
        $tipo = TipoBem::findOrFail($id);
        return response()->json($tipo);
    }

    // Cria um novo tipo de bem após validação dos dados recebidos
    public function store(Request $request)
    {
        // Valida que o campo 'nome' é obrigatório, string, máximo 100 caracteres e único na tabela tipo_bens
        $validated = $request->validate([
            'nome' => 'required|string|max:100|unique:tipo_bens,nome',
        ]);

        // Cria o novo tipo de bem com os dados validados
        $tipo = TipoBem::create($validated);

        // Retorna o novo tipo criado em JSON com status 201 (created)
        return response()->json($tipo, 201);
    }

    // Atualiza um tipo de bem existente identificado pelo ID
    public function update(Request $request, $id)
    {
        // Busca o tipo de bem, falha se não existir
        $tipo = TipoBem::findOrFail($id);

        // Validação dos dados para atualização
        // Garante que o nome é obrigatório, string, máximo 100 caracteres e único exceto para o próprio ID
        $validated = $request->validate([
            'nome' => 'required|string|max:100|unique:tipo_bens,nome,' . $id,
        ]);

        // Atualiza o tipo de bem com os dados validados
        $tipo->update($validated);

        // Retorna o tipo atualizado em JSON
        return response()->json($tipo);
    }

    // Apaga um tipo de bem da base de dados pelo seu ID
    public function destroy($id)
    {
        // Busca o tipo de bem, falha se não existir
        $tipo = TipoBem::findOrFail($id);

        // Elimina o tipo de bem
        $tipo->delete();

        // Retorna resposta vazia com status 204 (no content) para indicar sucesso na eliminação
        return response()->json(null, 204);
    }
}
