# AutoRentix

AutoRentix é um sistema completo para aluguer de viaturas desenvolvido em Laravel (backend) com uma interface frontend em Vue.js (opcional). O projeto inclui funcionalidades de gestão de viaturas, reservas, pagamentos, autenticação de utilizadores e administração geral.

---

****ESTE PROJECTO FOI DESENVOLVIDO NO ÂMBITO DA UC "INTEGRAÇÃO DE SISTEMAS" DO CURSO DE SOFTWARE DEVELOPER DO CESAE DIGITAL - 2025****

## Índice

- [Descrição](#descrição)
- [Funcionalidades](#funcionalidades)
- [Tecnologias Utilizadas](#tecnologias-utilizadas)
- [Estrutura do Projeto](#estrutura-do-projeto)
- [Modelos e Tabelas](#modelos-e-tabelas)
- [Controllers](#controllers)
- [Factories e Seeders](#factories-e-seeders)
- [Configuração e Instalação](#configuração-e-instalação)
- [Desenvolvedor](#desenvolvedor)
- [Licença](#licença)

---

## Descrição

AutoRentix é uma aplicação que permite gerir um catálogo de viaturas para aluguer, permitindo a criação, edição e eliminação de bens locáveis (viaturas), gestão das suas características, localização, marca e tipo, além de gerir reservas feitas por utilizadores, respetivos pagamentos e estado de disponibilidade. 

O sistema foi pensado para ser modular, escalável e seguro.

---

## Funcionalidades

- **Gestão de Viaturas:** criação, edição, listagem e eliminação.
- **Gestão de Características:** definir atributos dos bens locáveis.
- **Gestão de Localizações e Marcas.**
- **Gestão de Tipos de Bens.**
- **Sistema de Reservas:** utilizadores podem reservar viaturas.
- **Pagamentos:** gestão de pagamentos associados às reservas.
- **Autenticação e Gestão de Utilizadores.**
- **API RESTful completa** para integração com frontend ou apps móveis.
- **Validação robusta e segurança aplicada a todas as operações.**

---

## Tecnologias Utilizadas

- **Backend:** Laravel (PHP)
- **Base de Dados:** MySQL
- **Frontend:** Vue.js (planeado/optional)
- **Autenticação:** Laravel Sanctum (ou padrão Laravel Auth)
- **Validação:** Laravel Form Requests / Validator
- **Outros:** Composer, Artisan commands

---

## Estrutura do Projeto

- **app/Models:** Modelos Eloquent para as entidades.
- **app/Http/Controllers:** Controllers RESTful com métodos CRUD.
- **database/migrations:** Scripts para criação das tabelas.
- **database/factories:** Factories para criação de dados fictícios.
- **database/seeders:** Seeders para popular a base de dados.
- **routes/api.php:** Rotas API para consumo do frontend.

---

## Modelos e Tabelas

- **BemLocavel:** Representa as viaturas para aluguer, relacionadas com Marca, TipoBem, Localizacao e Caracteristicas.
- **Caracteristica:** Características ou atributos dos bens.
- **Localizacao:** Localizações dos bens locáveis.
- **Marca:** Marcas dos bens.
- **TipoBem:** Tipos ou categorias de bens.
- **Reserva:** Reservas feitas pelos utilizadores.
- **Pagamento:** Pagamentos associados a reservas.
- **User:** Utilizadores do sistema.

---

## Controllers

Controllers RESTful implementados para todas as entidades:

- BemLocavelController
- CaracteristicaController
- LocalizacaoController
- MarcaController
- TipoBemController
- ReservaController
- PagamentoController
- UserController

Cada controller suporta os métodos padrão:

- index (listar)
- store (criar)
- show (mostrar detalhe)
- update (atualizar)
- destroy (eliminar)

---

## Factories e Seeders

- Factories para gerar dados falsos para teste.
- Seeders para popular tabelas iniciais como Marcas, Tipos, Características.
- Permite testes e desenvolvimento rápido.

---

## Configuração e Instalação

1. Clone o repositório:
   ```bash
   git clone https://github.com/usuario/autorentix.git
   cd autorentix

## Desenvolvedor

Responsável pelo projeto completo:

- Backend  
- Frontend  
- Segurança  
- UI Design  

Projeto desenvolvido por Angela Peixoto.

---


