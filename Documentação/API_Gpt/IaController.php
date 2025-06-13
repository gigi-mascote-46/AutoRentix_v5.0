<?php

namespace App\Http\Controllers;

use App\Models\ChatIa;
use App\Service\IaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class IaController extends Controller
{
    //Carregar a página e a interface gráfica 
    public function index()
    {
        return view('ia');
    }

    //Processar a requisição por meio da chamada do serviço IaService 
    public function sendMessage(Request $request)
    {
        $mensagem = $request->input('mensagem');
        $resposta = null;
        $error = null;

        try {
            $iaService = new IaService();
            $resposta = $iaService->sendMessage($mensagem);

        } catch (\Exception $e) {
            Log::error('Erro no controlador ao enviar mensagem para IA: ' . $e->getMessage());
            $error = 'Erro ao se comunicar com a IA.';
        }

        return view('ia', [
            'mensagem' => $mensagem,
            'resposta' => $resposta,
            'error' => $error
        ]);
    }
}
