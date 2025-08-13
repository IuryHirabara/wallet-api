# Wallet API

A simple Wallet API to show common money operations between accounts.

## Requirements

-   `zip` and `unzip` extensions
-   PHP `^8.2` with `php-xml` and `php-dom` extensions
-   Composer
-   Docker and Docker Compose

## Setup Guide

Clone the project

```sh
git clone https://github.com/IuryHirabara/wallet-api.git
```

```sh
cd wallet-api
```

Create the .env file

```sh
cp .env.example .env
```

Update these environment variables in .env file

```dosini
DB_HOST=mysql
DB_USERNAME=yourusernamehere
DB_PASSWORD=yourpasswordhere
```

Install the dependencies

```sh
composer install
```

Execute containers with Laravel Sail

```sh
./vendor/bin/sail up -d
```

Generate the APP_KEY

```sh
./vendor/bin/sail artisan key:generate
```

Run migrations

```sh
./vendor/bin/sail artisan migrate
```

(Optional) Run tests

```sh
./vendor/bin/sail pest
```
