# Enviar email no Laravel

Para enviar e-mails em um projeto Laravel, precisamos do protocolo padrão para envio de e-mails: `SMTP` (Simple Mail Transfer Protocol).

Existem vários provedores `SMTP`, como Mailgun, Mailpit, Postmark, Mailjet, IAgent entre outros.  
Neste guia, vamos utilizar o **Brevo** (antigo Sendinblue), que oferece um *plano gratuito* com até 300 e-mails por dia.

Ao usar serviços como Brevo, Laravel se comunica com o servidor SMTP para autenticar e enviar os e-mails. Laravel usa por padrão o componente `Symfony Mailer` para isso.

## 📧 Criar uma Conta no Brevo

1. Acesse: [https://onboarding.brevo.com/account/register] ou (https://www.brevo.com)
2. Crie sua conta usando o *e-mail* que será usado como **remetente** dos e-mails no Laravel.
3. Escolha o tipo de conta: **Autônoma**.
4. Selecione o plano gratuito, **Free**.
5. Informe o número do telemóvel para autenticar a conta.
5. Confirme seu o e-mail (o Brevo pedirá validação do endereço de e-mail usado no cadastro).

## No Brevo

1. Acesse o painel do Brevo.
2. No canto direiro, vá para **Autônoma > SMTP e API**.
3. Na aba **SMTP**, veremos:
   - O nome do servidor (`smtp-relay.brevo.com`)
   - Porta (geralmente `587` para TLS ou `465` para SSL)
   - Um endereço do tipo `código@smtp-brevo.com`
   - E um botão para **gerar uma senha SMTP** (essa será a senha usada no Laravel)


## No projeto Laravel
### Configurar a conexão em 2 passos
1. Vamos configurar a conexão ao servidor de e-mail no `.env`.

No código abaixo, temos um exemplo do que deve ser feito. Onde há `#`, vamos substituir com os valores correspondentes na nossa conta do Brevo:

```php
MAIL_MAILER=smtp
MAIL_HOST=smtp-relay.brevo.com
MAIL_PORT=587
MAIL_USERNAME= #endereço disposto em conectar, algo como codigo@smtp-brevo.com
MAIL_PASSWORD= #senha que aparece no SMTP
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="" #entre as aspas, adicionamos o email com o qual nos cadastramos no Brevo.
MAIL_FROM_NAME="${APP_NAME}"
```

2. Abrir `config/mail.php` e configurar a entrada `SMTP`. Para isto, compare o seu código com o que está a seguir e faça as devidas alterações:
```php
 'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST', 'smtp-relay.brevo.com'), 
            'port' => env('MAIL_PORT', 587),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'local_domain' => env('MAIL_EHLO_DOMAIN', parse_url(env('APP_URL', 'http://localhost'), PHP_URL_HOST)),
        ],

  ## no fim do arquivo
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', ''),  #no valor padrão (entre as plicas), poderá adicionar o email cadastrado no Brevo.
        'name' => env('MAIL_FROM_NAME', ''), #no valor padrão, podemos adicionar o nome da aplicação.
    ],      
```

### Testar o Envio
Ao utilizar o Laravel Breeze, o sistema de recuperação de senha já vem com envio de e-mail implementado. Podemos testar solicitando a redefinição de senha.

Para ver se os e-mails foram enviados:
No painel do Brevo, vá em `Transacional > Tempo Real`. 
Neste espaço, será possível ver os e-mails enviados com sucesso (ou os erros).


## Observações
1. Geralmente, o email é enviado para a caixa de spam, por se tratar de um email automático. É recomendável avisar o utilizador para verificar o spam, principalmente ao solicitar redefinição de senha.

2. Antivírus ou firewall: alguns antivírus bloqueiam conexões SMTP. Se tiver problemas de conexão, desative temporariamente a proteção de e-mail/web do antivírus.

3. Certificados SSL: Em sistemas Windows, se aparecer erro de certificado (como stream_socket_enable_crypto), tente usar MAIL_ENCRYPTION=ssl e MAIL_PORT=465, ou atualize os certificados CA do PHP.

4. Se ocorrerem problemas com as versões de pacotes, podemos forçar a instalação da versão mais recente compatível com Laravel:
```bash
composer require "symfony/mailer:~7.1.0"
```

## Enviar outros e-mails com classe Mailable
No Laravel, podemos criar e-mails personalizados usando classes herdeiras do tipo `Mailable`, que encapsulam a lógica de construção e envio da mensagem.
[Documentação Laravel Mail](https://laravel.com/docs/11.x/mail)

### Criar uma classe Mailable
Para criar uma classe Mailable, execute:
```bash
php artisan make:mail ReservationConfirmationMail
```
Este comando cria a classe `ReservationConfirmationMail` no diretório `app/Mail/ReservationConfirmationMail.php`. 
A classe gerada possui 4 métodos:
- `_construct()`: método construtor usado para passar dados (para criar novas mensagens).
- `envelop()`: define o assunto do email.
- `content()`: define o conteúdo do email (geralmente, associando uma view).
- `attachments()`: define anexo (opcional).

[🔗 Abrir Exemplo](file:///C:/Users/CESAE/Desktop/Mail/ReservationConfirmationMail.php)


### Criar view 
No caso exemplificado, enviamos uma view no método `content()` e, portanto, devemos criá-la. 
A view deve conter o conteúdo HTML que será exibido na mensagem.

Para organizar o diretório `resources/views`, crie um folder `mail`. Este folder poderá reunir todas as views de e-mails, como a view `reservation-confirmation-mail.blade.php`.

[🔗 Abrir Exemplo](file:///C:/Users/CESAE/Desktop/Mail/reservation-confirmation-mail.blade.php)


#### Enviar o e-mail de modo síncrono: Controlador
Depois de criar o Mailable e a view, vamos testar o envio do e-email com um Controlador (que dispara o envio do e-mail).

Portanto, o Controlador é responsável pelo envio: faz as ações de instanciar a classe `ReservationConfirmationMail` e enviar o e-mail através do método `Mail::to()->send()`.

Vamos analisar o exemplo da classe `ReservationConfirmationMailController`:
[🔗 Abrir Exemplo](file:///C:/Users/CESAE/Desktop/Mail/ReservationConfirmationMailController.php)

Neste controlador, informamos os valores que serão passados como parâmetros para o construtor da classe do tipo `Mailable` (`ReservationConfirmationMail`). Esses parâmetros são extraídos a partir do utilizador autenticado (via `Auth::user()`) e de um campo de input enviado por formulário (`pickup`). Com essas informações, a classe `ReservationConfirmationMail` é instanciada e enviada para o e-mail do próprio utilizador.

*Nota importante*: o envio será executado de forma síncrona pelo Controlador. Para uma implementação de modo assíncrono e mais robusta: criaríamos um evento (`php make artisan:event PaymentConfirm`) e implementamos um método para comunicar que o pagamento foi realizado (na classe teráimos um atributo do tipo pagamento e um construtor, por exemplo); um listener (`php make artisan:listener SendConfirmation`) e implementamos um método que recebe um parâmetro do tipo do evento criado e envia o e-mail; registaríamos este no Provider, e então dispararíamos o e-mail (com um `use App\Events\PaymentConfirm`) em um serviço ou controlador.

### Rota 
Criar uma rota no web.php para tratar o envio:
```php

Route::post('/enviar-email', [ReservationConfirmationMailController::class, 'sendReservationEmail'])
    ->middleware('auth')
    ->name('send.email');
```

### Criar o Formulário em uma view
Demonstrativamente, vamos adicionar um form (post) que estará relacionado com a rota (com o campo de input e um botão de submissão) no `dashboard`:

```php
   <div class="max-w-sm mx-auto p-5">
      @if (session('success'))
         <div
            class="alert alert-success shadow-lg rounded-lg py-4 px-6 font-semibold text-green-800 bg-green-100 ring-1 ring-green-300">
            {{ session('success') }}
         </div>
      @endif

      <form action="{{ route('send.email') }}" method="POST" class="mt-5 flex flex-col items-center space-y-2 p-2 border-2 border-gray-500 rounded-lg shadow-lg bg-gray-100">
      @csrf
         <label for="pickup" class="text-lg font-medium text-gray-700">Local de levantamento da reserva:</label>
         <input type="text" id="pickup" name="pickup" required
            class="w-full max-w-md px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" />
         <button type="submit"
            class="bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-300 text-white font-medium text-base md:text-lg rounded-full px-8 py-3 shadow-md hover:shadow-lg transition duration-300">
            Enviar confirmação por e-mail
         </button>
      </form>
   </div>
```

### Observações: antivírus
Em desenvolvimento local, algumas proteções do antivírus interferem na comunicação entre o servidor local e o serviço de e-mail externo. .No antivírus, é preciso desligar o `safe web`, `email protection` e `auto protection`.  (certificado ssl)
O email protection intercepta conexões SMTP, IMAP e POP para verificar conteúdo malicioso nos e-mails.
Safe Web pode rejeitar o certificado alterado por não estar na lista de autoridades confiáveis.
Auto-Protect bloquea scripts que iniciam conexões de saída via SSL, como o envio de e-mails.