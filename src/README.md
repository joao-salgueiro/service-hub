# Service Hub

Service Hub é uma plataforma para conectar trabalhadores autônomos a clientes que buscam serviços em sua região. O objetivo é facilitar o cadastro de profissionais, a busca por serviços e a contratação de forma simples e eficiente.

## Funcionalidades
- Cadastro de usuários (clientes e trabalhadores autônomos)
- Cadastro de serviços oferecidos pelos profissionais
- Disponibilidade de agenda e horarios livres 
- Busca de trabalhadores e serviços por região
- Contratação de serviços (agendamento/booking)
- Avaliação de profissionais após a prestação de serviço
- Upload de fotos dos serviços

## Estrutura do Projeto
- **Backend:** Laravel (PHP)
- **Banco de Dados:** MySQL (ou compatível)
- **Frontend:** Blade (Laravel), com possibilidade de integração com frameworks JS
- **Autenticação:** JWT ou Sanctum
- **Gerenciamento de dependências:** Composer (PHP), NPM/Yarn (JS)

## Principais Tabelas
- `users`: Usuários do sistema (clientes e profissionais)
- `providers`: Trabalhadores autônomos
- `customers`: Clientes
- `services`: Serviços oferecidos
- `photos`: Fotos dos serviços
- `bookings`: Contratações/agendamentos
- `reviews`: Avaliações dos serviços

## Como rodar o projeto
1. Clone o repositório
2. Instale as dependências PHP: `composer install`
3. Instale as dependências JS: `npm install`
4. Configure o arquivo `.env` com as credenciais do banco de dados
5. Rode as migrations: `php artisan migrate`
6. Inicie o servidor: `php artisan serve`

## Estrutura de Pastas
- `app/Models`: Modelos Eloquent
- `app/Http/Controllers`: Controladores
- `database/migrations`: Migrations do banco
- `routes/`: Rotas da aplicação
- `resources/views`: Views Blade

## Status do Projeto
- Estrutura de banco de dados pronta
- Modelos principais criados
- Autenticação básica implementada


## Licença
[MIT](LICENSE)
