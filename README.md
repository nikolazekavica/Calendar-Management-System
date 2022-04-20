# Calendar Management System

## Intro

Code for the REST API for Calendar Management System project. 

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

Run he following command from inside your project folder to run migration script

```php artisan migrate```

Run he following command from inside your project folder to generate the passport api key

```php artisan passport:client --password```

1) Set name ex: Calendar Password Grant Client
2) Next continue with 'enter' command
3) Copy from table oauth_clients: 'id' and 'secret' Ex:(id = 961bbc08-3dcc-4483-93c4-0dfab6895e01, secret = cm9tXLSXMivTsFtxLcizlzxmfEztLzkUyndgLhYH)
  And put in .env file parts: PASSPORT_CLIENT_ID and PASSPORT_CLIENT_SECRET
  ex: 
  
  PASSPORT_CLIENT_ID=961095d1-e291-4cbc-9c8c-b8ab41a417a8
  PASSPORT_CLIENT_SECRET=hicTuEtsIUwBz0TKCID8i5KnMGWWx3ZH4VPDMwWj

Run he following command from inside your project folder to generate db seeds:

```php artisan db:seed --class=RoleSeeder```

To access laravel homepage just use [http://0.0.0.0:8080](http://0.0.0.0:8080)

## Dev environment

<p align="center"><img src="https://www.docker.com/sites/default/files/mono-horizontal.png" height="80"><img src="https://laravel.com/assets/img/components/logo-laravel.svg" height="60"> <img src="https://www.mysql.com/common/logos/includes-mysql-125x64.png"  height="60">   <img src="https://cdn-1.wp.nginx.com/wp-content/uploads/2018/09/nginx-social-share-1.png" height="60">
</p>

<p align="center">
<img src="https://img.shields.io/badge/Laravel-v9.2-blue.svg">
<img src="https://img.shields.io/badge/MySQL-v8.0.28-blue.svg">
<img src="https://img.shields.io/badge/PHP-v8.0.16-blue.svg">
</p>