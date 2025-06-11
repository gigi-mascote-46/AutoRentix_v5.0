<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class VerificaSessionDigitalMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $userIp = $request->ip();
        $userAgent = $request->header('User-Agent');

        // Verificar IP
        // Se é diferente, invalida a sessão

        if (Session::has('ip') && Session::get('ip') !== $userIp) {
            Session::flush();
            return redirect()->route('login')->with('error', 'Sessão encerrada por segurança.');
        } else {
            Session::put('ip', $userIp);
        }

        // Verificar User-Agent
        // Se é diferente, invalida a sessão

        if (Session::has('agent') && Session::get('agent') !== $userAgent) {
            Session::flush();
            return redirect()->route('login')->with('error', 'Sessão encerrada por mudança de navegador.');
        } else {
            Session::put('agent', $userAgent);
        }

        return $next($request);
    }
}
