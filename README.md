# Commercial Insurance Test Project



## Installation

Take a copy of the .env.example and save it as .env

```bash
APP_URL=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

From the project root folder run the below commands

Install Vendor Files

```bash
composer install
```

Generate Application Key

```bash
php artisan key:generate
```

Run the Migration

```bash
php artisan migrate
```

Seed the Database

```bash
php artisan db:seed
```

Clear All the Cache

```bash
php artisan optimize:clear

```

## Demo Admin User
```bash
Email: admin@yopmail.com
Password: test1234
```