# 🚗 DrivePoint - Plataforma de Aluguer de Viaturas

Este projeto é uma aplicação web desenvolvida em **Laravel** que permite aos utilizadores pesquisarem viaturas disponíveis, realizarem reservas, gerir carros e acompanhar o histórico de reservas. Foi construído como parte de um projeto académico com funcionalidades completas tanto para utilizadores como para administradores.

## ✨ Funcionalidades

- Registo e login de utilizadores
- Pesquisa por viaturas disponíveis com base em datas
- Página de resultados e detalhe da viatura
- Sistema de reservas com confirmação
- Envio de email com detalhes da reserva
- Geração de PDF com resumo da reserva
- Dashboard administrativo:
  - Gestão de viaturas (CRUD)
  - Gestão de reservas
  - Visualização de transações

## 📦 Estrutura

- `app/Models`: Modelos como `BemLocavel`, `Reserva`, `Marca`, `User`
- `app/Http/Controllers`: Controladores de autenticação, viaturas, reservas, dashboard, etc.
- `resources/views`: Vistas em Blade com componentes reutilizáveis, layouts, páginas de login/registo, reservas, pesquisa e painel de administração
- `routes/web.php`: Definição das rotas da aplicação
- `database/migrations`: Migrações para criação das tabelas necessárias

## ⚙️ Requisitos

- PHP >= 8.1
- Composer
- Node.js e npm
- MySQL (ou outro sistema compatível)

## 🚀 Instalação

```bash
git clone https://github.com/seu-utilizador/alugar_carros.git
cd alugar_carros
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install && npm run build
php artisan serve
