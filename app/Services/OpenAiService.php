<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenAiService
{
    protected string $apiKey;
    protected string $endpoint = 'https://api.openai.com/v1/chat/completions';

    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key');
    }

    /**
     * Envia uma mensagem para o endpoint de Chat Completion da OpenAI
     * e retorna a resposta do assistente.
     *
     * @param string $userMessage Mensagem do usuário
     * @return string|null Resposta da IA ou null em caso de erro
     */
    public function sendMessage(string $userMessage): ?string
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post($this->endpoint, [
            'model' => 'gpt-3.5-turbo', // pode trocar para outro modelo se quiser
            'messages' => [
                ['role' => 'system', 'content' => 'Você é um assistente útil.'],
                ['role' => 'user', 'content' => $userMessage],
            ],
            'temperature' => 0.7,
        ]);

        if ($response->successful()) {
            return $response->json('choices.0.message.content');
        }

        // Aqui pode-se adicionar log de erro se quiser, ex:
        // \Log::error('OpenAI API error', ['response' => $response->body()]);

        return null;
    }
}
