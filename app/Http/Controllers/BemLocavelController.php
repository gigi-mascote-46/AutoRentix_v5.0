<?php

namespace App\Http\Controllers;

use App\Models\BemLocavel;
use Illuminate\Http\Request;

// Este controller gere todas as operações relacionadas com os bens locáveis (ex: viaturas disponíveis para alugar)
class BemLocavelController extends Controller
{
    // Lista todos os bens locáveis existentes na base de dados
    public function index()
    {
        $bens = BemLocavel::all(); // Busca todos os registos da tabela 'bens_locaveis'
        return response()->json($bens); // Devolve os dados em formato JSON
    }

    // Mostra os detalhes de um bem locável específico pelo seu ID
    public function show($id)
    {
        $bem = BemLocavel::findOrFail($id); // Procura o bem pelo ID ou lança erro 404 se não existir
        return response()->json($bem); // Devolve o bem em formato JSON
    }

    // Regista um novo bem locável na base de dados
    public function store(Request $request)
    {
        // Valida os dados recebidos do formulário/request
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

        // Cria um novo registo na base de dados com os dados validados
        $bem = BemLocavel::create($validated);

        // Devolve o novo bem criado com status 201 (Created)
        return response()->json($bem, 201);
    }

    // Atualiza os dados de um bem locável já existente
    public function update(Request $request, $id)
    {
        // Procura o bem pelo ID, ou lança erro 404 caso não exista
        $bem = BemLocavel::findOrFail($id);

        // Valida apenas os campos enviados (validação condicional com `sometimes`)
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

        // Atualiza o registo com os dados validados
        $bem->update($validated);

        // Devolve os dados atualizados em JSON
        return response()->json($bem);
    }

    // Elimina um bem locável da base de dados
    public function destroy($id)
    {
        $bem = BemLocavel::findOrFail($id); // Procura o bem pelo ID
        $bem->delete(); // Elimina o registo da base de dados

        // Retorna resposta vazia com status 204 (No Content)
        return response()->json(null, 204);
    }
}
