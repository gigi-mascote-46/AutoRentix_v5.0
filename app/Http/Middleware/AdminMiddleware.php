<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Facade para registro de logs

class AdminMiddleware
{
    /**
     * Middleware para verificar se o usuário autenticado é administrador
     *
     * @param Request $request Objeto da requisição HTTP
     * @param Closure $next Função para passar a requisição adiante
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificação em duas etapas:
        // 1. Se o usuário NÃO está autenticado (!Auth::check())
        // 2. OU se o usuário autenticado NÃO tem a role 'admin'
        if (!\Illuminate\Support\Facades\Auth::check() || \Illuminate\Support\Facades\Auth::user()->role !== 'admin') {

            // Registra um log informativo sobre acesso negado
            Log::info('AdminMiddleware: Access denied for user', [
                'user' => \Illuminate\Support\Facades\Auth::user(), // Usuário atual (pode ser null)
                'role' => \Illuminate\Support\Facades\Auth::user()
                    ? \Illuminate\Support\Facades\Auth::user()->role // Role se existir usuário
                    : null, // Null se não estiver autenticado
                'url' => $request->fullUrl(),    // URL completa acessada
                'method' => $request->method(),  // Método HTTP (GET, POST, etc.)
            ]);

            // Retorna erro HTTP 403 (Forbidden) com mensagem
            abort(403, 'Acesso negado');
        }

        // Registra log de acesso permitido (apenas para administradores)
        Log::info('AdminMiddleware: Access granted for user', [
            'user' => \Illuminate\Support\Facades\Auth::user(),  // Usuário admin
            'role' => \Illuminate\Support\Facades\Auth::user()->role, // Role admin
            'url' => $request->fullUrl(),    // URL acessada
            'method' => $request->method(),  // Método HTTP
        ]);

        // Passa a requisição para o próximo middleware/controlador
        return $next($request);
    }
}
