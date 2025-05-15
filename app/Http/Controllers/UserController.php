<?php

namespace App\Http\Controllers;

use App\Models\BemLocavel;
use App\Models\Caracteristica;
use App\Models\Localizacao;
use App\Models\Marca;
use App\Models\Pagamento;
use App\Models\Reserva;
use App\Models\TipoBem;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        return User::all();
    }

    public function show(User $user) {
        return $user;
    }

    public function update(Request $request, User $user) {
        $user->update($request->only(['name', 'email']));
        return $user;
    }

    public function destroy(User $user) {
        $user->delete();
        return response()->noContent();
    }
}
