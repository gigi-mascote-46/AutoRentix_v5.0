# Sessão
A cada submissão de um form via `POST`, os valores preenchidos no form anterior não são mantidos na nova requisição, pois o ciclo **HTTP é stateless** (uma requisição, uma resposta). Ou seja, os dados enviados não permanecem disponíveis entre diferentes requisições. 

Para manter dados entre requisições, podemos usar a `Session`. 
A **sessão** permite armazenar dados temporários no servidor, enquanto o utilizador navega entre diferentes páginas ou ações.


## Exemplo
Considere o cenário: temos um processo de registo de um novo utilizador baseado em dois forms distintos (duas etapas):
- O primeiro form recolhe as informações que serão gravadas na tabela `users` (campos: `name`, `email`, `password`).
- O segundo form recolhe as informações que serão gravadas na tabela `user_details` (campos: `foto`, `idade`, `telemóvel`).
Cada utilizador (`user`) tem um detalhe (`user_details`).

❗ Problema
Se guardarmos diretamente o registo do utilizador na base de dados após a submissão do primeiro formulário, e o utilizador abandona o processo (ou ocorrer um erro no segundo formulário), ficamos com um registo incompleto na base de dados: um `user` sem `user_detail`. Isso pode comprometer a integridade dos dados e gerar problemas lógicos na aplicação!


✅ Para solucionar este problema, podemos utilizar duas abordagens combinadas:
1. Sessão (`Session`) – para persistir dados temporariamente entre etapas
2. Transação de Base de Dados (`DB::transaction`) – para garantir integridade na gravação final


💻 Vamos a como essas soluções podem ser implementadas:

1. Armazenar os dados do primeiro form na sessão
Na primeira etapa do processo, o form é submetido a uma função controladora definida na rota (geralmente via algo como `Route::post('/algo', [NomeController::class, 'nomeDaFuncao'])->name('nomeDaRota');`). Essa função atua como callback da submissão.

Nesta fase, não gravamos ainda os dados na base de dados. Em vez disso, armazenamos temporariamente os dados do formulário na sessão, para serem utilizados na etapa seguinte.

```php
public function gravar_session_para_proxima(Request $request){

        session(['user_data' => [
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        ]]);

  // OU, de forma equivalente:
  /*  $request->session()->put('user_data', [
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        ]);*/
}
```
Na função `gravar_session_para_proxima`, capturamos os valores de input e guardamos na sessão em um array associativo cujo nome é "user_data" e possui pares de chave e valor (key e value). 


2. Transação de Base de Dados
Na segunda etapa (submissão do segundo formulário), executamos três ações: (1) recuperamos os dados armazenados na sessão durante a primeira etapa, (2) combinamos com os dados fornecidos no segundo formulário e, só então,  (3) executamos a gravação no banco de dados dentro de uma transação única.

Esse mecanismo garante que ambos os registos (uma linha da tabela `users` e outra linha na tabela `user_details`) sejam criados simultaneamente. Ou seja, são criados juntos ou não são criados.
Caso ocorra qualquer erro durante a operação (ex: falha de validação, erro de conexão, exceção ao salvar), a transação será automaticamente revertida (`rollback`), e nenhum dos dados será persistido.

O método `transaction` da classe `DB` (`DB::transaction`) recebe como argumento uma função anônima (closure), que agrupa todas as operações que devem ser executadas atomicamente.

```php
public function capturar_session_e_inputs_e_gravar_db(Request $request)
{
    if (!session()->has('user_data')) {
        return redirect()->route('welcome');
    }

    DB::transaction(function () use ($request) {
        $userData = session('user_data');

        $user = User::create($userData);

        $userDetails = new UserDetails([
            'user_id'   => $user->id,
            'foto'      => $request->foto,
            'telemovel' => $request->telemovel,
            'idade'     => Carbon::parse($request->data_nascimento)->age,
        ]);

        $userDetails->save();
    });

    return redirect()->route('registro.sucesso');
}
```
Então, a função `capturar_session_e_inputs_e_gravar_db`: recupera os dados do primeiro formulário armazenados na sessão (linha 66), cria o utilizador na tabela `users` (linha 68) e cria os detalhes do utilizador com base nos inputs do segundo formulário (linhas 70 a 77).


✅ Vantagens
- Evitamos registos órfãos (user sem user_detail).
- Mantemos a base de dados limpa e consistente.

## Observação: O ciclo de vida da sessão

Por padrão, os dados da sessão serão armazenados em arquivos dentro do diretório `storage/framework/sessions` e o seu ciclo de vida depende das configurações estabelecidas em `config/sessions`. 

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