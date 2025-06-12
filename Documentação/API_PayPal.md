# Integração do PayPal
Este documento descreve a implementação da integração com o sistema de pagamento do PayPal e as suas funções para conectar-se ao PayPal e processar pagamentos.
Conceitos
✅ OAuth2 (credentiais)
✅ Integração segura com .env
✅ Integração com package e Headers HTTP
✅ Requisições autenticadas

## 1. Obter as credenciais no PayPal
Na página, encontramos a documentação fundamental sobre o funcionamento da API.
[PayPal Developer](https://developer.paypal.com/api/rest/sandbox/)

Para obter as credenciais no PayPal, fazemos login (criamos uma conta pessoal) e acedemos ao dashboard por:
[PayPal Developer](https://developer.paypal.com/dashboard/)

1. Carregar na primeira opção ou ir `My Apps & Credentials`

2. Criar um app (sandbox mode pra testes)
O PayPal oferece dois ambientes: o sandbox, ambiente de testes (de desenvolvimento) que permite testar a API sem realizar transações reais, e o live, ambiente real (produção). O ambiente sandbox simula o funcionamento da API do PayPal, permitindo fazer chamadas e experimentar a integração sem envolver dinheiro real.
No entanto, as credenciais para sandbox e live são separadas. Ou seja, ao mudar para produção, será necessário um novo Client ID e Secret.

+ A estrutura das respostas da API do PayPal pode variar dependendo do tipo de requisição feita, mas em geral, ela segue um padrão consistente com alguns elementos comuns. 
# Veja a documentação
[PayPal Developer](https://developer.paypal.com/docs/api/payments/v2/#authorizations_capture)

Por exemplo, a resposta ao criar uma ordem de pagamento (/v2/checkout/orders), como no método createOrder():
```json
{
  "id": "order_id_value", //id da ordem criada
  "intent": "CAPTURE", //intenção da transação (geralmente "CAPTURE").
  "purchase_units": [ //Detalhes da unidade de compra, como o valor e a moeda.
    {
      "reference_id": "unit_reference_id",
      "amount": { //valor da transacao
        "currency_code": "EUR",
        "value": "100.00"
      },
      "payee": {
        "email_address": "merchant@example.com",
        "merchant_id": "merchant_id_value"
      }
    }
  ],
  "status": "CREATED",
  "links": [
    {
      "rel": "approve",
      "href": "approval_url",
      "method": "GET"
    },
    {
      "rel": "self",
      "href": "self_url",
      "method": "GET"
    }
  ]
}
```
+ + Resposta ao capturar um pagamento (/v2/checkout/orders/{order_id}/capture), como no método capturePayment():
```json
{
  "id": "payment_id_value", // id da transação capturada.
  "status": "COMPLETED", // status da transação
  "purchase_units": [ //detalhes do valor da transação.
    {
      "reference_id": "unit_reference_id",
      "amount": {
        "currency_code": "EUR",
        "value": "100.00"
      }
    }
  ],
  "payer": {// informações sobre o pagador, como nome e e-mail.
    "name": {
      "given_name": "John",
      "surname": "Doe"
    },
    "email_address": "payer@example.com",
    "payer_id": "payer_id_value",
    "payment_method": "paypal"
  },
  "create_time": "2021-01-01T00:00:00Z",
  "update_time": "2021-01-01T00:00:00Z"
}
```
+ + Resposta ao cancelar uma ordem ou transação (/v2/checkout/orders/{order_id}/cancel):
```json
{
  "status": "CANCELLED",  
  "id": "order_id_value"// id da transação/ordem 
}
```

3. Copie o Client ID e Secret

## 2. Adicionar as chaves no .env

```php
PAYPAL_MODE=sandbox
PAYPAL_CLIENT_ID=
PAYPAL_CLIENT_SECRET=
```
*OU*
```php
PAYPAL_MODE=sandbox
#Configuração e Credenciais Sandbox
PAYPAL_SANDBOX_CLIENT_ID=
PAYPAL_SANDBOX_CLIENT_SECRET=
```

## 3. Criar a configuração config/paypal.php 
Para assegurar as chaves, criando uma camada de acesso. Podemos adicionar a configuraç4ao diretamente no config/services.php, mas ao criar outro ficheiro organizamos melhor o código.
```php
<?php
return [
    'mode'    => env('PAYPAL_MODE', 'sandbox'),
    'sandbox' => [
       'client_id'     => env('PAYPAL_CLIENT_ID', ''),
        'client_secret' => env('PAYPAL_CLIENT_SECRET', ''),
    ],
    'payment_action' => 'Sale',
    'currency'       => 'EUR',
    'notify_url'     => '',
    'locale'         => 'pt_PT',
    'validate_ssl'   => true,
];
```


## 4. Criar as rotas
Vamos precisar considerar 5 operações: 
1. Criar/apresentar a transação.
2. Processar a transação (criar a ordem de pagamento).
3. Operação cancelada.
4. Operação bem conseguida (pagamento realizado).
5. Operação bem finalizada.

Portanto, podemos criar as rotas separadamente:
```php
Route::get('transaction', [PayPalController::class, 'createTransaction'])->name('createTransaction');
Route::get('process-transaction', [PayPalController::class, 'processTransaction'])->name('processTransaction');
Route::get('success-transaction', [PayPalController::class, 'successTransaction'])->name('successTransaction');
Route::get('cancel-transaction', [PayPalController::class, 'cancelTransaction'])->name('cancelTransaction');
Route::get('finish-transaction', [PayPalController::class, 'finishTransaction'])->name('finishTransaction');
```
**Ou** Agrupadas:
```php 
Route::prefix('transaction')->name('transaction.')->group(function () {
    Route::get('/', [PayPalController::class, 'createTransaction'])->name('create');
    Route::get('/process', [PayPalController::class, 'processTransaction'])->name('process');
    Route::get('/success', [PayPalController::class, 'successTransaction'])->name('success');
    Route::get('/cancel', [PayPalController::class, 'cancelTransaction'])->name('cancel');
    Route::get('/finish', [PayPalController::class, 'finishTransaction'])->name('finish');
});
```

Para realizar essas operações no back-end vamos usar um pacote! 
## Obter o pacote PayPal
No contexto do PHP, um pacote é um conjunto de arquivos que fornecem funcionalidades específicas. 
No pacote `srmklive/paypal` já teremos acesso a métodos de chamada simplificados. Execute os comandos:

```bash
# Para instalar o pacote com o Composer
Package: composer require srmklive/paypal

# publicar o pacote
php artisan vendor:publish --provider="Srmklive\PayPal\Providers\PayPalServiceProvider"

# e, por segurança, limpar o config
php artisan config:clear
```

Documentação em: 
[Simplificada] (https://packagist.org/packages/srmklive/paypal)
[Oficial](https://srmklive.github.io/laravel-paypal/docs.html)

O `srmklive/paypal` é um dos pacotes mais usados para o PayPal, mas existem outros pacotes semelhantes, como `pleets/laravel-paypal` (se tiver interesse, veja no Packagist, https://packagist.org/packages/pleets/laravel-paypal). Além disso, há pacotes para outras formas de pagamento, como `braintree/braintree_php`, que oferece funcionalidades para processar pagamentos com cartão de crédito, entre outros.


## 5. Criar o Controller PayPalController e o Serviço PayPalService
Se o sistema precisar crescer, é melhor criar Serviço + Controlador, pois melhora a separação de responsabilidades, torna o código mais limpo e testável.

### 5.1. Criar o Serviço
No serviço, centralizamos toda a lógica de comunicação com a API do PayPal.
1. Execute o comando existe:
```bash
php artisan make:service PayPalService
```
*Se o comando não existe, é preciso criá-lo!*

2. No serviço criado, vamos separar a lógica de comunicação com a API do PayPal e, para isto, vamos importar a classe `PayPalClient` do pacote `Srmklive\PayPal`. Assim, vamos implementar os membros da classe:

`$provider`:	armazena instância da classe `PayPalClient`, permitindo acesso às funções do PayPal.
`__construct()`:	cria uma instância do `PayPalClient`, define e configura credenciais, e obtém token de acesso.
`createOrder()`: cria uma nova ordem de pagamento no PayPal, especifica o valor e a moeda de transação, e retorna a resposta da API com os detalhes da ordem.
`capturePaymentOrder()`: captura um pagamento previamente autorizado, recebe o token de pagamento e retorna os detalhes da transação.
`payerNameAndAmout()`: extrai e retorna (no array associativo) o nome do pagador e valor pago após transação completa. 
[🔗 Abrir Exemplo](file:///C:/Users/CESAE/Desktop/API_PayPal/PayPalService.php)


### 5.2. Criar o Controllador PayPalController
Neste controlador chamamos os serviços nos membros da classe. Portanto, adicionaremos as dependências para o `PayPalService` e `Request`:
```php
use App\Services\PayPalService;
use Illuminate\Http\Request;
```
E implementamos as classes:
`$payPalService`: armazena a instância do serviço PayPalService, permitindo chamadas à API do PayPal.
`__construct()`:	injeta PayPalService, garantindo que os métodos de pagamento estejam acessíveis.
`createTransaction()`: exibe a tela de transação (checkout).
`processTransaction(Request $request)`:	cria uma ordem de pagamento e redireciona o usuário ao PayPal para aprovação.
`successTransaction(Request $request)`:	captura o pagamento aprovado, obtém nome e valor do pagador e redireciona para a página de finalização.
`cancelTransaction(Request $request)`:	redireciona para a página inicial após cancelamento do pagamento.
`finishTransaction(Request $request)`:	exibe os detalhes do pagamento finalizado.

[🔗 Abrir Exemplo](file:///C:/Users/CESAE/Desktop/API_PayPal/PayPalController.php)


## 6. Criar a view transaction.blade.php
Pela linha de comando, podemos:
```bash
php artisan make:view transaction
```
[🔗 Abrir Exemplo](file:///C:/Users/CESAE/Desktop/API_PayPal/transaction.blade.php)

No HTML, o que é necessário é criar o form action com a rota de processamento e o método Get junto com o botão de submissão: 
```html
   <form action="{{ route('processTransaction') }}" method="GET">
      <button type="submit">Pagar com PayPal</button>
    </form>
```
E podemos criar uma view `finish-transaction.blade.php` para exibir o nome de quem pagou e o valor da transação.
Pela linha de comando, podemos:
```bash
php artisan make:view finish-transaction
```
Com o pacote, podemos poupar JavaScript, mantendo a lógica no back-end.
[🔗 Abrir Exemplo](file:///C:/Users/CESAE/Desktop/API_PayPal/finish-transaction.blade.php)


## Mudanças necessárias entre ambientes de teste e produção
1. No .env, devemos alterar as credenciais. 
2. Na configuração (paypal.php), também é necessário adaptar.
3. O script de produção é:     
```html
 <!-- Se fosse ambiente de producao-->
 <script src="https://www.paypal.com/sdk/js?client-id={{config('paypal.client_id')}}&currency=EUR&intent=capture"></script>
```
E o de sandbox:
```html
 <!-- SDK do PayPal com sua Client ID e moeda EUR -->
    <script src="https://www.sandbox.paypal.com/sdk/js?client-id={{config('paypal.client_id')}}&currency=EUR&intent=capture"></script>
```
## Erros de CSP e autofocus
Estes são erros que aparecem no console, mas que geralmente não afetam a funcionalidade. São limitações do iframe do simulador 3DS do PayPal.


## Para verificar o funcionamento, usamos o Dev. Ops. e o Postman (ou outra ferramento para enviar requisições para a API no ambiente sandbox).
💡 Para testar pagamentos fictícios, podemos usar cartões de teste fornecidos pelo PayPal.
https://developer.paypal.com/tools/sandbox/card-testing/?form=MG0AV3
Em < Generate Credit Card, encontraremos 
Visa
USA
Card numer 4032038429948700 
Expiry date 01/2028
CVC code 435
Para testar com o cartão falso, carregamos na opção pagar com cartão, e prosseguir; adicionamos qualquer valor na dupla autenticação.

##
[Multibanco](https://developer.paypal.com/docs/checkout/apm/multibanco/orders-api/)
