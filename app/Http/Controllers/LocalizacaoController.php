<?php

namespace App\Http\Controllers;

use App\Models\Localizacao;
use Illuminate\Http\Request;

// Este controller trata de todas as operações relacionadas com a entidade Localizacao
class LocalizacaoController extends Controller
{
    // Método para listar todas as localizações existentes na base de dados
    public function index()
    {
        $localizacoes = Localizacao::all(); // Obtém todas as localizações
        return response()->json($localizacoes); // Devolve-as em formato JSON
    }

    // Método para mostrar os detalhes de uma única localização, com base no ID
    public function show($id)
    {
        $localizacao = Localizacao::findOrFail($id); // Tenta encontrar a localização, ou dá erro 404
        return response()->json($localizacao); // Devolve os dados em JSON
    }

    // Método para criar uma nova localização
    public function store(Request $request)
    {
        // Validação dos dados recebidos via request
        $validated = $request->validate([
            'registo_unico_publico' => 'required|string|max:20|unique:localizacoes,registo_unico_publico', // deve ser único
            'cidade' => 'required|string|max:100',
            'filial' => 'nullable|string|max:100', // pode ser nulo
            'posicao' => 'required|string|max:100',
        ]);

        // Criação da nova localização com os dados validados
        $localizacao = Localizacao::create($validated);
        return response()->json($localizacao, 201); // Retorna a nova localização e o código 201 (Criado)
    }

    // Método para atualizar uma localização existente
    public function update(Request $request, $id)
    {
        $localizacao = Localizacao::findOrFail($id); // Verifica se a localização existe

        // Validação dos novos dados, permitindo manter o mesmo registo único
        $validated = $request->validate([
            'registo_unico_publico' => 'required|string|max:20|unique:localizacoes,registo_unico_publico,' . $id, // exceção para o próprio ID
            'cidade' => 'required|string|max:100',
            'filial' => 'nullable|string|max:100',
            'posicao' => 'required|string|max:100',
        ]);

        // Atualiza os dados no modelo
        $localizacao->update($validated);
        return response()->json($localizacao); // Devolve os dados atualizados
    }

    // Método para eliminar uma localização com base no ID
    public function destroy($id)
    {
        $localizacao = Localizacao::findOrFail($id); // Verifica se existe
        $localizacao->delete(); // Elimina
        return response()->json(null, 204); // Responde com sucesso sem conteúdo
    }
}
