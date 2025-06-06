<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Trata uma requisição recebida.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica se o utilizador está autenticado
        if (!Auth::check()) {
            // Se não estiver autenticado, redireciona para a página de login
            // Alternativamente, poderia abortar a requisição com erro 401 Unauthorized
            return redirect('/login');
            // Exemplo alternativo: abort(401);
        }

        // Se estiver autenticado, deixa continuar o processamento da requisição
        return $next($request);
    }
}
