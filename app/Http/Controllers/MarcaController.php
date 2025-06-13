<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

// Controller responsável pela gestão das marcas dos bens locáveis
class MarcaController extends Controller
{
    // Método para listar todas as marcas registadas
    public function index()
    {
        $marcas = Marca::all(); // Obtém todas as marcas da base de dados
        return response()->json($marcas); // Retorna as marcas em formato JSON
    }

    // Método para obter uma marca específica através do seu ID
    public function show($id)
    {
        $marca = Marca::findOrFail($id); // Procura a marca, ou devolve erro 404 se não existir
        return response()->json($marca); // Retorna os dados da marca
    }

    // Método para criar uma nova marca
    public function store(Request $request)
    {
        // Validação dos dados recebidos no pedido
        $validated = $request->validate([
            'tipo_bem_id' => 'required|integer|exists:tipo_bens,id', // Verifica que o tipo_bem_id existe na tabela tipo_bens
            'nome' => 'required|string|max:100',                     // Nome obrigatório com máximo de 100 caracteres
            'observacao' => 'nullable|string',                        // Observação opcional
        ]);

        // Cria uma nova marca com os dados validados
        $marca = Marca::create($validated);
        return response()->json($marca, 201); // Retorna a nova marca com status 201 (Criado)
    }

    // Método para atualizar os dados de uma marca existente
    public function update(Request $request, $id)
    {
        $marca = Marca::findOrFail($id); // Procura a marca pelo ID

        // Validação dos dados para atualização
        $validated = $request->validate([
            'tipo_bem_id' => 'sometimes|required|integer|exists:tipo_bens,id', // Se fornecido, valida o tipo_bem_id
            'nome' => 'sometimes|required|string|max:100',                     // Se fornecido, valida o nome
            'observacao' => 'nullable|string',                                 // Observação opcional
        ]);

        // Atualiza a marca com os dados validados
        $marca->update($validated);
        return response()->json($marca); // Retorna a marca atualizada
    }

    // Método para eliminar uma marca pelo seu ID
    public function destroy($id)
    {
        $marca = Marca::findOrFail($id); // Procura a marca
        $marca->delete();                 // Apaga a marca da base de dados
        return response()->json(null, 204); // Resposta sem conteúdo indicando sucesso
    }
}
