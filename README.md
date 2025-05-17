# Desafio Laravel - API + Blade (Sanctum)

## ✨ Descrição

Este projeto é uma aplicação completa Laravel 12 com:

* Autenticação via **Laravel Sanctum** (token)
* Frontend em **Blade** consumindo as **rotas da API**
* Sistema de **cadastro e login de usuários**
* Recuperação de senha com envio de e-mail via **Mailhog**
* Integração com **API ViaCEP** para preenchimento automático de endereço
* **Painel Admin** com métricas e gerenciamento de usuários
* Filtros dinâmicos por cidade, estado e email
* ✔ Arquitetura com **princípios SOLID** e separação clara entre lógica e camada de apresentação

---

## 🌐 Como rodar o projeto com Docker

1. Clone o repositório e entre na pasta:

```bash
git clone <repo> desafio-laravel
cd desafio-laravel
```

2. Suba o ambiente:

```bash
docker-compose up -d
```

3. Acesse o container:

```bash
docker exec -it desafio_laravel_app bash
```

4. Instale dependências e rode as migrations:

```bash
composer install
php artisan migrate --seed
```

5. Acesse o sistema:

* Frontend (Blade): [http://localhost:8000/login](http://localhost:8000/login)
* Mailhog: [http://localhost:8025](http://localhost:8025)

---

## 🏢 Rotas da API (REST)

### Autenticação

#### POST `/api/register`

Cria um novo usuário. Exemplo:

```json
{
  "name": "João",
  "email": "joao@email.com",
  "password": "123456",
  "password_confirmation": "123456",
  "cep": "01001000",
  "number": "123"
}
```

#### POST `/api/login`

Autentica e retorna token:

```json
{
  "email": "joao@email.com",
  "password": "123456"
}
```

#### POST `/api/logout`

Revoga o token atual (protegido).

#### GET `/api/me`

Retorna dados do usuário autenticado.

---

### Recuperação de senha

#### POST `/api/forgot-password`

Envia e-mail com link de redefinição:

```json
{
  "email": "joao@email.com"
}
```

#### POST `/api/reset-password`

Redefine senha:

```json
{
  "token": "...",
  "email": "joao@email.com",
  "password": "nova",
  "password_confirmation": "nova"
}
```

---

### Usuários e Admin

#### GET `/api/users`

Lista os usuários (admin apenas). Aceita filtros:

* `city=São Paulo`
* `state=SP`
* `email=joao`

#### DELETE `/api/users/{id}`

Exclui um usuário (admin).

#### GET `/api/admin/metrics`

Retorna métricas de usuários por cidade e estado.

---

## 📘 Rotas Blade (frontend)

* `/login` - tela de login
* `/register` - cadastro
* `/dashboard` - painel do usuário comum (listagem simples)
* `/admin` - painel admin com métricas, filtros e exclusão
* `/forgot-password` - recuperação de senha
* `/reset-password/{token}` - redefinição

---

## ✅ Testes

### Execução:

```bash
php artisan test
```

### Cobertura:

* `AuthControllerTest`: login, registro, logout, falhas, token
* `UserServiceTest`: criação com/sem CEP válido
* `AdminRoutesTest`: acesso controlado por perfil

---

## 🤝 Considerações finais

* Arquitetura limpa com Controllers finos e uso de **Services**
* Views em Blade usam **fetch + token Sanctum** (API-first)
* **Proteção de rotas admin** por middleware + checagem de perfil
* Integração com **ViaCEP** para CEP
* **Mailhog** simula envio de e-mails com sucesso
* Sistema pr- Sistema pr\u00onto para ser escalado e testado

---