<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Inertia\Inertia;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return Inertia::render('Admin/Users/Index', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return Inertia::render('Admin/Users/Edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,$id",
            'is_admin' => 'boolean',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'Utilizador atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'Utilizador removido com sucesso!');
    }
}
