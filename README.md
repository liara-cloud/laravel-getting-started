# ChatApp using Soketi in Laravel
## Installation (Local)

- create a [soketi one-click-app](https://console.liara.ir/apps/create?initialTab=one-click-apps) on Liara
```
git clone https://github.com/liara-cloud/laravel-getting-started.git
```
```
cd laravel-getting-started
```
```
git checkout soketi
```
```
composer install --ignore-platform-reqs
```
```
cp .env.example .env # rename .env.example to .env in Windows
```
```
touch database/database.sqlite # create database/database.sqlite in Windows
```
```
php artisan key:generate
```
```
php artisan migrate:fresh --seed
```
```
php artisan storage:link
```
- open your `.env` file and configure the `PUSHER_*` credentials:

```
PUSHER_APP_KEY=app-key
PUSHER_APP_ID=app-id
PUSHER_APP_SECRET=app-secret
PUSHER_HOST=127.0.0.1
PUSHER_PORT=6001
```
- set pusher envs in resources/js/bootstrap.js directly with no https
```
npm install && npm run dev
```
```
php artisan serve
```

## Installation (Liara)
- create a [soketi one-click-app](https://console.liara.ir/apps/create?initialTab=one-click-apps) on Liara
- create a [laravel app](https://console.liara.ir/apps/create) on Liara
```
git clone https://github.com/liara-cloud/laravel-getting-started.git
```
```
cd laravel-getting-started
```
```
git checkout soketi
```
- set pusher envs in resources/js/bootstrap.js directly with no https
- add envs to app on Liara
```
liara deploy
```

### Authentication

The seeders created three accounts. All accounts can be accessed with the password `password`:

- `test@test.com`
- `test2@test.com`
- `test3@test.com`


