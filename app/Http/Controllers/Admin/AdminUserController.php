<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    /**
     * Exibe a lista de todos os usuários
     *
     * Método: GET
     * Rota: /admin/users (normalmente)
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        // Obtém todos os usuários do banco de dados
        $users = User::all();

        // Renderiza o componente Vue 'AreaAdmin/Admin/Users/Index' passando os usuários como prop
        return Inertia::render('AreaAdmin/Admin/Users/Index', compact('users'));
    }

    /**
     * Mostra o formulário de edição de um usuário específico
     *
     * Método: GET
     * Rota: /admin/users/{id}/edit
     *
     * @param int $id ID do usuário
     * @return \Inertia\Response
     */
    public function edit($id)
    {
        // Busca o usuário pelo ID ou retorna erro 404 se não existir
        $user = User::findOrFail($id);

        // Renderiza o componente de edição passando o usuário
        return Inertia::render('Admin/Users/Edit', compact('user'));
    }

    /**
     * Atualiza um usuário no banco de dados
     *
     * Método: PUT/PATCH
     * Rota: /admin/users/{id}
     *
     * @param Request $request Dados da requisição
     * @param int $id ID do usuário
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Busca o usuário a ser atualizado
        $user = User::findOrFail($id);

        // Valida os dados recebidos do formulário
        $validated = $request->validate([
            'name' => 'required|string|max:255',         // Nome obrigatório
            'email' => "required|email|unique:users,email,$id",  // Email único, ignorando o próprio usuário
            'role' => 'required|string|in:user,admin',    // Permite apenas roles 'user' ou 'admin'
        ]);

        // Atualiza o usuário com os dados validados
        $user->update($validated);

        // Redireciona para a lista de usuários com mensagem de sucesso
        return redirect()->route('admin.users.index')->with('success', 'Utilizador atualizado com sucesso!');
    }

    /**
     * Exclui um usuário do sistema
     *
     * Método: DELETE
     * Rota: /admin/users/{id}
     *
     * @param int $id ID do usuário
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Busca o usuário a ser excluído
        $user = User::findOrFail($id);

        // Executa a exclusão no banco de dados
        $user->delete();

        // Redireciona de volta à página anterior com mensagem de sucesso
        return back()->with('success', 'Utilizador removido com sucesso!');
    }
}
