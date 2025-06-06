<?php

namespace App\Http\Controllers;

// Este é o controller base de onde todos os outros controllers herdam.
// Ele fornece funcionalidades comuns que facilitam a criação de controladores personalizados.

use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Permite verificar permissões/autorização
use Illuminate\Foundation\Bus\DispatchesJobs;              // Permite despachar jobs (tarefas assíncronas)
use Illuminate\Foundation\Validation\ValidatesRequests;    // Permite validar pedidos HTTP facilmente
use Illuminate\Routing\Controller as BaseController;

// A classe principal Controller extende o Controller base do Laravel
class Controller extends BaseController
{
    // Aqui usamos "traits" do Laravel para adicionar funcionalidades úteis:

    use AuthorizesRequests; // Para lidar com autorização de utilizadores (ex: policies)

    use DispatchesJobs;     // Para enviar jobs para a fila (ex: envio de emails ou processamento em background)

    use ValidatesRequests;  // Para validar dados de formulários de forma simples e reutilizável
}
