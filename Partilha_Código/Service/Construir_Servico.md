# 📌 Integrar API Google reCAPTCHA : Continuação
Como visto, o reCAPTCHA é uma ferramenta muito útil para proteger aplicações contra bots e acessos automatizados.
Podemos utilizá-lo tanto na página de **Registro** quanto na de **Login**.

No entanto, na implementação atual, repetimríamos o bloco de código que obtém a resposta HTTP. Para evitar essa duplicação e melhorar a organização do código, podemos **refatorar** criando uma camada de serviço.


## 🛠 Criando uma camada de serviço
A camada de serviço centraliza toda a lógica de comunicação com a API do **Google reCAPTCHA**.

1. Verifique se o comando `make:service` existe:
```bash
php artisan make:service RecaptchaService
```
*Se o comando não existe, vamos criá-lo manualmente!*

1.1. Criar um comando artisan personalizado
Execute no terminal:
```bash
php artisan make:command MakeService
```

Isto criará o arquivo: `app/Console/Commands/MakeService.php`. Neste arquivo gerado, vamos implementar código.

1.2. Implementar o código no arquivo gerado
Em `MakeService.php`, criamos um comando personalizado que permite a geração automática de classes `Service` dentro do diretório `app/Services`. Isto é, permite a (1) criação automática do diretório app/Services, caso ele ainda não exista; (2) verificação de duplicação, impedindo a sobrescrita de um serviço já existente; (3) geração dinâmica do arquivo PHP, incluindo a estrutura básica para implementação do serviço; e (4) mensagem informativa instruir o desenvolvedor depois que este utilizar o comando.

[🔗 Abrir Exemplo](file:///C:/Users/Administrator/Desktop/Service/MakeService.php)

1.2.1. Para versões mais antigas do Laravel: Registar o comando no `Kernel.php`
Para essas versões, é necessário registrar o novo comando no Kernel. Para isso, adicione a classe ao array `$commands` em `app/Console/Kernel.php`.
```php
protected $commands = [
    \App\Console\Commands\MakeService::class,
];
```

2. Criar o serviço RecaptchaService
Agora, podemos gerar o serviço usando:
```bash
php artisan make:service RecaptchaService
```
Neste serviço, implementaremos o código repetitivo para validar a requisição reCAPTCHA.

[🔗 Abrir Exemplo](file:///C:/Users/Administrator/Desktop/Service/RecaptchaService.php)


### Chamando o RecaptchaService no Controlador
No controlador RegisteredUserController, importamos o serviço:
```php
use App\Services\RecaptchaService;
```

Agora, podemos chamar o serviço na função `store(Request)` para verificar a requisição, trocando o código previamente implementado por:

```php
$recaptchaService = new RecaptchaService();

$recaptchaResult = $recaptchaService->verifyRequest($request);

if ($recaptchaResult == false) {
    return back()->withErrors(['captcha' => 'Falha na verificação do ReCAPTCHA. Tente novamente.']);
}
```

Além disso, eliminamos  a dependência direta de chamadas `HTTP` no controlador.

Essa abordagem evita código duplicado e melhora a organização da aplicação. 