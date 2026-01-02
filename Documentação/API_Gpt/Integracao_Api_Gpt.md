# Integração com API da OPEN IA
Vamos perceber como integrar o Chat GPT na sua aplicação Laravel. 
Antes de mais, é importante termos em atenção que *mesmo da versão gratuita* há um custo associado, com um valor mínimo de, aproximadamente, 6,20 dólares.

O modelo de chat da OpenAI funciona como uma conversa entre papéis (system, user, assistant). 
O fluxo das mensagens funciona entre estes papéis: o system define o comportamento do modelo (isto é, um contexto, uma personalidade e restrições para o assistente; dando o tom das interações), o user a mensagem enviada pelo utilizador e assistant é a resposta da IA.

O retorno da API segue o seguinte formato JSON:
```json
{
    "choices": [
        {
            "message": {
                "role": "assistant",
                "content": "Aqui está a resposta gerada pelo modelo."
            }
        }
    ]
}
```
Isto é, a resposta obtida contém um array chamado `choices`.


## 1. Obter a chave da API da OpenAI
Para obter a chave de API da OpenAI, acesse: https://platform.openai.com/account/api-keys. 
Após o login, será exibida a aba `API keys`, na qual é necessário selecionar a opção `Create new secret key`. 
No modal que aparecerá, crie a sua chave e copie-a. Por norma, **esta será a única vez que a chave ficará visível**. 

Para ativá-la, é necessário configurar um pagamento. Para ativar o sistema de faturação (`billing`), acesse: https://platform.openai.com/account/billing/overview e adicione um cartão de crédito, sendo o pagamento mínimo de 5 dólares, mais taxas (totalizando aproximadamente 6,20 dólares). 
**Dica**: gere um cartão digital temporário (por exemplo, pelo MB WAY) para realizar a compra única, com um limite baixo de 7 a 10 euros. 
Após adicionar o crédito, a chave será validada e será possível realizar requisições e obter respostas, monitorando o consumo em: https://platform.openai.com/usage. Além disso, é aconselhável editar limites e configurar alertas de uso em https://platform.openai.com/settings/organization/limits.


## 2. Adicionar a sua chave no `.env` do Laravel e no `config.services`
Para adicionar a chave de API no Laravel, é necessário configurá-la como variável de ambiente no arquivo `.env` e no arquivo `config/services.php`. 

No `.env`, teremos a adição de: 
```php
AI_API_KEY=VALOR_SUA_CHAVE
```

Já, no `config.services`:
```php
  'openai'=>  [
        'api_key' => env('IA_API_KEY'), # É fundamental que o nome da variável de ambiente seja referenciado corretamente
    ],
```
Seguindo o exemplo acima, teremos o valor da chave acessível por: `config('services.openai.api_key')`.

## 3. Criar uma função para chamar a API
Para chamar a API, pode-se criar uma função dentro de um `Controller` ou de um `Service`. A seguir, temos o exemplo de um serviço:

[🔗 Abrir Exemplo](file:///C:/Users/CESAE/Desktop/ApiGpt/AiService.php)

No exemplo acima, a função `sendMessage()` realiza a requisição por meio deste bloco:
```php
$response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type'  => 'application/json',
        ])->post($this->endpoint, [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'Você é um assistente útil.'],
                ['role' => 'user', 'content' => $userMessage],
            ],
            'temperature' => 0.7,
        ]);
```
**Explicação do bloco acima**
Nessa função, utilizamos o método `Http::withHeaders()` para definir os cabeçalhos da requisição. O `Authorization` contém a chave da API armazenada na configuração `config('services.openai.api_key')`, e o `Content-Type` define que os dados serão enviados no formato JSON.

A requisição é realizada pelo método `post()`, enviando os dados para a API da OpenAI no endpoint (no caso, https://api.openai.com/v1/chat/completions). 
No corpo da requisição, incluímos o parâmetro `model`, que define qual versão do ChatGPT será utilizada (o `gpt-3.5-turbo` na versão gratuita, que possui um custo inferior ao `gpt-4o`). 
Além disso, enviamos um array `messages`, que define o contexto da conversa/interação. O primeiro item (`role: system`) orienta o comportamento modelo. No caso, dizemos para atuar como um assistente útil; poderia ser outra mensagem, como: 
- "Você é um tradutor que traduz do inglês para o português mantendo o sentido original.", 
- "Você é um assistente especializado em programação que responde com trechos de código.", 
- "Você é um narrador criativo que cria histórias envolventes.", 
- "Você nunca deve responder perguntas impróprias ou ofensivas.", etc.
Podemos enviar a mensagem do papel `system` em qualquer idioma; o modelo entende múltiplos idiomas muito bem.

De volta ao array `messages`: o segundo (`role: user`) contém a mensagem enviada pelo utilizador. 
O parâmetro `temperature` ajusta o nível de criatividade da resposta: valores mais baixos geram respostas previsíveis, enquanto valores mais altos tornam as respostas mais variadas.

A resposta da API é um array de chave `choices`. Por isso, o método `json()` em: `$response->json('choices.0.message.content');` é usado para extrair um valor específico do JSON retornado pela API.


Para organizar a chamada à API, criamos também um `Controller` que se encarrega de chamar o serviço e executar a requisição, como:

[🔗 Abrir Exemplo](file:///C:/Users/CESAE/Desktop/ApiGpt/IaController.php)

No controlador, teremos dois métodos: um para carregar a página e a interface gráfica (chamado de `index()` no exemplo) e outro para processar a requisição por meio da chamada do serviço IaService (chamado de `sendMessage()`). 

No exemplo, instanciamos o serviço e enviamos a mensagem:
```php
    $iaService = new IaServiceService();
    $resposta = $iaService->sendMessage($mensagem);
```
Portanto, a resposta obtida da AI é gravada na variável `$resposta`, sendo que a mensagem enviada pelo utilizador gravada na variável `$mensagem`.

4. Criar rotas
É necessário definir:
1. Uma rota `post`: chama a função do controlador que processa a requisição e obtem a resposta.
2. Uma rota `get`: chama a função do controlador que carrega a página e a interface gráfica.

Exemplo:
```php
Route::post('/ia', [IaController::class, 'sendMessage'])->name('ia.enviar');
Route::get('/ia', [IaController::class, 'index'])->name('ia.index');
```

5. Criar view
No exemplo, o método `index()` retorna a view `ia.blade.php`. Ou seja, é necessário criar esta view, como:
[🔗 Abrir Exemplo](file:///C:/Users/CESAE/Desktop/ApiGpt/ia.blade.php)

Na view, é necessário incluir um formulário com um campo `input` para que o utilizador escreva sua mensagem e a submeta à rota `post`, que chamará a função do controlador, que, por sua vez, chamará o serviço correspondente.

# Level Up: Armazenamento na Base de Dados
Para um nível pouco mais avançado, pode-se armazenar as mensagens trocadas com a IA na base de dados. Veja mais detalhes no projeto disponível no GitHub.