# Conexão com Base de Dados no Laravel
Após rodar os scripts localmente, as bases de dados estarão criadas no seu servidor.

## Rodar o script
Podemos rodar o script da base de dados localmente, através do WorkBench, por exemplo, ou rodar a partir do Laravel.

Para a segunda opção, vamos:
1. Gravar o script no projeto (database/scripts)
[🔗 Abrir file](file:///C:/Users/CESAE/Desktop/Migracao/locacao_carros.sql)
[🔗 Abrir file](file:///C:/Users/CESAE/Desktop/Migracao/locacao_casas_ferias.sql)


2. Criar uma migração. 
```bash
php artisan make:migration import_database
```
3. Alterar as datas das migrações de forma que 

Este comando gera uma migração, e no método up() poderá chamar:
```php
 public function up(): void
    {
        DB::unprepared(file_get_contents(database_path('scripts/locacao_carro.sql')));
        //OU
        //DB::connection('nome_conexao')->unprepared(file_get_contents(database_path('scripts/nome_arquivo.sql')));
    }
```
Ou, uma versão pouco mais robusta, dividir o script em instruções individuais para executar *apenas* instruções seguras:
[🔗 Abrir Exemplo](file:///C:/Users/CESAE/Desktop/Migracao/import_database.php)

## Conectar o Laravel à base `locacao_carros` ou `locacao_casas_ferias` 
No `.env`, mudar as credenciais do banco:

```php
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
#nome da base de dados
DB_DATABASE=locacao_carros #locacao_casas_ferias
DB_USERNAME=root
DB_PASSWORD= #password, se tiver
```

## Verificar `config/database.php` 
Garantir que as variáveis dispostas no `.env` estão corretamente configuradas.

## Executar a migração 
```bash
php artisan migrate
```

Isso criará a tabela users, password_resets, personal_access_tokens, etc, na base de dados.

⚠️ Caso já existisse uma tabela `users` na base, acusaria erro. Nesse caso, apenas criem uma migração para adicionar campos.

```bash
php artisan tinker
DB::select('SHOW TABLES');
```

## Criar migrações
Para criar migrações — seja para adicionar, alterar ou remover campos em tabelas existentes, criar novas tabelas ou excluir tabelas — utilizamos o seguinte comando (modelo):
```bash
php artisan make:migration nome_migracao
```
Este comando cria um arquivo de migração no diretório database/migrations, com o nome no formato: `YYYY_MM_DD_HHmmss_nome_da_migracao.php` (dia e hora da execução do comando e o nome enunciado no comando).

No lugar de `nome_migracao`, usamos uma descrição clara do que a migração fará. Exemplos:
- create_cidades_table (para criar a tabela cidades)
- add_telefone_to_users_table (para adicionar a coluna telefone na tabela users)
- drop_column_from_tabela_cidades (para remover uma coluna da tabela cidades)

No conteúdo do arquivo, há dois métodos:
🔼 up():  ações que devem ser executadas ao aplicar a migração (por exemplo, criar ou alterar tabelas e colunas).
É executado com: `php artisan migrate`.
🔽 down(): ações que revertem o que foi feito no up(). Por isso, é geralmente usado para desfazer alterações (remover colunas ou tabelas, por exemplo). É executado com: `php artisan migrate:rollback`.

### Criar migração para campos adicionais em users
Como a tabela já existe, esta pode ser modificada com `--table=users`:

```bash
php artisan make:migration add_extra_fields_to_users_table --table=users
```

###  Criar a/s tabela/s necessárias
```bash
php artisan make:migration create_locacoes_table
```

## Executar as migrações normalmente
```bash
php artisan migrate
```