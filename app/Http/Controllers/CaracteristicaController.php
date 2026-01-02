<?php

namespace App\Http\Controllers;

use App\Models\Caracteristica;
use Illuminate\Http\Request;

// Este controller é responsável por gerir as operações CRUD da entidade "Caracteristica"
class CaracteristicaController extends Controller
{
    // Lista todas as características existentes na base de dados
    public function index()
    {
        $caracteristicas = Caracteristica::all(); // Busca todas as características
        return response()->json($caracteristicas); // Retorna em formato JSON
    }

    // Mostra uma única característica com base no ID fornecido
    public function show($id)
    {
        $caracteristica = Caracteristica::findOrFail($id); // Encontra ou dá erro 404
        return response()->json($caracteristica); // Retorna os dados da característica
    }

    // Cria uma nova característica com validação
    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $validated = $request->validate([
            'nome' => 'required|string|max:100|unique:caracteristicas,nome',
            // O nome é obrigatório, texto, máximo 100 caracteres e tem de ser único na tabela
        ]);

        // Cria a nova característica com os dados validados
        $caracteristica = Caracteristica::create($validated);

        // Retorna a nova característica com o código 201 (Created)
        return response()->json($caracteristica, 201);
    }

    // Atualiza uma característica existente
    public function update(Request $request, $id)
    {
        // Primeiro encontra a característica pelo ID
        $caracteristica = Caracteristica::findOrFail($id);

        // Valida os dados, garantindo que o nome continua único (mas ignora o próprio registo)
        $validated = $request->validate([
            'nome' => 'required|string|max:100|unique:caracteristicas,nome,' . $id,
        ]);

        // Atualiza o registo com os novos dados
        $caracteristica->update($validated);

        // Retorna a característica atualizada
        return response()->json($caracteristica);
    }

    // Elimina uma característica pelo ID
    public function destroy($id)
    {
        $caracteristica = Caracteristica::findOrFail($id); // Procura a característica
        $caracteristica->delete(); // Elimina o registo

        // Retorna uma resposta vazia com código 204 (No Content)
        return response()->json(null, 204);
    }
}
