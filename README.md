# Laravel getting started

Example of how running Laravel projects on Liara.

Read more on Liara docs: https://docs.liara.ir/app-deploy/laravel/getting-started


## Running Locally

Make sure you have [PHP](https://www.php.net/) and [Composer](https://getcomposer.org/)

```sh
git clone https://github.com/liara-cloud/laravel-getting-started
cd laravel-getting-started
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
```

