<?php

namespace App\Http\Controllers;

use App\Models\BemLocavelPhoto;
use Illuminate\Http\Request;

// Este controller gere as fotografias associadas a um bem locável (por exemplo, viaturas ou outros bens)
class BemLocavelPhotoController extends Controller
{
    // Retorna todas as fotografias registadas na base de dados
    public function index()
    {
        $photos = BemLocavelPhoto::all(); // Vai buscar todas as fotos na tabela 'bem_locavel_photos'
        return response()->json($photos); // Retorna os dados em formato JSON
    }

    // Mostra os detalhes de uma fotografia específica, com base no ID
    public function show($id)
    {
        $photo = BemLocavelPhoto::findOrFail($id); // Tenta encontrar a foto, ou devolve erro 404 se não existir
        return response()->json($photo); // Retorna a foto em formato JSON
    }

    // Regista uma nova fotografia na base de dados
    public function store(Request $request)
    {
        // Valida os dados do request (só são aceites se existirem e estiverem corretos)
        $validated = $request->validate([
            'bem_locavel_id' => 'required|integer|exists:bens_locaveis,id', // Foto deve estar associada a um bem válido
            'photo_path' => 'required|string|max:255', // Caminho da imagem, normalmente um URL ou caminho local
        ]);

        // Cria a nova fotografia com os dados validados
        $photo = BemLocavelPhoto::create($validated);

        // Retorna a foto criada com status HTTP 201 (Created)
        return response()->json($photo, 201);
    }

    // Atualiza os dados de uma fotografia existente
    public function update(Request $request, $id)
    {
        // Procura a fotografia pelo ID
        $photo = BemLocavelPhoto::findOrFail($id);

        // Valida os dados apenas se forem enviados no request (validação condicional com 'sometimes')
        $validated = $request->validate([
            'bem_locavel_id' => 'sometimes|required|integer|exists:bens_locaveis,id',
            'photo_path' => 'sometimes|required|string|max:255',
        ]);

        // Atualiza os dados da fotografia
        $photo->update($validated);

        // Retorna os dados atualizados
        return response()->json($photo);
    }

    // Elimina uma fotografia da base de dados
    public function destroy($id)
    {
        $photo = BemLocavelPhoto::findOrFail($id); // Procura a fotografia
        $photo->delete(); // Apaga da base de dados

        // Retorna uma resposta vazia com status 204 (No Content)
        return response()->json(null, 204);
    }
}
