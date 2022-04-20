# Calendar Management System

## Intro

Calendar Management System API.

In this system, the date timezone is set to Europe/Belgrade. Date format is d-m-Y and the time format is H:i.

User have to register and verification his account first. After that user can login in application.

Each of users can have 'regular' or 'admin' role with which they access specified routes.

Depending on the role users can create,filtered and see own availabilities.

Availabilities can be recurring weekly.

## How to run the Dev environment

install PHP 8.0.16 

Install Docker version 4.5.1 on your Dev machine [Docker](https://www.docker.com).

On the project folder run the following command in order use composer to generate the vendor folder

Run the following command from inside your project folder 

``` composer update ```

Run the following command from inside your project folder

``` docker-compose build --no-cache```

Run the following command from inside your project folder

``` docker-compose up -d ```

Run the following command from inside your project folder 

``` composer dump-autoload ```

Run the following command from inside your project folder to generate the a project key

``` php artisan key:generate ``` 

Run he following command from inside your project folder to run migration script

```php artisan migrate```

Run he following command from inside your project folder to generate the passport api key

```php artisan passport:client --password```

1) Set name ex: Calendar Password Grant Client
2) Next continue with 'enter' command
3) Copy from table oauth_clients: 'id' and 'secret'
4) Put in .env file parts: PASSPORT_CLIENT_ID and PASSPORT_CLIENT_SECRET

Run he following command from inside your project folder to generate the passport secret and public keys

``` php artisan passport:keys ```

Run he following command from inside your project folder to generate db seeds:

```php artisan db:seed --class=RoleSeeder```

To access laravel homepage just use [http://0.0.0.0:8080](http://0.0.0.0:8080)

## Dev environment

<p align="center">
<img src="https://img.shields.io/badge/Laravel-v9.2-blue.svg">
<img src="https://img.shields.io/badge/MySQL-v8.0.28-blue.svg">
<img src="https://img.shields.io/badge/PHP-v8.0.16-blue.svg">
</p>