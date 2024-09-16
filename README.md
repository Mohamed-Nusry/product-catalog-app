# Instructions

## Please follow below steps:
- Clone `git clone {repo}`
- Copy `.env.example` to `.env`
- Open local server and create a MYSQL database call `product_catalog_db`
- Run `composer install`
- Run `npm install` 
- Run `php artisan key:generate`
- Run `php artisan migrate:fresh --seed`
- Run `php artisan storage:link` 
- Run `php artisan test` to run unit test cases
- Run `npm run dev` in a terminal (Keep the terminal running)
- Run `php artisan serve` in another terminal (Keep the terminal running)
- The app will run on `http://localhost:8000` by default
- The Postman collection is added under `Prerequisites` folder

# Used Versions

PHP 8.2
Laravel 10
MYSQL

# Sample Credentials

Email - `admin@example.com`
Password - `admin@123`

Email - `moderator@example.com`
Password - `moderator@123`

Email - `user@example.com`
Password - `user@123`