# Slim Framework 4 Skeleton Application

[![Coverage Status](https://coveralls.io/repos/github/slimphp/Slim-Skeleton/badge.svg?branch=master)](https://coveralls.io/github/slimphp/Slim-Skeleton?branch=master)

Use this skeleton application to quickly setup and start working on a new Slim Framework 4 application. This application uses the latest Slim 4 with Slim PSR-7 implementation and PHP-DI container implementation. It also uses the Monolog logger.

This skeleton application was built for Composer. This makes setting up a new Slim Framework application quick and easy.

## Install the Application

Run this command from the directory in which you want to install your new Slim Framework application. You will require PHP 7.4 or newer.

```bash
composer create-project slim/slim-skeleton [my-app-name]
```

Replace `[my-app-name]` with the desired directory name for your new application. You'll want to:

* Point your virtual host document root to your new application's `public/` directory.
* Ensure `logs/` is web writable.

To run the application in development, you can run these commands 

```bash
cd [my-app-name]
composer start
```

Or you can use `docker-compose` to run the app with `docker`, so you can run these commands:
```bash
cd [my-app-name]
docker-compose up -d
```
After that, open `http://localhost:8080` in your browser.

Run this command in the application directory to run the test suite

```bash
composer test
```

That's it! Now go build something cool.

## Database & Migrations (PostgreSQL)

This project uses Doctrine ORM. The container registers `Doctrine\ORM\EntityManager` and reads DB settings from `app/settings.php`.

Install dependencies:

```bash
cd api
composer require doctrine/orm doctrine/dbal doctrine/annotations
composer require --dev doctrine/migrations
```

Configure your environment variables (example `.env` or your server env):

```
DB_DRIVER=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=your_database
DB_USERNAME=your_user
DB_PASSWORD=your_password
```

Basic usage:

- EntityManager is available via DI: request the `Doctrine\\ORM\\EntityManager` from the container.
- If you want migrations, set up `doctrine/migrations` and run `vendor/bin/doctrine-migrations migrate` after configuring migration paths.

Example composer commands to generate entities/migrations (after installing packages):

```bash
cd api
# create entities manually under src/Domain
# generate migration (if using doctrine/migrations):
vendor/bin/doctrine-migrations diff
vendor/bin/doctrine-migrations migrate
```

If you want, I can create an example `User` entity and update the repository wiring to use Doctrine repositories.
