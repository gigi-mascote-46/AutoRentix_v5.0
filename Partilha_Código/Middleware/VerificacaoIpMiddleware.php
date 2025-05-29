<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerificacaoInternetProtocolMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $ipAtual = $request->ip();

        if ($user && !$this->verificarIpUnico($user, $ipAtual)) {
            abort(403, 'Acesso não autorizado: IP não reconhecido.');
        }

        return $next($request);
    }

    // Verificação para um único IP por pessoa
    //Considerando: `ip_address` é campo da tabela `users`
    private function verificarIpUnico($user, $ipAtual)
    {
        if ($user->ip_address && $user->ip_address === $ipAtual) {
            return true;
        }

    }

    // Verificação para múltiplos IPs permitidos por pessoa
        // Considerando: 2 tabelas relacionadas por hasMany e belongsTo, em que tenho uma tabela `ips_permitidos` 
        // (com o campo `id_user` e `ip`) e outra tabela `users`. Ambas as tabelas, teriam modelos correspondentes 
        // (User e IpPermitido)
    
        // No modelo/classe `User`, esta relação seria definida como:
    /* public function ipsPermitidos()
        {
            return $this->hasMany(IpPermitido::class, 'id_user');
        } 
    */
        // Ou seja: para uma instância de `User`, podemos acessar a função ipsPermitidos (como: `$user->ipsPermitidos()`)
        // e obter todos os IPs permitidos associados ao usuário.
    private function verificarIpsPermitidos($user, $ipAtual)
    {
        $ipsPermitidos = $user->ipsPermitidos()->pluck('ip')->toArray(); 
        // pluck('ip') recorta apenas os valores da coluna ip dentro da coleção de IPs permitidos
        return in_array($ipAtual, $ipsPermitidos);
    }
}
