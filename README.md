# 🚗 DrivePoint - Plataforma de Aluguer de Viaturas

Este projeto é uma aplicação web moderna desenvolvida em **Laravel** para aluguer de carros, com pesquisa avançada, reservas seguras e gestão de viaturas.

## ✨ Funcionalidades

- Registo e login de utilizadores (com validação de NIF e feedback visual)
- Pesquisa avançada de viaturas com filtros dinâmicos (marca, cor, preço, combustível, transmissão, localização)
- Página de resultados e detalhe da viatura (com imagem associada ao ID do carro)
- Sistema de reservas com validação de datas, reCAPTCHA e confirmação Multibanco fictícia
- Envio de email com detalhes da reserva (Mailtrap)
- Geração de PDF com resumo da reserva
- Dashboard administrativo:
  - Gestão de viaturas (CRUD, upload e associação automática de imagens)
  - Gestão de reservas (cancelar, imprimir, enviar email)
  - Visualização de transações
- Edição de perfil do utilizador
- Notificações e feedback visual para ações e erros
- Layout responsivo, moderno e acessível

## 📦 Estrutura

- `app/Models`: Modelos como `BemLocavel`, `Reserva`, `Marca`, `User`, `Localizacao`
- `app/Http/Controllers`: Controladores de autenticação, viaturas, reservas, dashboard, pesquisa, etc.
- `resources/views`: Vistas Blade para reservas, pesquisa, perfil, dashboard, layouts e componentes
- `routes/web.php`: Definição das rotas da aplicação
- `database/migrations`: Migrações para criação das tabelas
- `database/seeders`: Seeders para dados de exemplo e associação de imagens
- `public/images`: Imagens dos carros (nome do ficheiro = ID do bem locável)

## ⚙️ Requisitos

- PHP >= 8.1
- Composer
- Node.js e npm
- MySQL (ou SQLite para testes)

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
```

## 🖼️ Associação de Imagens
- As imagens dos carros devem estar em `public/images` com o nome igual ao ID do bem locável (ex: `1.jpg`, `2.jpg`)
- O seeder `AssociarImagensSeeder` associa automaticamente as imagens aos registos

## 🧪 Testes
- Testes unitários e de feature com PestPHP
- Configuração para base de dados em memória (`phpunit.xml`)
- Comando para correr todos os testes:
  ```bash
  php artisan test
  ```

## 📄 Licença
Projeto académico para fins educativos.
