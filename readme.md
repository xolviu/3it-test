## Requirements

- PHP
- Composer
- Node.js
- MariaDB


## Setup
Clone the repository:

```sh
$ git clone https://github.com/xolviu/3it-test.git
```

Install dependencies

```sh
$ composer install
$ npm install
```

Configure .env variables

```
DB_CONNECTION
DB_HOST
DB_PORT
DB_DATABASE
DB_USERNAME
DB_PASSWORD
```

Run database migrations

```sh
$ php artisan migrate
```

Serve the application

```sh
$ npm run dev
$ php artisan serve
```
