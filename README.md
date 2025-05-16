# Sistema de Gerenciamento de Biblioteca

Este sistema permite gerenciar usuários, livros (classificados por gênero) e controle de empréstimos, garantindo visibilidade sobre a disponibilidade dos livros e prazos de devolução.

## Instalação

1. Clone o repositório
2. Execute `composer install`
3. Copie `.env.example` para `.env` e configure o banco
4. Rode as migrations com `php artisan migrate`
5. Inicie o servidor com `php artisan serve`

## Tecnologias

- Laravel 11
- PHP 8.3
- MySQL
