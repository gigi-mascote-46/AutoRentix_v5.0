# Criar o Projeto

## Escolher o nome do Projeto

## Executar os comandos:

1. Criar o novo projeto
```bash
laravel new Locacao --dev
 > none
 > #enter
 > mysql
 > no
 > yes
```

2. Entrar no projeto criado
```bash
cd Locacao
```

3. Descarregar o pacote `Breeze` com `blade`
```bash
composer update

composer require laravel/breeze --dev

php artisan breeze:install
> blade
> #enter #o que preferir
> #enter
```

## Passos que vamos "pular"
1. Como já demos `yes` na criação do projeto, não é preciso executar:
```bash
npm install && npm run dev
```

2. Neste momento, poderíamos executar a migração. Mas, como vamos nos conectar a uma base de dados existente, não será preciso.
```bash
php artisan migrate
```