<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Método para listar todos os utilizadores registados
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    // Método para mostrar um utilizador específico pelo ID
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    // Método para criar um novo utilizador
    public function store(Request $request)
    {
        // Validação dos dados recebidos no pedido
        // name e email são obrigatórios, o email deve ser único e válido
        // password obrigatório com no mínimo 8 caracteres
        // is_admin é booleano opcional, role é string opcional
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'is_admin' => 'boolean',
            'role' => 'string|max:255',
        ]);

        // Encriptação da password para garantir segurança
        $validated['password'] = Hash::make($validated['password']);

        // Criação do utilizador com os dados validados e password encriptada
        $user = User::create($validated);

        // Retorna o utilizador criado com código HTTP 201 (Created)
        return response()->json($user, 201);
    }

    // Método para atualizar um utilizador existente pelo ID
    public function update(Request $request, $id)
    {
        // Procura o utilizador, falha se não existir
        $user = User::findOrFail($id);

        // Validação dos dados para atualização
        // Os campos são opcionais (sometimes), mas se forem enviados devem cumprir as regras
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|required|string|min:8',
            'is_admin' => 'boolean',
            'role' => 'string|max:255',
        ]);

        // Se for enviada a password, encripta-a antes de guardar
        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        // Atualiza o utilizador com os dados validados
        $user->update($validated);

        // Retorna o utilizador atualizado em JSON
        return response()->json($user);
    }

    // Método para apagar um utilizador pelo ID
    public function destroy($id)
    {
        // Procura o utilizador, falha se não existir
        $user = User::findOrFail($id);

        // Elimina o utilizador da base de dados
        $user->delete();

        // Retorna resposta vazia com código HTTP 204 (No Content) para indicar sucesso
        return response()->json(null, 204);
    }
}
