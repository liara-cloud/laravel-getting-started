# Liara Object Storage + Laravel
## Steps
```
git clone https://github.com/liara-cloud/laravel-getting-started.git
```
```
cd laravel-getting-started
```
```
git checkout object-storage
```
```
composer install 
```
```
mv .env.example .env # and set ENVs
```
```
php artisan key:generate
```
```
touch database/database.sqlite
```
```
php artisan migrate
```
```
php artisan serve
```
- check `http://127.0.0.1:8000` to manage your bucket

## Need More Info?
- [Liara Docs](https://docs.liara.ir/object-storage/how-tos/connect-via-platform/laravel/)
- [Flysystem Docs](https://flysystem.thephpleague.com/docs/adapter/aws-s3-v3/)
