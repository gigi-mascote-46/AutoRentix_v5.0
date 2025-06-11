# Sessão
A cada submissão de um form via `POST`, os valores preenchidos no form anterior não são mantidos na nova requisição, pois o ciclo **HTTP é stateless** (uma requisição, uma resposta). Ou seja, os dados enviados não permanecem disponíveis entre diferentes requisições. 

Para manter dados entre requisições, podemos usar a `Session`. 
A **sessão** permite armazenar dados temporários no servidor, enquanto o utilizador navega entre diferentes páginas ou ações.

## Como o Laravel identifica uma sessão?
1. Session ID: o Laravel gera um ID de sessão aleatório e o armazena em um cookie chamado `laravel_session`.
Este ID é enviado pelo navegador a cada nova requisição.

2. Cookie do navegador: a sessão depende do cookie. 
**Segurança**: se o utilizador copiar o cookie e usá-lo em outro navegador, a sessão será válida (por isso é importante usar HTTPS e configurações de segurança). Em desenvolvimento, lidamos com o protocolo HTTP (nossa abordagem no momento); mas para converter uma aplicação para produção, há a migração para HTTPS.

3. Driver de sessão:  por defeito, s dados da sessão serão armazenados em arquivos dentro do diretório `storage/framework/sessions` e o seu ciclo de vida depende das configurações estabelecidas em `config/sessions`. 
Todos os drivers identificam a sessão via session ID.

⚠️ **Segurança**
- Tempo de Expiração: podemos configurar o tempo de expiração da sessão em `config/sessions` baseado no tempo de inatividade
```php
'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false),
config('session.lifetime')
```

- Autenticação do User: se o utilizador estiver logado (Auth::check()), a sessão pode ser diferenciada pela conta de login.

- Fingerprint do Navegador: podemos combinar IP, `user-agent` (uma sting enviada pelo navegador a cada requisição, que contém informações sobre o navegador, o sistema operacioanl, tipo de dispositivo, motor de renderização, etc.) e outros atributos para reforçar a segurança (como aceitação de headers específicos e o uso de ferramentas do JavaScript para detectar características únicas do ambiente do utilizador). 
Para se ter acesso ao `user-agent`, basta 
```php
$userAgent = request()->header('User-Agent');
```
E para ter acesso ao IP, basta: 
```php
$ip = request()->ip();
```

E, assim, podemos comparar:
```php
if (Session::get('user_ip') !== request()->ip() || Session::get('user_agent') !== request()->header('User-Agent')) {
// lógica para impedir acesso, ex.: return, redirect, etc.
}
```

Portanto, podemos criar um Middleware personalizado como em: 
[🔗 Abrir Exemplo](file:///C:/Users/CESAE/Desktop/Session/VerificacSessionDigitalMiddleware.php)

## Exemplo
Considere o cenário: desejammos armazenar temporariamente o `ID` de um objeto (ex: um bem locável) e outras informações relacionadas a um outro objeto (ex: uma reserva), sem expor esses dados na URL, nem usar formulários ocultos ou banco de dados.

Para isto, podemos usar a `Session` 
Com esta abordagem, vamos: evitar expor o ID na barra do url (evitando manipulação direta) e garantir a persistência temporária da informação.

🔍 No método que guarda valores na session:
```php
public function guardar_valores_session(Request $request, $id)
{
    if (!$id) {
        abort(404, 'Bem não encontrado.');
    } else {
        
        //guarda o id recebido no parâmetro na session bem_id
        session(['bem_id' => $id]);


        $dataInicio = $request->input('data_inicio');
        $dataFim = $request->input('data_fim');
        $hospedes = (int) $request->input('hospedes');
        
        //guarda informacoes recebidas dos inputs na session possivel_reserva
        session(['possivel_reserva' => [
            'data_inicio' => $dataInicio,
            'data_fim' => $dataFim,
            'numero_hospedes' => $hospedes,
        ]]);

        return view('teste');
    }
}
```
Esses dados guardados na `session` ficam disponíveis entre páginas, sem precisar passar por POST nem GET.


🔍 No método que retoma os valores guardados no método anterior:
```php
public function pegar_valores_na_session()
{
    $user = Auth::user();
    $possivel_reserva = session('possivel_reserva');
    $bem_id = session('bem_id');

    //Na verificação, vemos se a variável não encerrou o seu ciclo de vida
    if (!$bem_id) {
        return redirect()->route('home')->with('error', 'Bem não encontrado.');
    }
    //mais lógica
}
```

## Observação: O ciclo de vida da sessão

Quando não alteramos a configuração disposta em `config/sessions` e não adicionamos as variáveis de ambiente correspondentes, a sessão expira em 120 minutos (2 horas) de inatividade - independente se o utilizador fechar a aba/navegador (pois, há a configuração, por defeito: `'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false),`; se estivesse `true`, os dados guardados na sessão seriam descartados). 


Quando a configuração padrão do Laravel em `config/sessions` não é alterada e as variáveis de ambiente correspondentes não são definidas, a sessão expira após **120 minutos** de inatividade. Esse tempo independe do fato de o utilizador fechar a aba ou o navegador, pois a configuração padrão:
```php 
'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false)
```
impede que os dados sejam descartados automaticamente ao encerrar o navegador. Se essa opção estivesse configurada como `true`, os dados da sessão seriam removidos assim que a aba ou o navegador fossem fechados.

Ou seja, para "limpar" uma `Session`, podemos alterar as configurações em `config/sessions`.

Além disso, é possível realizar essa ação **manualmente** utilizando os seguintes métodos:
```php
session()->forget('user'); #apaga uma variável específica que foi armazenada na sessão

Session::flush(); #apaga todas as variáveis armazenadas na sessão
```