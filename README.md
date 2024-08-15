
# Setup da API

### Passo a passo
Clone Repositório
```sh
git clone https://github.com/Lfseibel/Buzzvel-Test.git holiday_api
```
```sh
cd holiday_api/
```

Atualize as variáveis de ambiente do arquivo .env
```dosini
APP_NAME="Nome que desejar"
APP_URL=http://localhost:8989

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=nome_que_desejar_db
DB_USERNAME=root
DB_PASSWORD=root

CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```

Suba os containers do projeto
```sh
docker-compose up -d
```

Acesse o container app com o bash
```sh
docker-compose exec app bash
```

Instale as dependências do projeto
```sh
composer install
```

Gere a key do projeto Laravel
```sh
php artisan key:generate
```

Gere a key do projeto Laravel
```sh
php artisan migrate
```

Acesse o projeto
[http://localhost:8989](http://localhost:8989)

# Holiday Plan API

## Overview

The Holiday Plan API allows users to manage holiday plans for the year 2024. This RESTful API supports CRUD operations (Create, Read, Update, Delete) on holiday plans and includes authentication, validation, and PDF generation features.

## Features

- **Authentication**: Secure the API using Laravel Sanctum Tokens.
- **CRUD Operations**: Create, read, update, and delete holiday plans.
- **PDF Generation**: Generate PDF documents summarizing holiday plan details.
- **Validation**: Ensure data integrity with appropriate validation rules.

## Holiday Plan Schema

- **Title**: The title of the holiday plan.
- **Description**: A brief description of the holiday plan.
- **Date**: The date of the holiday plan in `YYYY-MM-DD` format.
- **Location**: The location of the holiday plan.
- **Participants** (Optional): List of participants in the holiday plan.

## API Endpoints

### Authentication

- **POST /api/v1/setup**
  - **Description**: Authenticate a user and return a token.
  - **Request Parameters**:
    - `name`: User name
    - `email`: User email
    - `password`: User password
  - **Response**: 
    - `master`: Master Authentication token
    - `update`: Update & Create Authentication token
    - `basic`: Basic Authentication token

### Holiday Plans

- **POST /api/v1/holidays**
  - **Description**: Create a new holiday plan.
  - **Request Parameters**:
    - `Header-Authorization`: Bearer Token
    - `title`: Required
    - `description`: Required
    - `date`: Required, date format `YYYY-MM-DD`
    - `location`: Required
    - `participants`: Optional, string of participant names
  - **Response**: Holiday plan details with status 201.

- **GET /api/v1/holidays**
  - **Description**: Retrieve all holiday plans.
  - **Request Parameters**:
    - `Header-Authorization`: Bearer Token
  - **Response**: Array of holiday plans with status 200.

- **GET /api/v1/holiday/{id}**
  - **Description**: Retrieve a specific holiday plan by ID.
  - **Request Parameters**:
    - `Header-Authorization`: Bearer Token
    - `id`: ID of the holiday plan
  - **Response**: Holiday plan details with status 200. Returns 404 if not found.

- **PUT or PATCH /api/v1/holiday/{id}**
  - **Description**: Update an existing holiday plan.
  - **Request Parameters**:
    - `Header-Authorization`: Bearer Token
    - `id`: ID of the holiday plan
    - `title`: Required
    - `description`: Required
    - `date`: Required, date format `YYYY-MM-DD`
    - `location`: Required
    - `participants`: Optional, string of participant names
  - **Response**: Updated holiday plan details with status 200. Returns 404 if not found.

- **DELETE /api/v1/holiday/{id}**
  - **Description**: Delete a holiday plan.
  - **Request Parameters**:
    - `Header-Authorization`: Bearer Token
    - `id`: ID of the holiday plan
  - **Response**: Status 204 if successful. Returns 404 if not found.

- **GET /api/v1/pdf/holiday/{id}**
  - **Description**: Generate a PDF document for a specific holiday plan.
  - **Request Parameters**:
    - `Header-Authorization`: Bearer Token
    - `id`: ID of the holiday plan
  - **Response**: PDF document with status 200. Returns 404 if not found.
