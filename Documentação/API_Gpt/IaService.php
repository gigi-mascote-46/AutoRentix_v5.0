<?php

namespace App\Service;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IaService
{
    protected string $apiKey;
    protected string $endpoint;

    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key');
        $this->endpoint = 'https://api.openai.com/v1/chat/completions';
    }

    public function sendMessage(string $userMessage): string
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type'  => 'application/json',
        ])->post($this->endpoint, [
            'model' => 'gpt-3.5-turbo', // ou 'gpt-4o' para pago
            'messages' => [
                ['role' => 'system', 'content' => 'Você é um assistente útil.'],
                ['role' => 'user', 'content' => $userMessage],
            ],
            'temperature' => 0.7,
        ]);

        if ($response->failed()) {
            throw new \Exception("Erro na API OpenAI: " . $response->body());
        }

        //Abaixo, extraímos diretamente o conteúdo gerado pelo modelo, retornado pela API.
        //Acessamos a primeira opção de resposta (choices[0]) e retornamos o conteúdo gerado.
        return $response->json('choices.0.message.content'); 

    }
}