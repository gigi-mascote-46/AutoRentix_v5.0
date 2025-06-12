# Documentação sobre Cross-Origin Resource Sharing (CORS)

## O que é o CORS?

Cross-Origin Resource Sharing (CORS) é uma funcionalidade de segurança implementada pelos navegadores web para restringir que páginas web façam pedidos a um domínio diferente daquele que serviu a página. Esta política é conhecida como "same-origin policy". O CORS permite, de forma controlada, relaxar esta política e permitir que domínios confiáveis acedam a recursos num servidor.

## Por que é necessário o CORS?

Quando uma aplicação web, a correr num navegador, tenta fazer um pedido a um servidor backend hospedado numa origem diferente (domínio, protocolo ou porta), o navegador aplica o CORS para evitar que sites maliciosos acedam a dados sensíveis de outros domínios sem permissão.

Por exemplo, se o frontend estiver servido em `http://127.0.0.1:8000` e tentar aceder a uma API em `http://localhost/vehicles/1`, o navegador bloqueia o pedido a menos que o backend permita explicitamente através dos cabeçalhos CORS.

## O problema

Neste projeto, o frontend e o backend estão servidos em origens diferentes (`http://127.0.0.1:8000` vs `http://localhost`). Sem uma configuração adequada de CORS no backend, o navegador bloqueia os pedidos API devido à ausência do cabeçalho `Access-Control-Allow-Origin`.

Isto resulta em erros como:

```
Access to XMLHttpRequest at 'http://localhost/vehicles/1' from origin 'http://127.0.0.1:8000' has been blocked by CORS policy: No 'Access-Control-Allow-Origin' header is present on the requested resource.
```

## Como o CORS é tratado neste projeto

Anteriormente, o projeto usava o pacote `fruitcake/laravel-cors` para gerir o CORS, mas este pacote não é compatível com o Laravel 12, que é a versão usada neste projeto.

Para resolver este problema, foi criado um middleware personalizado para CORS:

- O middleware adiciona os cabeçalhos CORS necessários a todas as respostas HTTP.
- Permite pedidos da origem do frontend `http://127.0.0.1:8000`.
- Suporta os métodos HTTP comuns (`GET, POST, PUT, DELETE, OPTIONS`).
- Trata os pedidos preflight `OPTIONS` respondendo com um status 200 OK.

O middleware está registado globalmente em `app/Http/Kernel.php` para garantir que todos os pedidos passam por ele.

## Como atualizar ou configurar o CORS

Se a origem do frontend mudar, deve atualizar o cabeçalho `Access-Control-Allow-Origin` no middleware localizado em:

```
app/Http/Middleware/CorsMiddleware.php
```

Por exemplo, para permitir múltiplas origens ou todas as origens (não recomendado em produção), pode modificar o middleware conforme necessário.

## Resumo

O CORS é essencial para permitir pedidos seguros entre o frontend e o backend neste projeto. O middleware personalizado garante que o frontend pode comunicar com a API do backend sem ser bloqueado pelo navegador devido à política CORS.

Se encontrar problemas relacionados com CORS no futuro, verifique a configuração do middleware e atualize as origens permitidas conforme necessário.
