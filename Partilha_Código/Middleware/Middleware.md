# Middleware
Filtro executado antes ou depois de uma requisição. Ou seja: 
(1) Antes de chegar ao Controlador
(2) Antes da resposta chegar ao Cliente

O Laravel já possui alguns middlewares padrão, como:
- `auth`: verifica se o user está autenticado.
- `verified`: confirma se o e-mail do user foi verificado.
- `throttle`: ratelimit; limita o número de requisições permitidas em determinado intervalo de tempo.
- `guest`: impede que user autenticado acesse a página.

Exemplos:
```php
    Route::get('/', function () {
        return view('dashboard');
    })->name('dash')->middleware(['auth', 'verified', 'throttle:6,1']);
// No exemplo acima, chamamos 3 middlewares (array).
// Os middlewares são executados antes da requisição (se o user está autenticado e email foi verificado, e permite 6 requisições em 1 minuto).
//Ou seja, se a taxa de requisições for excedida, a requisição é bloqueada antes de chegar ao controlador.

    Route::get('/teste', function () {
        return view('dashboard');
    })->name('dash')->middleware('guest');
// No exemplo acima, chamamos 1 middleware, executado antes da requisição.
```

# Middleware Personalizado
Para criar um middleware personalizado 
```bash
php artisan make:middleware NomeMiddleware
```

Este comando cria um arquivo dentro de `app/Http/Middleware`, uma classe que possui o método `handle`, no qual implementamos a lógica do middleware.
Esta função recebe uma instância de Request (conteúdo da requisição) e Closure (a próxima etapa do fluxo da requisição, seja o próximo middleware na fila ou o controlador que processa a requisição).

## Executando Middleware Antes do Controlador
Se quisermos que o middleware seja executado antes da requisição chegar ao controlador, implementamos no método `handle`:
```php

public function handle(Request $request, Closure $closure)
{
    //lógica
    return $next($request);
}
```
[🔗 Abrir Exemplo](file:///C:/Users/CESAE/Desktop/Middleware/RoleAccess.php)


## Executando Middleware depois do Controlador
Se quisermos que o middleware seja executado depois da requisição chegar ao controlador:
```php
public function handle(Request $request, Closure $closure)
{
    $response = $next($request); //guardamos a resposta
    //logica
    return $next($response);
} 
```
[🔗 Abrir Exemplo](file:///C:/Users/CESAE/Desktop/Middleware/JanelaTempo.php)


## Retornos

1. Retorna uma página padrão de erro 403.
```php
abort(403, 'Você não tem permissão para acessar esta funcionalidade.');
```
Ideal para aplicações web que utilizam páginas de erro personalizadas ou padrão.


2. Redireciona para a rota de **nome** `welcome` com uma mensagem de erro.
Para exibir essa mensagem, a página `welcome.blade.php` precisa estar configurada para verificar se há um erro armazenado na sessão.
```php
    return redirect()->route('welcome')->with('error', 'Acesso não autorizado: IP não reconhecido.');
```
Ou seja, na view, teríamos algo como: 
```php
  @if (session('error'))
        <div
            class="alert alert-success shadow-lg rounded-lg py-4 px-6 font-semibold text-red-800 bg-red-100 ring-1 ring-red-300">
                            {{ session('error') }}
        </div>
    @endif
```


3. Retorna uma resposta em formato JSON com o código HTTP 403.
```php
    return response()->json(['message' => 'Acesso não autorizado.'], Response::HTTP_FORBIDDEN);
```
Essa abordagem é mais adequada para APIs, mas pode não ser visualmente ideal em aplicações web tradicionais (ecrã todo preto com o json)..


## Chamar o middleware na rota
Consideremos dois middlewares: `RoleAccessMiddleware` e `LimitDateMiddleware`, chamaríamos:
Exemplos:
```php
    Route::get('/teste2', [BensLocaveisController::class, 'all_avalible'])
        ->name('disponiveis')
        ->middleware([LimitDateMiddleware::class]);

    Route::get('/teste', function () {
        return view('dashboard');
        })->middleware(['auth', RoleAccessMiddleware::class])->name('adashboard');
```

## Laravel 12 (sem Kernel)
Podemos registar as verificações de middleware para todas rotas ou um grupo de rotas em `bootstrap/app.php`.
Exemplo:
```php
->withMiddleware(function (Middleware $middleware)
    {
        //método prepend para antes de todas as respostas
        $middleware->prepend([RoleAccessMiddleware::class]);

        //método apend para depois de todas as respostas
        $middleware->apend([LimitDateMiddleware::class]);

        //ver é o nome do grupo de rotas que será afetado pelo middleware
        $middleware->prependToGroup('ver', [TesteMiddleware::class]);

    })
```

No entanto, pode haver casos em que uma rota específica (dentro do grupo ou no geral) **não** deve ser afetada pelo middleware. Para isso, usamos `withoutMiddleware()`.

```php
Route::middleware('ver')->group(function () {
    Route::get('/relatorio', [RelatorioController::class, 'index'])->name('relatorio.index');
    Route::get('/detalhes/{id}', [RelatorioController::class, 'show'])->name('relatorio.show');

    Route::delete('/lixeira', [RelatorioController::class, 'destroy'])
        ->name('relatorio.destroy')
        ->withoutMiddleware([TesteMiddleware::class]);
});
```

## Utilidades
🚀 O uso de middleware permite o controlo de acesso, restrições personalizadas, filtragem de requisições e a implementação de regras específicas para diferentes fluxos, seja antes de chegar ao controlador ou antes da resposta ser enviada ao cliente.
Portanto, é uma ferramenta importante para:
- Organização e eficiência 
– Centralização de verificações e melhoria da estrutura do código. 
- Segurança reforçada 
– Proteção da aplicação contra acessos não autorizados e ataques. 
- Definição de filtros e regras que atendem às necessidades específicas da aplicação.
- Melhoria na experiência do utilizador quanto ao fluxo de navegação seguro e fluido.