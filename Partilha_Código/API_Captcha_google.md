# 📌 Integrar API Google reCAPTCHA
O reCAPTCHA da Google é uma ferramenta muito útil para proteger aplicações contra bots e acessos automatizados. Vamos ao processo de integração no projeto Laravel:

## 🚀 Passos iniciais
1️⃣ Aceder à página do reCAPTCHA  
Na página, encontramos a documentação fundamental sobre o funcionamento da API.
[Google reCAPTCHA](https://developers.google.com/recaptcha/intro?hl=pt-br)

2️⃣ Registar a aplicação  
Carrega no botão `Primeiros Passos` para iniciar o processo de configuração. Será preciso fazer login.

3️⃣ Preencher o formulário
No registo, é preciso de preencher:
- **Nome da etiqueta** – ajuda na organização das APIs no ambiente de desenvolvimento Google.
- **Tipo de CAPTCHA**:  
  - (✔) Desafio  
  - (✔) Caixa de seleção   –> aka "Não sou um robô".
- **Domínio** – indica os domínios que podem usar este reCAPTCHA, como `localhost`.
- **Nome do projeto** – especifica o nome do projeto.

4️⃣ Submeter o formulário e obter as chaves  
Após preencher, carrega em `Enviar` para receber as duas chaves:
- **Chave do site** (`site key`) – utilizada no frontend, geralmente embutida no HTML.
- **Chave secreta** (`secret key`) – usada para validação no backend.
É preciso copiar ambas as chaves para colar no projeto. 


## Passos no Projeto
💡 Medidas de Segurança 
Declarar as chaves no arquivo `.env` (configuração do ambiente).
```
GOOGLE_RECAPTCHA_SITE_KEY=chave_site
GOOGLE_RECAPTCHA_SECRET_KEY=chave_secreta
```
Após isto, adicionamos uma camada extra de segurança no `config/services.php`
```php
'google' => [
        'recaptcha_secret_key' => env('GOOGLE_RECAPTCHA_SECRET_KEY'),
        'recaptcha_site_key' => env('GOOGLE_RECAPTCHA_SITE_KEY'),
    ], 
```
Agora, sempre que for preciso, chamaremos: `config('services.google.recaptcha_site_key')` e `config('services.google.recaptcha_secret_key')`. Evitando (1) o hard code das chaves e (2) chamar diretamente o .env (como `env('GOOGLE_RECAPTCHA_SECRET_KEY')`), o que pode causar problemas em ambientes com config:cache ativo (`php artisan config:clear` e `php artisan config:cache`).

🔗 O reCAPTCHA funciona em **duas partes**:
🎨 No lado do cliente (frontend): a `site key` é utilizada para exibir o widget do reCAPTCHA, como a checkbox "Não sou um robô". Quando o utilizador interage, uma resposta (`g-recaptcha-response`) é gerada e enviada com o formulário.
🛠 No lado do servidor (backend - Laravel): a `secret key` é usada para verificar com a API da Google se a resposta do utilizador é válida.

### 🔄 Fluxo:
1️⃣ O utilizador interage com o `widget` (checkbox ou invisível).
Geralmente, este widget aparece no fim de um form (antes do botão de submissão): 
```php
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

### No interior do form:
 <div class="flex flex-col items-center justify-center mt-4">
    <div class="g-recaptcha" data-sitekey="{{ config('services.google.recaptcha_site_key') }}"></div>
      @error('captcha')
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-2 text-sm flex items-center"
              role="alert">
              <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M10 15a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm0-11a1.5 1.5 0 00-1.5 1.5v5a1.5 1.5 0 003 0v-5A1.5 1.5 0 0010 4z" />
              </svg>
              <span>{{ $message }}</span>
        </div>
      @enderror
  </div>
```
As linhas 52 e 56 são aquelas indispensáveis para a integração!


2️⃣ O formulário HTML envia o valor do `g-recaptcha-response` para o backend.  

3️⃣ O backend captura esse valor e prepara uma requisição para a API do Google, que é feita via POST. Ou seja, o backend processa o valor recebido.  

4️⃣ O backend envia uma requisição POST para o endpoint oficial: <https://www.google.com/recaptcha/api/siteverify>, com os parâmetros:
`secret` → a chave secreta (NUNCA vai no frontend)
`response` → o valor de `g-recaptcha-response` recebido do frontend
`remoteip` → IP do utilizador (opcional, mas recomendado para segurança adicional)

5️⃣ A Google processa os dados e responde com um JSON como:
```json
{
  "success": true,
  "challenge_ts": "2025-04-23T12:34:56Z",
  "hostname": "seusite.com"
}
```
Ou, se der erro, apresenta as razões, como: `missing-input-secret`, `invalid-input-secret`, `missing-input-response`, `invalid-input-response`:
```json
{
  "success": false,
  "error-codes": [
    "invalid-input-response"
  ]
}
```

6️⃣ O backend interpreta a resposta da Google para saber se o utilizador passou na verificação.

7️⃣ Se passou na verificação, o fluxo continua (de acordo com o que está no código do projeto...).
Se falhou, o backend retorna uma mensagem de erro ou bloqueia a ação.

### 🔐 Exemplo em Laravel (lado do servidor):
```php
use Illuminate\Support\Facades\Http;

public function store(Request $request): RedirectResponse
{
    //Ponto 4 do fluxo 🔝: validação dos dados do reCAPTCHA
    $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        'secret' => config('services.google.recaptcha_secret_key'), // chave secreta
        'response' => $request->input('g-recaptcha-response'), // valor enviado pelo frontend
        'remoteip' => $request->ip(), // opcional, mas recomendado
    ]);

    //Ponto 6 do fluxo: recebe e interpreta a resposta da API do Google
    $result = $response->json();

    if (!($result['success'] ?? false)) {
        //neste ponto, podemos "logar" para um debug mais detalhado. 
        //Poderíamos implementar: logger()->error('reCAPTCHA falhou', $result);
        //Ou uma versão mais "completa" com IP, e-mail e timestamp para análise posterior ou para bloquear IPs abusivos.
            logger()->warning('Falha no CAPTCHA', [
                'ip' => $request->ip(),
                'email' => $request->input('email'),
                'response' => $request->input('g-recaptcha-response'),
                'google' => $responseBody,
            ]);
        return back()->withErrors(['captcha' => 'Falha na verificação do reCAPTCHA.']);
    }
    // Se passou, continua...
}
```

## OBS.: Opção implementação do Middleware Pattern 
O Middleware Pattern (ou padrão de interceptador) permite adicionar lógica antes ou depois da execução de uma requisição — como autenticação, logging, compressão, CORS, ou, no nosso caso, limitação de requisições (`rate limiting`).
```php
Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('throttle:5,1'); // Máximo de 5 requisições por minuto: ou seja, até 5 tentativas por minuto
```